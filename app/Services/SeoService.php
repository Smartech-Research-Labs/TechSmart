<?php

namespace App\Services;

use App\Models\SeoData;
use Illuminate\Support\Facades\Route;

class SeoService
{
    /**
     * Get SEO data for the current page.
     */
    public static function getCurrentPageSeo(): ?SeoData
    {
        $routeName = Route::currentRouteName();
        $pageName = request('page_name') ?? self::routeToPageName($routeName);

        return SeoData::where('page_name', $pageName)
                     ->orWhere('route_name', $routeName)
                     ->first();
    }

    /**
     * Convert route name to page name for SEO lookup.
     */
    public static function routeToPageName(?string $routeName): string
    {
        if (!$routeName) {
            return 'home';
        }

        $mapping = [
            'home' => 'home',
            'services.index' => 'services',
            'services.show' => 'service_web_development', // Will be overridden by slug
            'products.index' => 'products',
            'products.show' => 'products',
            'packages.index' => 'packages',
            'packages.show' => 'packages',
            'blog.index' => 'blog',
            'blog.show' => 'blog',
            'case-studies.index' => 'case_studies',
            'case-studies.show' => 'case_studies',
            'about' => 'about',
            'contact' => 'contact',
            'faqs' => 'faqs',
            'privacy-policy' => 'privacy_policy',
            'terms-of-service' => 'terms_of_service',
        ];

        return $mapping[$routeName] ?? 'home';
    }

    /**
     * Get SEO data by page name.
     */
    public static function getSeoDataByPageName(string $pageName): ?SeoData
    {
        return SeoData::where('page_name', $pageName)->first();
    }

    /**
     * Get SEO data by route name.
     */
    public static function getSeoDataByRouteName(string $routeName): ?SeoData
    {
        return SeoData::where('route_name', $routeName)->first();
    }

    /**
     * Format SEO data for Inertia response.
     */
    public static function formatForResponse(?SeoData $seoData): array
    {
        if (!$seoData) {
            return [];
        }

        return [
            'meta_title' => $seoData->meta_title,
            'meta_description' => $seoData->meta_description,
            'meta_keywords' => $seoData->meta_keywords,
            'canonical_url' => $seoData->canonical_url,
            'og_title' => $seoData->og_title,
            'og_description' => $seoData->og_description,
            'og_image' => $seoData->og_image,
            'twitter_card' => $seoData->twitter_card,
            'twitter_title' => $seoData->twitter_title,
            'twitter_description' => $seoData->twitter_description,
            'twitter_image' => $seoData->twitter_image,
            'robots' => $seoData->robots_meta,
            'index' => $seoData->index,
            'follow' => $seoData->follow,
        ];
    }

    /**
     * Generate schema markup for a service.
     */
    public static function generateServiceSchema(array $service): string
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => $service['name'] ?? '',
            'description' => strip_tags($service['description'] ?? ''),
            'serviceType' => $service['category'] ?? 'Professional Services',
            'areaServed' => [
                '@type' => 'Country',
                'name' => 'KE'
            ],
            'provider' => [
                '@type' => 'Organization',
                'name' => config('app.name', 'OmniviaTech'),
                'url' => config('app.url'),
                'logo' => asset('storage/' . (\App\Models\Setting::get('logo_path') ?? '')),
            ]
        ];

        if (!empty($service['features'])) {
            $schema['hasOfferingDetails'] = [
                '@type' => 'OfferingDetails',
                'businessFunction' => 'http://purl.org/goodrelations/v1#ProvideService'
            ];
        }

        return json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    /**
     * Generate schema markup for a product.
     */
    public static function generateProductSchema(array $product): string
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $product['name'] ?? '',
            'description' => strip_tags($product['description'] ?? ''),
            'brand' => [
                '@type' => 'Brand',
                'name' => config('app.name', 'OmniviaTech')
            ],
        ];

        if (!empty($product['image'])) {
            $schema['image'] = asset($product['image']);
        }

        if (!empty($product['rating'])) {
            $schema['aggregateRating'] = [
                '@type' => 'AggregateRating',
                'ratingValue' => $product['rating'],
                'ratingCount' => $product['review_count'] ?? 0
            ];
        }

        return json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    /**
     * Generate organization schema markup.
     */
    public static function generateOrganizationSchema(): string
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => config('app.name', 'OmniviaTech'),
            'url' => config('app.url'),
            'logo' => asset('storage/' . (\App\Models\Setting::get('logo_path') ?? '')),
            'description' => \App\Models\Setting::get('meta_description', ''),
            'foundingDate' => '2016',
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => \App\Models\Setting::get('contact_phone', ''),
                'contactType' => 'Customer Service',
                'areaServed' => 'KE'
            ],
            'address' => [
                '@type' => 'PostalAddress',
                'addressCountry' => 'KE',
                'addressLocality' => \App\Models\Setting::get('city', 'Nairobi'),
            ],
        ];

        // Add social profiles
        $socialUrls = [];
        foreach (['facebook_url', 'twitter_url', 'linkedin_url', 'instagram_url', 'youtube_url'] as $key) {
            if ($url = \App\Models\Setting::get($key)) {
                $socialUrls[] = $url;
            }
        }

        if (!empty($socialUrls)) {
            $schema['sameAs'] = $socialUrls;
        }

        return json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    /**
     * Generate breadcrumb schema markup.
     */
    public static function generateBreadcrumbSchema(array $breadcrumbs): string
    {
        $items = [];
        foreach ($breadcrumbs as $index => $breadcrumb) {
            $items[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $breadcrumb['name'] ?? '',
                'item' => $breadcrumb['url'] ?? ''
            ];
        }

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $items
        ];

        return json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    /**
     * Generate FAQ schema markup.
     */
    public static function generateFaqSchema(array $faqs): string
    {
        $items = [];
        foreach ($faqs as $faq) {
            $items[] = [
                '@type' => 'Question',
                'name' => $faq['question'] ?? '',
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => strip_tags($faq['answer'] ?? '')
                ]
            ];
        }

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $items
        ];

        return json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}
