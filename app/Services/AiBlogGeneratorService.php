<?php

namespace App\Services;

use App\Contracts\AiTextGenerator;
use App\Mail\BlogAutomationAlert;
use App\Models\Blog;
use App\Models\Bundle;
use App\Models\Industry;
use App\Models\Package;
use App\Models\Product;
use App\Models\Service;
use App\Models\Setting;
use App\Models\User;
use DOMDocument;
use DOMElement;
use DOMXPath;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Throwable;

class AiBlogGeneratorService
{
    protected const MIN_WORDS = 900;
    protected const MIN_INTERNAL_LINKS = 3;
    protected const MAX_ATTEMPTS = 3;

    /** Pages that turn a reader into an enquiry. Every post links to at least one. */
    protected const CONVERSION_PATHS = ['/packages', '/contact'];

    /**
     * Search topics the automation rotates through. Each one is something a
     * business owner in Kenya would look up before hiring a technology partner.
     */
    protected const TOPICS = [
        ['keyword' => 'website design cost in Kenya', 'angle' => 'what drives the price and how to budget', 'category' => 'Web Development'],
        ['keyword' => 'M-Pesa integration for websites', 'angle' => 'how a business should plan and test Daraja payments', 'category' => 'E-Commerce'],
        ['keyword' => 'best CRM for small businesses in Kenya', 'angle' => 'how to choose between off-the-shelf and custom', 'category' => 'Business Software'],
        ['keyword' => 'SEO for Kenyan businesses', 'angle' => 'how to rank locally in Nairobi and beyond', 'category' => 'Digital Marketing'],
        ['keyword' => 'how to start an online store in Kenya', 'angle' => 'a step-by-step plan covering payments and delivery', 'category' => 'E-Commerce'],
        ['keyword' => 'KRA eTIMS integration for businesses', 'angle' => 'connecting invoicing and sales systems without disrupting work', 'category' => 'Business Software'],
        ['keyword' => 'mobile app development in Kenya', 'angle' => 'planning scope, budget and launch', 'category' => 'Mobile App Development'],
        ['keyword' => 'Kenya Data Protection Act compliance for websites', 'angle' => 'practical steps for handling customer data', 'category' => 'Cybersecurity'],
        ['keyword' => 'business process automation in Kenya', 'angle' => 'which manual work to automate first', 'category' => 'Automation & AI'],
        ['keyword' => 'AI tools for small businesses in Kenya', 'angle' => 'useful applications and where to be careful', 'category' => 'Automation & AI'],
        ['keyword' => 'WhatsApp commerce for Kenyan businesses', 'angle' => 'turning conversations into orders', 'category' => 'E-Commerce'],
        ['keyword' => 'custom software vs off-the-shelf software', 'angle' => 'a decision framework for growing companies', 'category' => 'Business Software'],
        ['keyword' => 'how to choose a web design company in Nairobi', 'angle' => 'questions to ask before signing', 'category' => 'Web Development'],
        ['keyword' => 'Google Ads for businesses in Kenya', 'angle' => 'setting up campaigns that produce real enquiries', 'category' => 'Digital Marketing'],
        ['keyword' => 'cybersecurity for SMEs in Kenya', 'angle' => 'the first protections every company should put in place', 'category' => 'Cybersecurity'],
        ['keyword' => 'school management system in Kenya', 'angle' => 'features that reduce fee and admin work', 'category' => 'Business Software'],
        ['keyword' => 'clinic management software in Kenya', 'angle' => 'what to look for in records, billing and privacy', 'category' => 'Business Software'],
        ['keyword' => 'inventory management system for Kenyan retailers', 'angle' => 'stopping stock losses across branches', 'category' => 'Business Software'],
        ['keyword' => 'website maintenance for businesses', 'angle' => 'what ongoing care includes and why it protects revenue', 'category' => 'Web Development'],
        ['keyword' => 'website speed optimization', 'angle' => 'why slow sites lose customers on mobile networks', 'category' => 'Web Development'],
        ['keyword' => 'cloud migration for Kenyan companies', 'angle' => 'how to move safely and control cost', 'category' => 'Cloud & DevOps'],
        ['keyword' => 'conversion rate optimization for business websites', 'angle' => 'turning existing visitors into leads', 'category' => 'Digital Marketing'],
        ['keyword' => 'business intelligence dashboards', 'angle' => 'getting clear numbers out of scattered data', 'category' => 'Business Intelligence & Analytics'],
        ['keyword' => 'UI UX design for African users', 'angle' => 'designing for mobile-first customers', 'category' => 'UI/UX Design'],
    ];

    protected const IMAGE_POOL = [
        'tech1.webp', 'tech2.webp', 'tech3.webp', 'tech4.webp',
        'tech5.webp', 'tech6.webp', 'tech7.webp', 'tech8.webp',
        'tech-background.webp', 'tech-closeup.webp', 'tech-glow.webp',
        'tech-image.webp', 'tech.webp', 'laptop-in-dark.webp',
    ];

