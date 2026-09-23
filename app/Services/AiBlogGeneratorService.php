<?php

namespace App\Services;

use App\Contracts\AiTextGenerator;
use App\Models\Blog;
use App\Models\Bundle;
use App\Models\Product;
use App\Models\Service;
use App\Models\Setting;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AiBlogGeneratorService
{
    protected ?AiTextGenerator $ai = null;

    /**
     * Content pillars the automation rotates through. These mirror the
     * company's real service categories and the audience the user asked to
     * target: international businesses evaluating web/app development,
     * automation, legacy modernization, and SaaS partners.
     */
    protected const PILLARS = [
        'Web Development',
        'Mobile App Development',
        'Automation & AI',
        'Legacy System Modernization',
        'SaaS Development',
        'Cloud & DevOps',
        'Cybersecurity',
        'E-Commerce',
        'Business Intelligence & Analytics',
        'UI/UX Design',
    ];

    /**
     * Bundled, royalty-free-to-us tech imagery already shipped with the repo
     * (resources/img/*.webp). Cycled deterministically so consecutive posts
     * don't reuse the same image.
     */
    protected const IMAGE_POOL = [
        'tech1.webp', 'tech2.webp', 'tech3.webp', 'tech4.webp',
        'tech5.webp', 'tech6.webp', 'tech7.webp', 'tech8.webp',
        'tech-background.webp', 'tech-closeup.webp', 'tech-glow.webp',
        'tech-image.webp', 'tech.webp', 'laptop-in-dark.webp',
    ];

    /**
     * Lazily resolves the configured AI provider (Settings > AI > Default
     * AI Provider, defaults to Gemini since it has a free tier) only when
     * actually needed, so a missing API key surfaces as an exception from
     * generate() (which callers wrap in try/catch) rather than during
     * container resolution of this service, which would bypass that error
     * handling entirely.
     */
    protected function ai(): AiTextGenerator
    {
        return $this->ai ??= match (Setting::get('default_ai_provider', 'gemini')) {
            'openai' => new OpenAIService(),
            default => new GeminiService(),
        };
    }

    /**
     * Generate one SEO-optimized blog post and publish it immediately.
     *
     * @throws Exception on AI/validation failure (caller/command logs it)
     */
    public function generate(): Blog
    {
        $pillar = $this->nextPillar();
        $recentTitles = Blog::orderByDesc('created_at')->limit(20)->pluck('title')->all();
        $linkTargets = $this->sampleInternalLinkTargets();

        $payload = $this->requestPost($pillar, $recentTitles, $linkTargets);
        $this->validatePayload($payload);

        $author = User::role(['superadmin', 'admin'])->first() ?? User::first();

        $blog = Blog::create([
            'title'            => $payload['title'],
            'slug'             => $this->uniqueSlug($payload['title']),
            'excerpt'          => $payload['excerpt'],
            'content'          => $payload['content'],
            'featured_image'   => $this->nextImage(),
            'category'         => $payload['category'],
            'tags'             => $payload['tags'],
            'author_id'        => $author?->id,
            'seo_title'        => $payload['seo_title'],
            'seo_description'  => $payload['seo_description'],
            'seo_keywords'     => $payload['seo_keywords'],
            'is_published'     => true,
            'published_at'     => now(),
        ]);

        Log::info('AI blog post published', [
            'id' => $blog->id,
            'title' => $blog->title,
            'pillar' => $pillar,
        ]);

        return $blog;
    }

    /**
     * Rotate through PILLARS based on how many posts exist so far, giving
     * even long-run coverage across every service category.
     */
    protected function nextPillar(): string
    {
        $index = Blog::count() % count(self::PILLARS);
        return self::PILLARS[$index];
    }

    protected function nextImage(): string
    {
        $index = Blog::count() % count(self::IMAGE_POOL);
        $filename = self::IMAGE_POOL[$index];
        $this->ensureImageInStorage($filename);
        return 'blog/' . $filename;
    }

    /**
     * Copy the chosen bundled image into the public storage disk on first
     * use (storage/app/public is gitignored, so it won't already be there
     * on a fresh environment).
     */
    protected function ensureImageInStorage(string $filename): void
    {
        $dest = storage_path('app/public/blog/' . $filename);
        if (file_exists($dest)) {
            return;
        }

        $source = resource_path('img/' . $filename);
        if (!file_exists($source)) {
            return;
        }

        $destDir = dirname($dest);
        if (!is_dir($destDir)) {
            mkdir($destDir, 0755, true);
        }

        copy($source, $dest);
    }

    /**
     * Pull a handful of real, currently-published services/products/bundles
     * so the AI can weave genuine internal links into the post instead of
     * inventing URLs.
     */
    protected function sampleInternalLinkTargets(): array
    {
        $targets = [];

        foreach (Service::where('is_published', true)->inRandomOrder()->limit(4)->get(['name', 'slug']) as $s) {
            $targets[] = ['type' => 'service', 'name' => $s->name, 'url' => '/services/' . $s->slug];
        }
        foreach (Product::where('is_published', true)->inRandomOrder()->limit(2)->get(['name', 'slug']) as $p) {
            $targets[] = ['type' => 'product', 'name' => $p->name, 'url' => '/products/' . $p->slug];
        }
        foreach (Bundle::where('is_published', true)->inRandomOrder()->limit(2)->get(['name', 'slug']) as $b) {
            $targets[] = ['type' => 'bundle', 'name' => $b->name, 'url' => '/bundles/' . $b->slug];
        }

        // Always give the model a safe, always-valid fallback CTA link.
        $targets[] = ['type' => 'contact', 'name' => 'Talk to our team', 'url' => '/contact'];

        return $targets;
    }

    protected function requestPost(string $pillar, array $recentTitles, array $linkTargets): array
    {
        $linksList = collect($linkTargets)
            ->map(fn ($t) => "- \"{$t['name']}\" -> {$t['url']}")
            ->implode("\n");

        $avoidList = empty($recentTitles) ? 'None yet.' : implode('; ', $recentTitles);

        $systemPrompt = <<<PROMPT
You are the senior content strategist and SEO copywriter for OmniviaTech, a
technology company offering web development, mobile app development,
automation, legacy system modernization, SaaS development, cloud/DevOps,
cybersecurity, e-commerce, BI/analytics, and UI/UX design services.

Write for an international, English-speaking business audience (North
America, Europe, and beyond) evaluating a technology partner — not a local
or regional-only audience. Avoid region-specific legal/compliance references
that don't apply globally. Be concrete, practical, and non-fluffy: use
specific examples, avoid generic filler, and never invent statistics,
client names, or claims about OmniviaTech that aren't generically true of a
professional software agency.

Always respond with a single valid JSON object and nothing else.
PROMPT;

        $userPrompt = <<<PROMPT
Write one blog post for the content pillar: "{$pillar}".

Do not repeat or closely rehash any of these already-published titles:
{$avoidList}

Weave 2-4 of these real internal links naturally into the article body as
HTML anchor tags (use the exact URL given, do not modify it):
{$linksList}

Requirements:
- "title": compelling, specific, under 70 characters, no clickbait.
- "excerpt": 1-2 plain-text sentences (max 200 characters) for listing cards.
- "content": valid HTML (use <h2>/<h3>, <p>, <ul>/<li> as appropriate),
  900-1400 words, includes the internal links requested above as <a href="...">
  tags, structured with a clear introduction, 3-5 subheaded sections, and a
  conclusion with a call to action.
- "category": one short category label (e.g. "{$pillar}").
- "tags": array of 4-7 relevant lowercase keyword strings.
- "seo_title": under 60 characters, includes a primary keyword.
- "seo_description": under 160 characters, compelling meta description.
- "seo_keywords": comma-separated string of 5-8 keywords/phrases.

Respond with ONLY this JSON shape:
{"title":"","excerpt":"","content":"","category":"","tags":[],"seo_title":"","seo_description":"","seo_keywords":""}
PROMPT;

        $result = $this->ai()->chatJson($systemPrompt, $userPrompt);

        if (!is_array($result)) {
            throw new Exception('AI blog generation returned invalid JSON');
        }

        return $result;
    }

    protected function validatePayload(array $payload): void
    {
        foreach (['title', 'content', 'category', 'seo_title', 'seo_description'] as $field) {
            if (empty($payload[$field])) {
                throw new Exception("AI blog generation response missing required field: {$field}");
            }
        }
    }

    protected function uniqueSlug(string $title): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 1;
        while (Blog::where('slug', $slug)->exists()) {
            $slug = $base . '-' . (++$i);
        }
        return $slug;
    }
}
