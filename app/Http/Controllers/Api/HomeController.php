<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{Slider, CounterItem, Service, Product, Client, Faq, FaqCategory, TeamMember, MapDataPoint, Setting, Blog, Review, CaseStudy};
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        $data = Cache::remember('homepage_data', 3600, function () {
            // Map sliders to frontend-expected shape
            $sliders = Slider::visible()->get()->map(function ($s) {
                return [
                    'id' => $s->id,
                    'title' => $s->heading,
                    'subtitle' => $s->subheading,
                    'description' => $s->description,
                    'image_url' => $s->background_image
                        ? (str_starts_with($s->background_image, 'http') ? $s->background_image : Storage::url($s->background_image))
                        : null,
                    'cta_text' => $s->cta_label,
                    'cta_link' => $s->cta_url,
                    'cta_text_2' => $s->cta_label_2,
                    'cta_link_2' => $s->cta_url_2,
                    'order' => $s->order,
                ];
            });

            // Map services — include all published, grouped by category
            $allServices = Service::where('is_published', true)
                ->orderBy('order')
                ->get()
                ->map(function ($s) {
                    return [
                        'id' => $s->id,
                        'title' => $s->name,
                        'slug' => $s->slug,
                        'excerpt' => $s->short_description,
                        'icon' => $s->icon,
                        'image_url' => $s->image_url,
                        'category' => $s->category,
                        'category_group' => $s->category_group,
                        'price_label' => $s->price_label,
                        'features' => $s->features ?? [],
                        'is_featured' => $s->is_featured,
                    ];
                });

            $featuredServices = $allServices->where('is_featured', true)->values()->take(9);

            // Map products
            $products = Product::where('is_featured', true)
                ->where('is_published', true)
                ->orderBy('order')
                ->take(6)
                ->with('media')
                ->get()
                ->map(function ($p) {
                    return [
                        'id' => $p->id,
                        'name' => $p->name,
                        'slug' => $p->slug,
                        'excerpt' => $p->short_description,
                        'price' => $p->price,
                        'price_label' => $p->price_label,
                        'image_url' => $p->getFirstMediaUrl('images') ?: null,
                        'category' => $p->category,
                        'is_featured' => $p->is_featured,
                    ];
                });

            // Map clients
            $clients = Client::visible()->get()->map(function ($c) {
                return [
                    'id' => $c->id,
                    'name' => $c->name,
                    'logo_url' => $c->logo
                        ? (str_starts_with($c->logo, 'http') ? $c->logo : Storage::url($c->logo))
                        : null,
                    'website_url' => $c->website_url,
                ];
            });

            // Recent blog posts
            $recentBlogs = Blog::published()
                ->get(['id', 'title', 'slug', 'excerpt', 'featured_image', 'published_at', 'category']);

            // Approved reviews / testimonials
            $reviews = Review::approved()
                ->with('user:id,name')
                ->latest()
                ->take(8)
                ->get()
                ->map(function ($r) {
                    return [
                        'id'        => $r->id,
                        'rating'    => $r->rating,
                        'comment'   => $r->content,
                        'user_name' => $r->user->name ?? 'Anonymous',
                        'company'   => null,
                    ];
                });

            // Settings
            $logoPath = Setting::get('logo_path');

            // Impact / Case Studies for Population Impacted section
            $impactProjects = class_exists(CaseStudy::class)
                ? CaseStudy::where('is_published', true)
                    ->where('is_featured', true)
                    ->orderBy('order')
                    ->take(6)
                    ->get()
                    ->map(fn ($cs) => [
                        'id' => $cs->id,
                        'title' => $cs->title,
                        'slug' => $cs->slug,
                        'category' => $cs->industry,
                        'location' => $cs->client_name,
                        'image' => $cs->image_url,
                    ])
                : collect();

            return [
                'sliders' => $sliders,
                'counters' => CounterItem::visible()->get(),
                'featured_services' => $featuredServices,
                'all_services' => $allServices,
                'featured_products' => $products,
                'clients' => $clients,
                'recent_blogs' => $recentBlogs,
                'top_reviews' => $reviews,
                'impact_projects' => $impactProjects,
                'settings' => [
                    'site_name' => Setting::get('site_name', 'OmniviaTech'),
                    'tagline' => Setting::get('tagline', 'Innovative Tech Solutions'),
                    'contact_email' => Setting::get('contact_email'),
                    'contact_phone' => Setting::get('contact_phone'),
                    'address' => Setting::get('address'),
                    'logo_path' => $logoPath,
                    'logo_url' => $logoPath ? Storage::url($logoPath) : null,
                    'footer_logo_path' => Setting::get('footer_logo_path'),
                    'footer_logo_url' => ($footerLogo = Setting::get('footer_logo_path')) ? Storage::url($footerLogo) : null,
                    'favicon_path' => Setting::get('favicon_path'),
                    'favicon_url' => ($favicon = Setting::get('favicon_path')) ? Storage::url($favicon) : null,
                    'logo_height' => Setting::get('logo_height', '40'),
                    'logo_border_radius' => Setting::get('logo_border_radius', '0'),
                    'marquee_text' => Setting::get('marquee_text'),
                    'facebook_url' => Setting::get('facebook_url'),
                    'twitter_url' => Setting::get('twitter_url'),
                    'linkedin_url' => Setting::get('linkedin_url'),
                    'instagram_url' => Setting::get('instagram_url'),
                    'youtube_url' => Setting::get('youtube_url'),
                    'tiktok_url' => Setting::get('tiktok_url'),
                    'whatsapp_number' => Setting::get('whatsapp_number'),
                    'copyright_text' => Setting::get('copyright_text'),
                    // Theme color settings
                    'theme_preset' => Setting::get('theme_preset', 'purple'),
                    'theme_primary_color' => Setting::get('theme_primary_color'),
                    'theme_accent_color' => Setting::get('theme_accent_color'),
                    // CMS Images
                    'hero_bg_image' => Setting::get('hero_bg_image'),
                    'about_section_image' => Setting::get('about_section_image'),
                    'values_section_image' => Setting::get('values_section_image'),
                    'cta_professional_image' => Setting::get('cta_professional_image'),
                    'quote_section_image' => Setting::get('quote_section_image'),
                    'office_image' => Setting::get('office_image'),
                    'services_page_image' => Setting::get('services_page_image'),
                    'products_page_image' => Setting::get('products_page_image'),
                    'login_page_image' => Setting::get('login_page_image'),
                    'register_page_image' => Setting::get('register_page_image'),
                    'forgot_password_image' => Setting::get('forgot_password_image'),
                    'industries_page_image' => Setting::get('industries_page_image'),
                    'population_image' => Setting::get('population_image'),
                    // SEO settings for schema markup
                    'meta_title' => Setting::get('meta_title'),
                    'meta_description' => Setting::get('meta_description'),
                    'meta_keywords' => Setting::get('meta_keywords'),
                    'schema_org_type' => Setting::get('schema_org_type', 'Organization'),
                    'schema_org_name' => Setting::get('schema_org_name'),
                    'schema_org_logo' => Setting::get('schema_org_logo'),
                    'schema_same_as' => Setting::get('schema_same_as'),
                    'canonical_url' => Setting::get('canonical_url'),
                    'og_image_default' => Setting::get('og_image_default'),
                    'twitter_card_type' => Setting::get('twitter_card_type', 'summary_large_image'),
                    'twitter_handle' => Setting::get('twitter_handle'),
                    'site_description' => Setting::get('site_description'),
                    'city' => Setting::get('city'),
                    'country' => Setting::get('country'),
                    // Per-page SEO
                    'home_meta_title' => Setting::get('home_meta_title'),
                    'home_meta_description' => Setting::get('home_meta_description'),
                    'about_meta_title' => Setting::get('about_meta_title'),
                    'about_meta_description' => Setting::get('about_meta_description'),
                    'services_meta_title' => Setting::get('services_meta_title'),
                    'services_meta_description' => Setting::get('services_meta_description'),
                    'products_meta_title' => Setting::get('products_meta_title'),
                    'products_meta_description' => Setting::get('products_meta_description'),
                    'blog_meta_title' => Setting::get('blog_meta_title'),
                    'blog_meta_description' => Setting::get('blog_meta_description'),
                    'contact_meta_title' => Setting::get('contact_meta_title'),
                    'contact_meta_description' => Setting::get('contact_meta_description'),
                    'case_studies_meta_title' => Setting::get('case_studies_meta_title'),
                    'case_studies_meta_description' => Setting::get('case_studies_meta_description'),
                    'industries_meta_title' => Setting::get('industries_meta_title'),
                    'industries_meta_description' => Setting::get('industries_meta_description'),
                ],
            ];
        });

        return response()->json($data);
    }

    public function faqs()
    {
        return response()->json([
            'categories' => FaqCategory::with(['faqs' => function ($query) {
                $query->visible()->orderBy('order');
            }])->orderBy('order')->get(),
        ]);
    }

    public function team()
    {
        return response()->json([
            'members' => TeamMember::visible()->get(),
        ]);
    }

    public function mapData()
    {
        return response()->json([
            'points' => MapDataPoint::visible()->get(),
        ]);
    }
}