    public function __construct(protected SiteSeo $siteSeo) {}

    /**
     * The configured provider first, then any other provider that has a key,
     * so one provider's outage or empty account does not stop the schedule.
     *
     * @return array<string, callable(): AiTextGenerator>
     */
    protected function providers(): array
    {
        $all = [
            'openai' => fn () => new OpenAIService(),
            'gemini' => fn () => new GeminiService(),
        ];
        $preferred = Setting::get('default_ai_provider', 'openai');

        return isset($all[$preferred]) ? [$preferred => $all[$preferred]] + $all : $all;
    }

    /** Generate one post, publish it and notify the admin inbox. */
    public function generate(): Blog
    {
        $draft = $this->draft();
        $author = User::role(['superadmin', 'admin'])->first() ?? User::first();

        $blog = Blog::create([
            'title' => $draft['title'],
            'slug' => $this->uniqueSlug($draft['title']),
            'excerpt' => $draft['excerpt'],
            'content' => $draft['content'],
            'featured_image' => $this->nextImage(),
            'category' => $draft['category'],
            'tags' => $draft['tags'],
            'author_id' => $author?->id,
            'seo_title' => $draft['seo_title'],
            'seo_description' => $draft['seo_description'],
            'seo_keywords' => $draft['seo_keywords'],
            'is_published' => true,
            'published_at' => now(),
        ]);

        Setting::set('ai_blog_topic_index', (string) ($this->topicIndex() + 1), 'ai');
        Cache::forget('homepage_data');

        Log::info('AI blog post published', ['id' => $blog->id, 'title' => $blog->title]);

        $url = SiteSeo::baseUrl() . "/blog/{$blog->slug}";
        $this->siteSeo->submitToIndexNow([$url, SiteSeo::baseUrl() . '/blog', SiteSeo::baseUrl() . '/sitemap.xml']);
        $this->notifyAdmin($blog);

        return $blog;
    }

    /**
     * Write and check a post without saving it.
     *
     * @throws Exception when no provider produces a post that passes the checks
     */
    public function draft(): array
    {
        $topic = self::TOPICS[$this->topicIndex() % count(self::TOPICS)];
        $recentTitles = Blog::orderByDesc('created_at')->limit(30)->pluck('title')->all();
        $linkTargets = $this->internalLinkTargets();
        $errors = [];

        foreach ($this->providers() as $name => $makeProvider) {
            try {
                $ai = $makeProvider();
            } catch (Throwable $e) {
                $errors[] = "{$name}: {$e->getMessage()}";
                continue;
            }

            $feedback = '';
            for ($attempt = 1; $attempt <= self::MAX_ATTEMPTS; $attempt++) {
                try {
                    $payload = $ai->chatJson(
                        $this->systemPrompt(),
                        $this->userPrompt($topic, $recentTitles, $linkTargets, $feedback),
                    );
                    $draft = $this->buildDraft($payload, $topic, $linkTargets);

                    if ($draft['word_count'] >= self::MIN_WORDS) {
                        return $draft;
                    }

                    $feedback = "Your previous draft was only {$draft['word_count']} words. Write at least 1,300 words.";
                    $errors[] = "{$name}: draft too short ({$draft['word_count']} words)";
                } catch (Throwable $e) {
                    $feedback = 'Your previous response could not be used. Return complete, valid JSON with every field.';
                    $errors[] = "{$name}: {$e->getMessage()}";
                }
            }
        }

        throw new Exception('No usable blog post was generated. ' . implode(' | ', array_slice($errors, -3)));
    }

    protected function topicIndex(): int
    {
        return (int) Setting::get('ai_blog_topic_index', 0);
    }

    protected function notifyAdmin(Blog $blog): void
    {
        try {
            Mail::to(config('mail.blog_alerts_to'))->send(new BlogAutomationAlert($blog));
        } catch (Throwable $e) {
            Log::error('Blog published but the admin alert failed', ['id' => $blog->id, 'error' => $e->getMessage()]);
        }
    }

    protected function nextImage(): string
    {
        $filename = self::IMAGE_POOL[Blog::withTrashed()->count() % count(self::IMAGE_POOL)];
        $this->ensureImageInStorage($filename);

        return 'blog/' . $filename;
    }

    /** storage/app/public is not in git, so copy the bundled image on first use. */
    protected function ensureImageInStorage(string $filename): void
    {
        $dest = storage_path('app/public/blog/' . $filename);
        $source = resource_path('img/' . $filename);

        if (file_exists($dest) || !file_exists($source)) {
            return;
        }

        if (!is_dir(dirname($dest))) {
            mkdir(dirname($dest), 0755, true);
        }

        copy($source, $dest);
    }

