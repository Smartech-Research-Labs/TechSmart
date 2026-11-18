<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\Bundle;
use App\Models\CaseStudy;
use App\Models\Industry;
use App\Models\Package;
use App\Models\Product;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Search-engine data for every public URL: title, description, canonical,
 * breadcrumbs and structured data. It is rendered into the first HTML response
 * (the Vue app has not run yet at that point) and reused for in-app navigation.
 */
class SiteSeo
{
    /** Pages we want search engines to treat as the main entry points to the site. */
    public const KEY_PAGES = [
        '/' => 'Home',
        '/about' => 'About Us',
        '/packages' => 'Our Packages',
        '/contact' => 'Contact Us',
        '/services' => 'Our Solutions',
    ];

    protected const STATIC_PAGES = [
        '/' => [
            'key' => 'home',
            'name' => 'Home',
            'title' => 'OmniviaTech | Web, Software & Digital Solutions in Kenya',
            'description' => 'OmniviaTech builds websites, mobile apps, business software and digital marketing solutions for growing companies in Nairobi and across Kenya.',
        ],
        '/about' => [
            'key' => 'about',
            'name' => 'About Us',
            'title' => 'About Us | OmniviaTech, Nairobi Technology Company',
            'description' => 'Meet OmniviaTech, a Nairobi technology company helping businesses grow with reliable websites, custom software, automation and digital marketing.',
        ],
        '/packages' => [
            'key' => 'packages',
            'name' => 'Our Packages',
            'title' => 'Our Packages | Website Packages in Kenya | OmniviaTech',
            'description' => 'Compare OmniviaTech website packages for Kenyan businesses, from a professional starter site to a full e-commerce store. Choose a plan and get started.',
        ],
        '/contact' => [
            'key' => 'contact',
            'name' => 'Contact Us',
            'title' => 'Contact Us | Request a Quote | OmniviaTech Nairobi',
            'description' => 'Talk to OmniviaTech in Nairobi about your website, app or software project. Call, chat on WhatsApp or send a message to request a quote.',
        ],
        '/services' => [
            'key' => 'services',
            'name' => 'Our Solutions',
            'title' => 'Our Solutions | Software & Digital Services | OmniviaTech',
            'description' => 'Explore OmniviaTech solutions: web and mobile development, e-commerce, CRM and ERP systems, cloud, cybersecurity, SEO and paid advertising.',
        ],
        '/products' => [
            'key' => 'products',
            'name' => 'Products',
            'title' => 'Business Software Products for Kenya | OmniviaTech',
            'description' => 'Ready-to-use software from OmniviaTech for retail, clinics, schools, chamas, fleets and more, built for how Kenyan businesses work.',
        ],
        '/bundles' => [
            'key' => 'bundles',
            'name' => 'Bundles',
            'title' => 'Solution Bundles | OmniviaTech',
            'description' => 'Combine OmniviaTech services and products into one solution bundle for your business, with one team handling delivery from start to finish.',
        ],
        '/blog' => [
            'key' => 'blog',
            'name' => 'Blog',
            'title' => 'Technology & Business Growth Blog | OmniviaTech',
            'description' => 'Practical guides on websites, software, automation, security and digital marketing for businesses in Kenya, from the OmniviaTech team.',
        ],
        '/case-studies' => [
            'key' => 'case_studies',
            'name' => 'Case Studies',
            'title' => 'Case Studies | OmniviaTech',
            'description' => 'See how OmniviaTech approaches real technology projects, from the business challenge to the solution delivered and the results.',
        ],
        '/industries' => [
            'key' => 'industries',
            'name' => 'Industries',
            'title' => 'Industries We Serve | OmniviaTech',
            'description' => 'Technology solutions from OmniviaTech for healthcare, finance, education, retail, logistics, manufacturing, agriculture and energy.',
        ],
        '/faqs' => [
            'key' => 'faqs',
            'name' => 'FAQs',
            'title' => 'Frequently Asked Questions | OmniviaTech',
            'description' => 'Answers to common questions about working with OmniviaTech, including project timelines, pricing, payment and post-launch support.',
        ],
        '/privacy' => [
            'key' => 'privacy',
            'name' => 'Privacy Policy',
            'title' => 'Privacy Policy | OmniviaTech',
            'description' => 'How OmniviaTech collects, uses and protects personal data under the Kenya Data Protection Act, 2019, and the rights available to you.',
        ],
        '/terms' => [
            'key' => 'terms',
            'name' => 'Terms of Service',
            'title' => 'Terms of Service | OmniviaTech',
            'description' => 'The terms that apply when you use the OmniviaTech website, create an account or enquire about our services and packages.',
        ],
    ];

