<?php

namespace App\Http\Controllers;

use App\Services\SiteSeo;
use App\Support\PageCache;
use Illuminate\Http\Request;

class SpaController extends Controller
{
    /** Serve the Vue app with the correct search-engine data and HTTP status for this URL. */
    public function __invoke(Request $request, SiteSeo $siteSeo)
    {
        $seo = $siteSeo->resolve($request->path());

        $response = response()->view('app', ['seo' => $seo], $seo['status']);
        PageCache::store($request, $response);

        return $response;
    }

    public function sitemap(SiteSeo $siteSeo)
    {
        return response()
            ->view('sitemap', ['entries' => $siteSeo->sitemapEntries()])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function indexNowKey()
    {
        return response(SiteSeo::indexNowKey(), 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }

    /** Page data for in-app navigation, so titles and breadcrumbs stay correct. */
    public function pageSeo(Request $request, SiteSeo $siteSeo)
    {
        $seo = $siteSeo->resolve((string) $request->query('path', '/'));

        return response()->json([
            'title' => $seo['title'],
            'description' => $seo['description'],
            'canonical' => $seo['canonical'],
            'image' => $seo['image'],
            'robots' => $seo['robots'],
            'type' => $seo['type'],
            'breadcrumb_schema' => $seo['breadcrumb_schema'],
        ]);
    }
}
