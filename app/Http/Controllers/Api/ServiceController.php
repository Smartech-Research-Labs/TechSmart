<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::where('is_published', true)
            ->orderBy('order')
            ->get();

        return response()->json($services);
    }

    public function show($slug)
    {
        $service = Service::where('slug', $slug)
            ->where('is_published', true)
            ->with(['reviews' => function ($query) {
                $query->approved()->with('user')->latest()->take(10);
            }])
            ->firstOrFail();

        return response()->json($service);
    }

    public function byCategory($category)
    {
        $services = Service::where('category', $category)
            ->where('is_published', true)
            ->orderBy('order')
            ->get();

        return response()->json($services);
    }
}
