<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Blog, Bundle, Enquiry, Page, Product, Service, User};
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:1|max:100',
            'type' => 'nullable|string|in:all,users,services,products,pages,blogs,bundles,enquiries',
            'limit' => 'nullable|integer|min:1|max:50',
        ]);

        $query = $request->input('q');
        $type = $request->input('type', 'all');
        $limit = $request->input('limit', 5);

        $results = [];

        if (in_array($type, ['all', 'users'])) {
            $results['users'] = User::where('name', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%")
                ->select('id', 'name', 'email', 'avatar', 'created_at')
                ->limit($limit)
                ->get()
                ->map(fn ($u) => [
                    'id' => $u->id,
                    'title' => $u->name,
                    'subtitle' => $u->email,
                    'avatar' => $u->avatar ? '/storage/' . $u->avatar : null,
                    'type' => 'user',
                    'url' => '/admin/users',
                ]);
        }

        if (in_array($type, ['all', 'services'])) {
            $results['services'] = Service::where('name', 'like', "%{$query}%")
                ->orWhere('short_description', 'like', "%{$query}%")
                ->select('id', 'name', 'slug', 'short_description', 'icon')
                ->limit($limit)
                ->get()
                ->map(fn ($s) => [
                    'id' => $s->id,
                    'title' => $s->name,
                    'subtitle' => $s->short_description ? \Str::limit($s->short_description, 60) : '',
                    'icon' => $s->icon ?? '💡',
                    'type' => 'service',
                    'url' => '/admin/services',
                ]);
        }

        if (in_array($type, ['all', 'products'])) {
            $results['products'] = Product::where('name', 'like', "%{$query}%")
                ->orWhere('short_description', 'like', "%{$query}%")
                ->select('id', 'name', 'slug', 'short_description', 'price')
                ->limit($limit)
                ->get()
                ->map(fn ($p) => [
                    'id' => $p->id,
                    'title' => $p->name,
                    'subtitle' => $p->price ? 'Ksh ' . number_format($p->price) : ($p->short_description ? \Str::limit($p->short_description, 60) : ''),
                    'icon' => '📦',
                    'type' => 'product',
                    'url' => '/admin/products',
                ]);
        }

        if (in_array($type, ['all', 'pages'])) {
            $results['pages'] = Page::where('title', 'like', "%{$query}%")
                ->orWhere('slug', 'like', "%{$query}%")
                ->select('id', 'title', 'slug')
                ->limit($limit)
                ->get()
                ->map(fn ($p) => [
                    'id' => $p->id,
                    'title' => $p->title,
                    'subtitle' => '/' . $p->slug,
                    'icon' => '📄',
                    'type' => 'page',
                    'url' => '/admin/pages',
                ]);
        }

        if (in_array($type, ['all', 'blogs'])) {
            $results['blogs'] = Blog::where('title', 'like', "%{$query}%")
                ->orWhere('excerpt', 'like', "%{$query}%")
                ->select('id', 'title', 'slug', 'excerpt', 'category')
                ->limit($limit)
                ->get()
                ->map(fn ($b) => [
                    'id' => $b->id,
                    'title' => $b->title,
                    'subtitle' => $b->category ?? ($b->excerpt ? \Str::limit($b->excerpt, 60) : ''),
                    'icon' => '✍️',
                    'type' => 'blog',
                    'url' => '/admin/blogs',
                ]);
        }

        if (in_array($type, ['all', 'bundles'])) {
            $results['bundles'] = Bundle::where('name', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->select('id', 'name', 'slug', 'price')
                ->limit($limit)
                ->get()
                ->map(fn ($b) => [
                    'id' => $b->id,
                    'title' => $b->name,
                    'subtitle' => $b->price ? 'Ksh ' . number_format($b->price) : '',
                    'icon' => '📁',
                    'type' => 'bundle',
                    'url' => '/admin/bundles',
                ]);
        }

        if (in_array($type, ['all', 'enquiries'])) {
            $results['enquiries'] = Enquiry::where('name', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%")
                ->orWhere('subject', 'like', "%{$query}%")
                ->select('id', 'name', 'email', 'subject', 'status', 'created_at')
                ->limit($limit)
                ->get()
                ->map(fn ($e) => [
                    'id' => $e->id,
                    'title' => $e->name,
                    'subtitle' => $e->subject ?? $e->email,
                    'icon' => '📩',
                    'type' => 'enquiry',
                    'url' => '/admin/enquiries',
                ]);
        }

        // Flatten for "all" view
        $flat = collect();
        foreach ($results as $items) {
            $flat = $flat->merge($items);
        }

        return response()->json([
            'results' => $results,
            'all' => $flat->take(20)->values(),
            'total' => $flat->count(),
        ]);
    }

    public function suggestions()
    {
        return response()->json([
            ['title' => 'Go to Users', 'description' => 'Manage user accounts', 'url' => '/admin/users', 'icon' => '👥'],
            ['title' => 'Go to Services', 'description' => 'Manage services', 'url' => '/admin/services', 'icon' => '💡'],
            ['title' => 'Go to Products', 'description' => 'Manage products', 'url' => '/admin/products', 'icon' => '📦'],
            ['title' => 'Go to Blogs', 'description' => 'Manage blog posts', 'url' => '/admin/blogs', 'icon' => '✍️'],
            ['title' => 'Go to Enquiries', 'description' => 'View customer enquiries', 'url' => '/admin/enquiries', 'icon' => '📩'],
            ['title' => 'Go to Settings', 'description' => 'Configure site settings', 'url' => '/admin/settings', 'icon' => '⚙️'],
            ['title' => 'Go to CMS', 'description' => 'Content management', 'url' => '/admin/cms', 'icon' => '📋'],
            ['title' => 'Go to Reviews', 'description' => 'Moderate customer reviews', 'url' => '/admin/reviews', 'icon' => '⭐'],
        ]);
    }
}