    /** App areas that work normally but must stay out of search results. */
    protected const PRIVATE_PREFIXES = [
        'admin', 'dashboard', 'login', 'register', 'forgot-password', 'reset-password',
        'confirm-password', 'verify-email', 'two-factor-challenge', 'auth', 'settings', 'specializations',
    ];

    public static function baseUrl(): string
    {
        return rtrim((string) config('seo.site_url'), '/');
    }

    public function resolve(string $path): array
    {
        $path = '/' . trim($path, '/');
        $segments = array_values(array_filter(explode('/', $path), 'strlen'));

        if (isset(self::STATIC_PAGES[$path])) {
            return $this->staticPage($path);
        }

        if ($segments && in_array($segments[0], self::PRIVATE_PREFIXES, true)) {
            return $this->page(['name' => 'OmniviaTech', 'title' => 'OmniviaTech', 'path' => $path, 'robots' => 'noindex, nofollow']);
        }

        if (count($segments) === 2) {
            $page = $this->detailPage($segments[0], $segments[1]);
            if ($page) {
                return $page;
            }
        }

        return $this->page([
            'name' => 'Page Not Found',
            'title' => 'Page Not Found | OmniviaTech',
            'path' => $path,
            'robots' => 'noindex, follow',
            'status' => 404,
        ]);
    }

    protected function staticPage(string $path): array
    {
        $page = self::STATIC_PAGES[$path];
        $title = Setting::get($page['key'] . '_meta_title');
        $description = Setting::get($page['key'] . '_meta_description');

        if ($path === '/') {
            $siteName = (string) Setting::get('site_name', 'OmniviaTech');
            $globalTitle = (string) Setting::get('meta_title', '');
            $title = $title ?: (strcasecmp($globalTitle, $siteName) !== 0 ? $globalTitle : null);
            $description = $description ?: Setting::get('meta_description') ?: Setting::get('site_description');
        }

        return $this->page([
            'name' => $page['name'],
            'title' => $title ?: $page['title'],
            'description' => $description ?: $page['description'],
            'path' => $path,
            'crumbs' => $path === '/' ? [] : [[$page['name'], $path]],
            'links' => $this->listingLinks($path),
        ]);
    }

    protected function detailPage(string $section, string $slug): ?array
    {
        $item = match ($section) {
            'services' => Service::where('is_published', true)->where('slug', $slug)->first(),
            'products' => Product::where('is_published', true)->where('slug', $slug)->first(),
            'packages' => Package::where('is_published', true)->where('slug', $slug)->first(),
            'bundles' => Bundle::where('is_published', true)->where('slug', $slug)->first(),
            'blog' => Blog::published()->where('slug', $slug)->first(),
            'case-studies' => CaseStudy::published()->where('slug', $slug)->first(),
            'industries' => Industry::where('is_active', true)->where('slug', $slug)->first(),
            default => null,
        };

        if (!$item) {
            return null;
        }

        $parentPath = '/' . $section;
        $parent = self::STATIC_PAGES[$parentPath];
        $path = "{$parentPath}/{$slug}";
        $name = $item->name ?? $item->title;
        $title = $item->seo_title ?? $item->meta_title ?? $name;
        $description = $item->seo_description ?? $item->meta_description
            ?? $item->short_description ?? $item->excerpt ?? $item->description ?? $parent['description'];
        $image = $item->featured_image ?? $item->image ?? null;

        $page = [
            'name' => $name,
            'title' => Str::contains($title, 'OmniviaTech') ? $title : "{$title} | OmniviaTech",
            'description' => $description,
            'path' => $path,
            'image' => $image,
            'crumbs' => [[$parent['name'], $parentPath], [$name, $path]],
        ];

        if ($item instanceof Blog) {
            $page['type'] = 'article';
            $page['body'] = $item->content;
            $page['article'] = $item;
        }

        return $this->page($page);
    }