    /** Every real page a post may link to: path => what the page is. */
    protected function internalLinkTargets(): array
    {
        $targets = [
            '/' => 'OmniviaTech home page',
            '/about' => 'About OmniviaTech',
            '/packages' => 'Our website packages and pricing',
            '/contact' => 'Contact us or request a quote',
            '/services' => 'All of our solutions',
            '/products' => 'Our software products',
            '/industries' => 'Industries we serve',
        ];

        foreach (Service::where('is_published', true)->get(['name', 'slug']) as $item) {
            $targets["/services/{$item->slug}"] = "Service: {$item->name}";
        }
        foreach (Package::where('is_published', true)->get(['name', 'slug', 'price']) as $item) {
            $price = $item->price ? ' (KES ' . number_format((float) $item->price) . ')' : '';
            $targets["/packages/{$item->slug}"] = "Package: {$item->name}{$price}";
        }
        foreach (Product::where('is_published', true)->get(['name', 'slug', 'short_description']) as $item) {
            $targets["/products/{$item->slug}"] = "Product: {$item->name}: " . Str::limit((string) $item->short_description, 80);
        }
        foreach (Bundle::where('is_published', true)->get(['name', 'slug']) as $item) {
            $targets["/bundles/{$item->slug}"] = "Bundle: {$item->name}";
        }
        foreach (Industry::where('is_active', true)->get(['title', 'slug']) as $item) {
            $targets["/industries/{$item->slug}"] = "Industry: {$item->title}";
        }
        foreach (Blog::published()->limit(15)->get(['title', 'slug', 'published_at']) as $item) {
            $targets["/blog/{$item->slug}"] = "Article: {$item->title}";
        }

        return $targets;
    }

    protected function systemPrompt(): string
    {
        return <<<'PROMPT'
You are the senior content strategist and SEO writer for OmniviaTech, a technology company in Nairobi, Kenya. OmniviaTech builds websites, mobile apps, e-commerce stores, business software and automation, and provides cloud, cybersecurity, SEO and paid advertising services.

Write for business owners and decision makers in Kenya and East Africa. Sound like an experienced practitioner giving honest advice: specific, clear and useful, with short paragraphs and plain language.

Accuracy rules:
- Never invent statistics, studies, quotes, client names, case results, awards or years of experience.
- Do not state exact legal penalties, tax rates, government fees or third-party prices. Tell readers to confirm current requirements with the official body.
- Only state prices for OmniviaTech packages when the price is given to you.
- Do not include external links.

Avoid filler such as "in today's digital landscape", "game-changer", "unlock" and "look no further". Mention OmniviaTech naturally and only where it helps the reader.

Respond with a single valid JSON object and nothing else.
PROMPT;
    }

    protected function userPrompt(array $topic, array $recentTitles, array $linkTargets, string $feedback): string
    {
        $links = collect($linkTargets)->map(fn ($label, $path) => "- {$path} = {$label}")->implode("\n");
        $avoid = $recentTitles ? implode('; ', $recentTitles) : 'None yet.';
        $today = now('Africa/Nairobi')->format('F Y');
        $retry = $feedback ? "\nIMPORTANT: {$feedback}\n" : '';

        return <<<PROMPT
Write one blog post. The current date is {$today}.
{$retry}
Primary search phrase: "{$topic['keyword']}"
Angle: {$topic['angle']}
Category: {$topic['category']}

Choose a specific title that answers what this searcher wants. It must be clearly different from these published titles:
{$avoid}

Internal links available (use these exact paths and no others):
{$links}

Content requirements:
- 1,300 to 1,700 words of valid HTML using only h2, h3, p, ul, ol, li, strong, em, blockquote and a tags. Do not use h1.
- Use the primary search phrase in the first 100 words and in at least one h2, naturally.
- Open with the reader's problem and a direct answer. Do not start with a generic statement about technology.
- Include 4 to 6 h2 sections, at least one practical checklist or numbered process, and Kenya-specific examples where they are genuinely relevant.
- Add an h2 titled "Frequently Asked Questions" with 3 questions as h3 headings and concise answers.
- Add 4 to 7 internal links with descriptive anchor text, placed where they help the reader. Include one to a relevant service, product or package, and one to /packages or /contact.
- End with a short, specific call to action.

Return exactly this JSON shape:
{"title":"under 70 characters","excerpt":"plain text, under 200 characters","content":"HTML","tags":["4 to 7 lowercase keywords"],"seo_title":"under 55 characters, includes the search phrase where natural","seo_description":"under 155 characters, with a clear benefit","seo_keywords":"5 to 8 comma-separated phrases"}
PROMPT;
    }

