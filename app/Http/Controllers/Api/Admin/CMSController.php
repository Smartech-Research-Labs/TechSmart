<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Slider, Service, Product, Bundle, Client, CounterItem};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CMSController extends Controller
{
    // ──── SLIDERS ────

    public function sliders()
    {
        return response()->json(Slider::orderBy('order')->get());
    }

    public function storeSlider(Request $request)
    {
        $validated = $request->validate([
            'heading' => 'required|string|max:255',
            'subheading' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'background_image' => 'nullable|image|max:4096',
            'cta_label' => 'nullable|string|max:100',
            'cta_url' => 'nullable|string|max:255',
            'cta_label_2' => 'nullable|string|max:100',
            'cta_url_2' => 'nullable|string|max:255',
            'is_visible' => 'boolean',
            'order' => 'integer',
        ]);

        if ($request->hasFile('background_image')) {
            $validated['background_image'] = $request->file('background_image')
                ->store('sliders', 'public');
        }

        $slider = Slider::create($validated);
        Cache::forget('homepage_data');

        return response()->json(['message' => 'Slider created', 'slider' => $slider], 201);
    }

    public function updateSlider(Request $request, Slider $slider)
    {
        $validated = $request->validate([
            'heading' => 'sometimes|string|max:255',
            'subheading' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'background_image' => 'nullable|image|max:4096',
            'cta_label' => 'nullable|string|max:100',
            'cta_url' => 'nullable|string|max:255',
            'cta_label_2' => 'nullable|string|max:100',
            'cta_url_2' => 'nullable|string|max:255',
            'is_visible' => 'boolean',
            'order' => 'integer',
        ]);

        if ($request->hasFile('background_image')) {
            $validated['background_image'] = $request->file('background_image')
                ->store('sliders', 'public');
        }

        $slider->update($validated);
        Cache::forget('homepage_data');

        return response()->json(['message' => 'Slider updated', 'slider' => $slider]);
    }

    public function destroySlider(Slider $slider)
    {
        $slider->delete();
        Cache::forget('homepage_data');

        return response()->json(['message' => 'Slider deleted']);
    }

    // ──── SERVICES ────

    public function services()
    {
        return response()->json(Service::orderBy('order')->get());
    }

    public function storeService(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'image' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'features' => 'nullable|array',
            'process_steps' => 'nullable|array',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'order' => 'integer',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $service = Service::create($validated);
        Cache::forget('homepage_data');

        return response()->json(['message' => 'Service created', 'service' => $service], 201);
    }

    public function updateService(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'category' => 'nullable|string|max:100',
            'features' => 'nullable|array',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'order' => 'integer',
        ]);

        if (isset($validated['name'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $service->update($validated);
        Cache::forget('homepage_data');

        return response()->json(['message' => 'Service updated', 'service' => $service]);
    }

    public function destroyService(Service $service)
    {
        $service->delete();
        Cache::forget('homepage_data');

        return response()->json(['message' => 'Service deleted']);
    }

    // ──── PRODUCTS ────

    public function products()
    {
        return response()->json(Product::orderBy('order')->get());
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'price' => 'nullable|numeric|min:0',
            'price_label' => 'nullable|string|max:100',
            'features' => 'nullable|array',
            'specifications' => 'nullable|array',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'order' => 'integer',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $product = Product::create($validated);
        Cache::forget('homepage_data');

        return response()->json(['message' => 'Product created', 'product' => $product], 201);
    }

    public function updateProduct(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'price' => 'nullable|numeric|min:0',
            'features' => 'nullable|array',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'order' => 'integer',
        ]);

        if (isset($validated['name'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $product->update($validated);
        Cache::forget('homepage_data');

        return response()->json(['message' => 'Product updated', 'product' => $product]);
    }

    public function destroyProduct(Product $product)
    {
        $product->delete();
        Cache::forget('homepage_data');

        return response()->json(['message' => 'Product deleted']);
    }

    // ──── CLIENTS ────

    public function clients()
    {
        return response()->json(Client::orderBy('order')->get());
    }

    public function storeClient(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'website_url' => 'nullable|url|max:255',
            'is_visible' => 'boolean',
            'order' => 'integer',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')
                ->store('clients', 'public');
        }

        $client = Client::create($validated);
        Cache::forget('homepage_data');

        return response()->json(['message' => 'Client created', 'client' => $client], 201);
    }

    public function updateClient(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'website_url' => 'nullable|url|max:255',
            'is_visible' => 'boolean',
            'order' => 'integer',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('clients', 'public');
        }

        $client->update($validated);
        Cache::forget('homepage_data');

        return response()->json(['message' => 'Client updated', 'client' => $client]);
    }

    // ──── COUNTERS ────

    public function counters()
    {
        return response()->json(CounterItem::orderBy('order')->get());
    }

    public function storeCounter(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'number' => 'required|integer|min:0',
            'suffix' => 'nullable|string|max:10',
            'icon' => 'nullable|string|max:100',
            'is_visible' => 'boolean',
            'order' => 'integer',
        ]);

        $counter = CounterItem::create($validated);
        Cache::forget('homepage_data');

        return response()->json(['message' => 'Counter created', 'counter' => $counter], 201);
    }

    public function updateCounter(Request $request, CounterItem $counter)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'number' => 'required|integer|min:0',
            'suffix' => 'nullable|string|max:10',
            'icon' => 'nullable|string|max:100',
            'is_visible' => 'boolean',
            'order' => 'integer',
        ]);

        $counter->update($validated);
        Cache::forget('homepage_data');

        return response()->json(['message' => 'Counter updated', 'counter' => $counter]);
    }

    public function destroyClient(Client $client)
    {
        if ($client->logo && Storage::disk('public')->exists($client->logo)) {
            Storage::disk('public')->delete($client->logo);
        }

        $client->delete();
        Cache::forget('homepage_data');

        return response()->json(['message' => 'Client deleted']);
    }

    public function destroyCounter(CounterItem $counter)
    {
        $counter->delete();
        Cache::forget('homepage_data');

        return response()->json(['message' => 'Counter deleted']);
    }
}