    protected function page(array $page): array
    {
        $base = self::baseUrl();
        $path = $page['path'];
        $canonical = $path === '/' ? $base . '/' : $base . $path;
        $description = Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags((string) ($page['description'] ?? '')))), 157);
        $image = $this->absoluteImage($page['image'] ?? null);

        $breadcrumbs = [];
        if (!empty($page['crumbs'])) {
            $breadcrumbs[] = ['name' => 'Home', 'url' => $base . '/'];
            foreach ($page['crumbs'] as [$name, $crumbPath]) {
                $breadcrumbs[] = ['name' => $name, 'url' => $base . $crumbPath];
            }
        }

        return [
            'status' => $page['status'] ?? 200,
            'robots' => $page['robots'] ?? 'index, follow, max-image-preview:large',
            'name' => $page['name'],
            'title' => $page['title'],
            'description' => $description,
            'canonical' => $canonical,
            'image' => $image,
            'type' => $page['type'] ?? 'website',
            'breadcrumbs' => $breadcrumbs,
            'breadcrumb_schema' => $this->breadcrumbSchema($breadcrumbs),
            'article_schema' => isset($page['article']) ? $this->articleSchema($page['article'], $canonical, $image, $description) : null,
            'body' => $page['body'] ?? null,
            'links' => $page['links'] ?? [],
            'key_links' => collect(self::KEY_PAGES)->map(fn ($label, $url) => ['label' => $label, 'url' => $url])->values()->all(),
        ];
    }

    public function siteSchema(): array
    {
        $base = self::baseUrl();
        $name = Setting::get('schema_org_name') ?: Setting::get('site_name') ?: 'OmniviaTech';

        $organization = array_filter([
            '@type' => Setting::get('schema_org_type') ?: 'Organization',
            '@id' => "{$base}/#organization",
            'name' => $name,
            'url' => "{$base}/",
            'logo' => Setting::get('schema_org_logo') ?: $this->absoluteImage(Setting::get('logo_path')),
            'email' => Setting::get('contact_email') ?: 'reachout@omniviatech.co.ke',
            'telephone' => Setting::get('contact_phone') ?: '+254710351517',
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => 'Nairobi',
                'addressCountry' => 'KE',
            ],
            'sameAs' => $this->socialProfiles(),
        ]);

        return [
            '@context' => 'https://schema.org',
            '@graph' => [
                $organization,
                [
                    '@type' => 'WebSite',
                    '@id' => "{$base}/#website",
                    'name' => $name,
                    'url' => "{$base}/",
                    'inLanguage' => 'en-KE',
                    'publisher' => ['@id' => "{$base}/#organization"],
                ],
            ],
        ];
    }

    protected function socialProfiles(): array
    {
        $profiles = collect(['facebook_url', 'twitter_url', 'linkedin_url', 'instagram_url', 'youtube_url', 'tiktok_url'])
            ->map(fn ($key) => Setting::get($key));

        return $profiles
            ->merge(preg_split('/[\s,]+/', (string) Setting::get('schema_same_as', '')))
            ->filter(fn ($url) => is_string($url) && str_starts_with($url, 'http'))
            ->unique()
            ->values()
            ->all();
    }

    protected function breadcrumbSchema(array $breadcrumbs): ?array
    {
        if (count($breadcrumbs) < 2) {
            return null;
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => collect($breadcrumbs)->values()->map(fn ($crumb, $i) => [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'name' => $crumb['name'],
                'item' => $crumb['url'],
            ])->all(),
        ];
    }

    protected function articleSchema(Blog $blog, string $url, string $image, string $description): array
    {
        $base = self::baseUrl();

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => Str::limit($blog->title, 107),
            'description' => $description,
            'image' => [$image],
            'datePublished' => $blog->published_at?->toIso8601String(),
            'dateModified' => $blog->updated_at?->toIso8601String(),
            'mainEntityOfPage' => $url,
            'author' => ['@type' => 'Organization', 'name' => 'OmniviaTech', 'url' => "{$base}/"],
            'publisher' => ['@id' => "{$base}/#organization"],
        ];
    }

    protected function absoluteImage(?string $image): string
    {
        $base = self::baseUrl();

        if (!$image) {
            return Setting::get('og_image_default') ?: "{$base}/android-chrome-512x512.png";
        }

        return str_starts_with($image, 'http') ? $image : "{$base}/storage/" . ltrim($image, '/');
    }

    /** Links for the plain-HTML version of the listing pages. */
    protected function listingLinks(string $path): array
    {
        $map = fn ($items, string $label, string $prefix) => $items
            ->map(fn ($item) => ['label' => $item->{$label}, 'url' => "{$prefix}/{$item->slug}"])
            ->all();

        return match ($path) {
            '/', '/services' => $map(Service::where('is_published', true)->orderBy('order')->get(['name', 'slug']), 'name', '/services'),
            '/packages' => $map(Package::where('is_published', true)->orderBy('order')->get(['name', 'slug']), 'name', '/packages'),
            '/products' => $map(Product::where('is_published', true)->orderBy('order')->get(['name', 'slug']), 'name', '/products'),
            '/bundles' => $map(Bundle::where('is_published', true)->orderBy('order')->get(['name', 'slug']), 'name', '/bundles'),
            '/blog' => $map(Blog::published()->limit(30)->get(['title', 'slug', 'published_at']), 'title', '/blog'),
            '/case-studies' => $map(CaseStudy::published()->get(['title', 'slug']), 'title', '/case-studies'),
            '/industries' => $map(Industry::where('is_active', true)->orderBy('sort_order')->get(['title', 'slug']), 'title', '/industries'),
            default => [],
        };
    }

    /** @return array<int, array{loc: string, lastmod: ?string}> */
    public function sitemapEntries(): array
    {
        $base = self::baseUrl();
        $entries = [];

        foreach (array_keys(self::STATIC_PAGES) as $path) {
            $entries[] = ['loc' => $path === '/' ? "{$base}/" : $base . $path, 'lastmod' => null];
        }

        $sections = [
            '/services' => Service::where('is_published', true),
            '/products' => Product::where('is_published', true),
            '/packages' => Package::where('is_published', true),
            '/bundles' => Bundle::where('is_published', true),
            '/blog' => Blog::published(),
            '/case-studies' => CaseStudy::published(),
            '/industries' => Industry::where('is_active', true),
        ];

        foreach ($sections as $prefix => $query) {
            foreach ($query->get(['slug', 'updated_at']) as $item) {
                $entries[] = ['loc' => "{$base}{$prefix}/{$item->slug}", 'lastmod' => $item->updated_at?->toDateString()];
            }
        }

        return $entries;
    }

    public static function indexNowKey(): string
    {
        return substr(hash_hmac('sha256', 'indexnow', (string) config('app.key')), 0, 32);
    }

    /** Tell Bing and other IndexNow search engines about new URLs. Never throws. */
    public function submitToIndexNow(array $urls): void
    {
        $base = self::baseUrl();

        try {
            Http::timeout(10)->post('https://api.indexnow.org/indexnow', [
                'host' => parse_url($base, PHP_URL_HOST),
                'key' => self::indexNowKey(),
                'keyLocation' => "{$base}/indexnow.txt",
                'urlList' => array_values($urls),
            ]);
        } catch (\Throwable $e) {
            Log::warning('IndexNow submission failed', ['error' => $e->getMessage()]);
        }
    }
}