    protected function buildDraft(array $payload, array $topic, array $linkTargets): array
    {
        foreach (['title', 'excerpt', 'content', 'seo_title', 'seo_description'] as $field) {
            if (empty($payload[$field]) || !is_string($payload[$field])) {
                throw new Exception("AI response is missing {$field}");
            }
        }

        [$content, $links] = $this->cleanContent($payload['content'], $linkTargets);
        [$content, $links] = $this->ensureConversionLinks($content, $links);

        $tags = collect($payload['tags'] ?? [])->filter(fn ($tag) => is_string($tag) && $tag !== '')
            ->map(fn ($tag) => Str::lower(trim($tag)))->unique()->take(7)->values()->all();
        $keywords = $payload['seo_keywords'] ?? $topic['keyword'];
        $keywords = is_array($keywords) ? implode(', ', $keywords) : (string) $keywords;

        return [
            'title' => Str::limit(trim(strip_tags($payload['title'])), 120, ''),
            'excerpt' => Str::limit(trim(strip_tags($payload['excerpt'])), 200),
            'content' => $content,
            'category' => $topic['category'],
            'tags' => $tags,
            'seo_title' => Str::limit(trim(strip_tags($payload['seo_title'])), 60, ''),
            'seo_description' => Str::limit(trim(strip_tags($payload['seo_description'])), 157),
            'seo_keywords' => Str::limit($keywords, 250, ''),
            'word_count' => str_word_count(strip_tags($content)),
            'internal_links' => $links,
        ];
    }

    /**
     * Keep only safe article markup and working internal links. A link to a page
     * that does not exist becomes plain text.
     *
     * @return array{0: string, 1: array<int, string>}
     */
    protected function cleanContent(string $html, array $linkTargets): array
    {
        $html = preg_replace('#<(script|style)\b.*?</\1>#is', '', $html);
        $html = preg_replace('#<(/?)h1\b[^>]*>#i', '<$1h2>', $html);
        $html = strip_tags($html, '<h2><h3><p><ul><ol><li><strong><em><blockquote><a>');

        $previous = libxml_use_internal_errors(true);
        $doc = new DOMDocument('1.0', 'UTF-8');
        $doc->loadHTML('<?xml encoding="UTF-8"><div id="post">' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        $root = $doc->getElementById('post');
        if (!$root) {
            throw new Exception('AI response content is not valid HTML');
        }

        $links = [];
        $xpath = new DOMXPath($doc);

        foreach (iterator_to_array($xpath->query('.//*', $root)) as $element) {
            /** @var DOMElement $element */
            $href = $element->tagName === 'a' ? $element->getAttribute('href') : null;

            foreach (iterator_to_array($element->attributes) as $attribute) {
                $element->removeAttribute($attribute->name);
            }

            if ($href === null) {
                continue;
            }

            $path = $this->internalPath($href);
            if ($path !== null && isset($linkTargets[$path])) {
                $element->setAttribute('href', $path);
                $links[] = $path;
                continue;
            }

            while ($element->firstChild) {
                $element->parentNode->insertBefore($element->firstChild, $element);
            }
            $element->parentNode->removeChild($element);
        }

        $clean = '';
        foreach (iterator_to_array($root->childNodes) as $node) {
            $clean .= $doc->saveHTML($node);
        }

        return [trim($clean), array_values(array_unique($links))];
    }

    protected function internalPath(string $href): ?string
    {
        $parts = parse_url(trim($href));
        $host = strtolower($parts['host'] ?? '');
        $siteHost = (string) parse_url(SiteSeo::baseUrl(), PHP_URL_HOST);

        if ($parts === false || ($host !== '' && !in_array($host, [$siteHost, "www.{$siteHost}"], true))) {
            return null;
        }

        $path = $parts['path'] ?? '';
        if (!str_starts_with($path, '/')) {
            return null;
        }

        return $path === '/' ? '/' : rtrim($path, '/');
    }

    /** Guarantee every published post leads readers to a page that converts. */
    protected function ensureConversionLinks(string $content, array $links): array
    {
        $hasConversionLink = (bool) array_filter(
            $links,
            fn ($path) => in_array($path, self::CONVERSION_PATHS, true) || str_starts_with($path, '/packages/'),
        );

        if ($hasConversionLink && count($links) >= self::MIN_INTERNAL_LINKS) {
            return [$content, $links];
        }

        $content .= '<h2>Talk to OmniviaTech</h2><p>Explore <a href="/services">our solutions</a>, compare '
            . '<a href="/packages">our website packages</a>, or <a href="/contact">contact our Nairobi team</a> '
            . 'to discuss what your business needs next.</p>';

        return [$content, array_values(array_unique([...$links, '/services', '/packages', '/contact']))];
    }

    protected function uniqueSlug(string $title): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 1;

        while (Blog::withTrashed()->where('slug', $slug)->exists()) {
            $slug = $base . '-' . (++$i);
        }

        return $slug;
    }
}
