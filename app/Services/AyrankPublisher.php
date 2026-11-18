<?php

namespace App\Services;

use App\Mail\BlogAutomationAlert;
use App\Models\Blog;
use App\Models\User;
use Carbon\CarbonInterface;
use DOMDocument;
use DOMElement;
use DOMXPath;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Throwable;

/** Saves AYRank articles as blog posts, matched by AYRank's article id. */
class AyrankPublisher
{
    protected const ALLOWED_TAGS = '<h1><h2><h3><h4><p><br><hr><ul><ol><li><strong><b><em><i><a><img><blockquote>'
        . '<figure><figcaption><table><thead><tbody><tr><th><td><code><pre>';

    protected const ALLOWED_ATTRIBUTES = [
        'a' => ['href', 'title'],
        'img' => ['src', 'alt', 'title', 'width', 'height'],
        'th' => ['colspan', 'rowspan', 'scope'],
        'td' => ['colspan', 'rowspan'],
    ];

    public function __construct(protected SiteSeo $siteSeo) {}

    public function save(array $article, array $publication, bool $isUpdate): Blog
    {
        $id = trim((string) ($article['id'] ?? ''));
        $title = trim(strip_tags((string) ($article['title'] ?? '')));

        if ($id === '' || $title === '') {
            throw new InvalidArgumentException('Article id and title are required');
        }

        $blog = Blog::withTrashed()->firstOrNew(['ayrank_id' => $id]);
        $wasLive = $blog->exists && !$blog->trashed() && $blog->is_published;
        $content = $this->content($article, $title);
        $mode = $publication['mode'] ?? null;
        $publish = $mode !== null ? $mode !== 'draft' : (!$isUpdate || !$blog->exists || $blog->is_published);
        $excerpt = $this->text($article, ['excerpt', 'summary', 'description', 'meta_description', 'seo.description', 'meta.description'])
            ?: Str::limit(trim(strip_tags($content)), 200);
        $tags = $this->tags($article['tags'] ?? []);

        $blog->fill([
            'title' => Str::limit($title, 250, ''),
            'slug' => $this->uniqueSlug((string) ($article['slug'] ?? '') ?: $title, $blog),
            'excerpt' => Str::limit($excerpt, 300),
            'content' => $content,
            'featured_image' => $this->heroImage($article['hero_image'] ?? null) ?? $blog->featured_image,
            'category' => Str::limit($this->text($article, ['category', 'category.name']) ?: ($blog->category ?: 'Insights'), 100, ''),
            'tags' => $tags,
            'seo_title' => Str::limit($this->text($article, ['seo_title', 'meta_title', 'seo.title', 'meta.title']) ?: $title, 60, ''),
            'seo_description' => Str::limit($this->text($article, ['seo_description', 'meta_description', 'seo.description', 'meta.description']) ?: $excerpt, 157),
            'seo_keywords' => Str::limit($this->text($article, ['seo_keywords', 'keywords', 'focus_keyword', 'seo.keywords']) ?: implode(', ', $tags), 250, ''),
            'is_published' => $publish,
        ]);

        $blog->author_id ??= (User::role(['superadmin', 'admin'])->first() ?? User::first())?->id;

        if ($publish && !$blog->published_at) {
            $blog->published_at = $this->date($article['published_at'] ?? null);
        }

        if ($blog->trashed()) {
            $blog->deleted_at = null;
        }

        $blog->save();
        Cache::forget('homepage_data');

        if ($publish) {
            $this->afterPublish($blog, !$wasLive);
        }

        return $blog;
    }

    public function unpublish(array $article): ?string
    {
        $id = trim((string) ($article['id'] ?? ''));
        $blog = $id === '' ? null : Blog::where('ayrank_id', $id)->first();

        if ($blog) {
            $blog->update(['is_published' => false]);
            Cache::forget('homepage_data');
        }

        return $blog?->ayrank_id;
    }

    protected function afterPublish(Blog $blog, bool $isNewlyLive): void
    {
        dispatch(function () use ($blog, $isNewlyLive) {
            $this->siteSeo->submitToIndexNow([SiteSeo::baseUrl() . "/blog/{$blog->slug}", SiteSeo::baseUrl() . '/blog']);

            if (!$isNewlyLive) {
                return;
            }

            try {
                Mail::to(config('mail.blog_alerts_to'))->send(new BlogAutomationAlert($blog));
            } catch (Throwable $e) {
                Log::error('AYRank post published but the admin alert failed', ['id' => $blog->id, 'error' => $e->getMessage()]);
            }
        })->afterResponse();
    }

    protected function content(array $article, string $title): string
    {
        $html = trim((string) ($article['html'] ?? ''));

        if ($html === '' && trim((string) ($article['markdown'] ?? '')) !== '') {
            $html = Str::markdown((string) $article['markdown'], ['html_input' => 'strip', 'allow_unsafe_links' => false]);
        }

        $content = $this->clean($this->withFaq($html, $article['faq'] ?? []), $title);

        if (trim(strip_tags($content)) === '') {
            throw new InvalidArgumentException('Article content is required');
        }

        return $content;
    }

