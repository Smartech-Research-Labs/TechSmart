<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{Slider, CounterItem, Service, Product, Client, Faq, FaqCategory, TeamMember, MapDataPoint, Setting, Blog};
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

            // Map services
            $services = Service::where('is_featured', true)
                ->where('is_published', true)
                ->orderBy('order')
                ->take(6)
                ->get()
                ->map(function ($s) {
                    return [
                        'id' => $s->id,
                        'title' => $s->name,
                        'slug' => $s->slug,
                        'excerpt' => $s->short_description,
                        'icon' => $s->icon,
                        'category' => $s->category,
                        'is_featured' => $s->is_featured,
                    ];
                });

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
                    'logo_url' => $c->logo_url
                        ? (str_starts_with($c->logo_url, 'http') ? $c->logo_url : Storage::url($c->logo_url))
                        : null,
                    'website_url' => $c->website_url,
                ];
            });

            // Recent blog posts
            $recentBlogs = Blog::published()
                ->take(3)
                ->get(['id', 'title', 'slug', 'excerpt', 'featured_image', 'published_at', 'category']);

            // Settings
            $logoPath = Setting::get('logo_path');

            return [
                'sliders' => $sliders,
                'counters' => CounterItem::visible()->get(),
                'featured_services' => $services,
                'featured_products' => $products,
                'clients' => $clients,
                'recent_blogs' => $recentBlogs,
                'settings' => [
                    'site_name' => Setting::get('site_name', 'TechSmart'),
                    'tagline' => Setting::get('tagline', 'Innovative Tech Solutions'),
                    'contact_email' => Setting::get('contact_email'),
                    'contact_phone' => Setting::get('contact_phone'),
                    'address' => Setting::get('address'),
                    'logo_path' => $logoPath,
                    'logo_url' => $logoPath ? Storage::url($logoPath) : null,
                    'marquee_text' => Setting::get('marquee_text'),
                    'facebook_url' => Setting::get('facebook_url'),
                    'twitter_url' => Setting::get('twitter_url'),
                    'linkedin_url' => Setting::get('linkedin_url'),
                    'instagram_url' => Setting::get('instagram_url'),
                    'youtube_url' => Setting::get('youtube_url'),
                    'tiktok_url' => Setting::get('tiktok_url'),
                    'whatsapp_number' => Setting::get('whatsapp_number'),
                    'copyright_text' => Setting::get('copyright_text'),
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