    /** Add FAQs the article body does not already contain. */
    protected function withFaq(string $html, mixed $faq): string
    {
        $items = '';

        foreach (is_array($faq) ? $faq : [] as $item) {
            $question = trim(strip_tags((string) (is_array($item) ? ($item['question'] ?? $item['q'] ?? '') : '')));
            $answer = trim((string) (is_array($item) ? ($item['answer'] ?? $item['a'] ?? '') : ''));

            if ($question !== '' && $answer !== '' && !Str::contains(strip_tags($html), $question, true)) {
                $items .= '<h3>' . e($question) . '</h3><p>' . strip_tags($answer, '<strong><em><a><br>') . '</p>';
            }
        }

        return $items === '' ? $html : "{$html}<h2>Frequently Asked Questions</h2>{$items}";
    }

    /** Blog content is displayed as HTML, so keep only safe article markup. */
    protected function clean(string $html, string $title): string
    {
        $html = preg_replace('#<(script|style|iframe|object|embed|svg|math)\b.*?</\1>#is', '', $html);
        $html = strip_tags($html, self::ALLOWED_TAGS);

        $previous = libxml_use_internal_errors(true);
        $doc = new DOMDocument('1.0', 'UTF-8');
        $doc->loadHTML('<?xml encoding="UTF-8"><div id="ayrank-post">' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $root = $doc->getElementById('ayrank-post');

        if (!$root) {
            throw new InvalidArgumentException('Article content is not valid HTML');
        }

        foreach (iterator_to_array((new DOMXPath($doc))->query('.//*', $root)) as $element) {
            /** @var DOMElement $element */
            $tag = $element->tagName;
            $allowed = self::ALLOWED_ATTRIBUTES[$tag] ?? [];

            foreach (iterator_to_array($element->attributes) as $attribute) {
                if (!in_array($attribute->name, $allowed, true)) {
                    $element->removeAttribute($attribute->name);
                }
            }

            if ($tag === 'a' && !preg_match('#^(https?://|/|\#|mailto:|tel:)#i', trim($element->getAttribute('href')))) {
                $this->unwrap($element);
            } elseif ($tag === 'img' && !preg_match('#^(https?://|/)#i', trim($element->getAttribute('src')))) {
                $element->parentNode->removeChild($element);
            } elseif ($tag === 'h1') {
                $this->replaceHeading($doc, $element, $title);
            }
        }

        $clean = '';
        foreach (iterator_to_array($root->childNodes) as $node) {
            $clean .= $doc->saveHTML($node);
        }

        return trim($clean);
    }

    protected function unwrap(DOMElement $element): void
    {
        while ($element->firstChild) {
            $element->parentNode->insertBefore($element->firstChild, $element);
        }

        $element->parentNode->removeChild($element);
    }

    /** The page already shows the title as its main heading. */
    protected function replaceHeading(DOMDocument $doc, DOMElement $heading, string $title): void
    {
        if (strcasecmp(trim($heading->textContent), $title) === 0) {
            $heading->parentNode->removeChild($heading);
            return;
        }

        $replacement = $doc->createElement('h2');

        while ($heading->firstChild) {
            $replacement->appendChild($heading->firstChild);
        }

        $heading->parentNode->replaceChild($replacement, $heading);
    }

    protected function text(array $article, array $keys): string
    {
        foreach ($keys as $key) {
            $value = data_get($article, $key);

            if (is_array($value)) {
                $value = implode(', ', array_filter($value, 'is_string'));
            }

            if (is_scalar($value) && trim(strip_tags((string) $value)) !== '') {
                return trim(strip_tags((string) $value));
            }
        }

        return '';
    }

    protected function tags(mixed $tags): array
    {
        return collect(is_array($tags) ? $tags : [])
            ->map(fn ($tag) => is_array($tag) ? ($tag['name'] ?? $tag['label'] ?? '') : $tag)
            ->filter(fn ($tag) => is_string($tag) && trim($tag) !== '')
            ->map(fn ($tag) => Str::limit(trim(strip_tags($tag)), 60, ''))
            ->unique()
            ->take(15)
            ->values()
            ->all();
    }

    protected function heroImage(mixed $image): ?string
    {
        $url = is_array($image) ? ($image['url'] ?? $image['src'] ?? null) : $image;

        return is_string($url) && preg_match('#^https?://#i', $url) && strlen($url) <= 255 ? $url : null;
    }

    protected function date(mixed $value): CarbonInterface
    {
        try {
            return is_string($value) && $value !== '' ? Carbon::parse($value) : now();
        } catch (Throwable) {
            return now();
        }
    }

    protected function uniqueSlug(string $value, Blog $blog): string
    {
        $base = Str::limit(Str::slug($value), 240, '') ?: 'post';
        $slug = $base;
        $suffix = 1;

        while (Blog::withTrashed()->where('slug', $slug)->when($blog->exists, fn ($query) => $query->whereKeyNot($blog->id))->exists()) {
            $slug = $base . '-' . (++$suffix);
        }

        return $slug;
    }
}
