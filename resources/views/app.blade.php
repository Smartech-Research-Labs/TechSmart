<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @php
            $seo ??= app(\App\Services\SiteSeo::class)->resolve(request()->path());
            $jsonLd = fn ($data) => json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP);
            $siteName = \App\Models\Setting::get('site_name', config('app.name', 'OmniviaTech'));
            $metaTitle = $seo['title'];
            $metaDesc = $seo['description'];
            $metaKeywords = \App\Models\Setting::get('meta_keywords', '');
            $currentUrl = $seo['canonical'];

            $faviconPath = \App\Models\Setting::get('favicon_path');
            $faviconUrl = $faviconPath ? asset('storage/' . $faviconPath) : asset('favicon.ico');
            $logoPath = \App\Models\Setting::get('logo_path');
            $logoUrl = $logoPath ? asset('storage/' . $logoPath) : '';

            $ogImage = $seo['image'];

            $schemaOrgType = \App\Models\Setting::get('schema_org_type', 'Organization');
            $schemaOrgName = \App\Models\Setting::get('schema_org_name', $siteName);
            $schemaOrgLogo = \App\Models\Setting::get('schema_org_logo', $logoUrl);
            $schemaSameAs = \App\Models\Setting::get('schema_same_as', '');
            $address = \App\Models\Setting::get('address', '');
            $city = \App\Models\Setting::get('city', '');
            $country = \App\Models\Setting::get('country', '');

            $twitterCardType = \App\Models\Setting::get('twitter_card_type', 'summary_large_image');
            $twitterHandle = \App\Models\Setting::get('twitter_handle', '');

            $gaId = \App\Models\Setting::get('google_analytics_id') ?: config('seo.tracking.google_analytics');
            $gtmId = \App\Models\Setting::get('google_tag_manager_id') ?: config('seo.tracking.google_tag_manager');
            $fbPixelId = \App\Models\Setting::get('facebook_pixel_id', '');
            $hotjarId = \App\Models\Setting::get('hotjar_id', '');
            $searchConsole = \App\Models\Setting::get('google_search_console') ?: config('seo.search_console.verification_code');
            $clarityId = \App\Models\Setting::get('clarity_id') ?: config('seo.tracking.microsoft_clarity');

            $customHeadScripts = \App\Models\Setting::get('custom_head_scripts', '');
            $customBodyScripts = \App\Models\Setting::get('custom_body_scripts', '');
        @endphp

        <title>{{ $metaTitle }}</title>
        <meta name="description" content="{{ $metaDesc }}">
        <meta name="robots" content="{{ $seo['robots'] }}">
        @if($metaKeywords)
            <meta name="keywords" content="{{ $metaKeywords }}">
        @endif

        {{-- Fetch the font and the home hero image straight away, before the app's JavaScript runs --}}
        <link rel="preload" href="/fonts/dm-sans/dm-sans-latin-wght-normal.woff2" as="font" type="font/woff2" crossorigin>
        @if($seo['name'] === 'Home')
            <link rel="preload" href="{{ \Illuminate\Support\Facades\Vite::asset('resources/img/tech-background.webp') }}" as="image" type="image/webp" fetchpriority="high">
        @endif
        <meta name="google-site-verification" content="9K72kf0v5VJc43JFCOKJ11LyxHjRXW-i8X9oZEU_zhc" />
        @if($searchConsole && $searchConsole !== '9K72kf0v5VJc43JFCOKJ11LyxHjRXW-i8X9oZEU_zhc')
            <meta name="google-site-verification" content="{{ $searchConsole }}">
        @endif

        <link rel="canonical" href="{{ $currentUrl }}">
        <link rel="robots" href="{{ asset('robots.txt') }}">
        <link rel="sitemap" type="application/xml" href="{{ asset('sitemap.xml') }}">

        <link rel="icon" href="{{ $faviconUrl }}" sizes="any">
        <link rel="icon" href="{{ $faviconUrl }}" type="image/{{ $faviconPath ? pathinfo($faviconUrl, PATHINFO_EXTENSION) : 'ico' }}">
        <link rel="apple-touch-icon" href="{{ $faviconUrl }}">

        <!-- Open Graph -->
        <meta property="og:title" content="{{ $metaTitle }}">
        <meta property="og:description" content="{{ $metaDesc }}">
        <meta property="og:url" content="{{ $currentUrl }}">
        <meta property="og:type" content="{{ $seo['type'] }}">
        <meta property="og:locale" content="en_KE">
        <meta property="og:site_name" content="{{ $siteName }}">
        @if($ogImage)
            <meta property="og:image" content="{{ $ogImage }}">
        @endif

        <!-- Twitter Card -->
        <meta name="twitter:card" content="{{ $twitterCardType }}">
        <meta name="twitter:title" content="{{ $metaTitle }}">
        <meta name="twitter:description" content="{{ $metaDesc }}">
        @if($ogImage)
            <meta name="twitter:image" content="{{ $ogImage }}">
        @endif
        @if($twitterHandle)
            <meta name="twitter:site" content="{{ $twitterHandle }}">
        @endif

        <!-- Structured data -->
        <script type="application/ld+json">{!! $jsonLd(app(\App\Services\SiteSeo::class)->siteSchema()) !!}</script>
        @if($seo['breadcrumb_schema'])
            <script id="page-breadcrumb-schema" type="application/ld+json">{!! $jsonLd($seo['breadcrumb_schema']) !!}</script>
        @endif
        @if($seo['article_schema'])
            <script id="page-article-schema" type="application/ld+json">{!! $jsonLd($seo['article_schema']) !!}</script>
        @endif

        {{-- Analytics and ad pixels load on the visitor's first interaction (scroll, tap, key, mouse move),
             so they never compete with the page itself for bandwidth or the main thread. --}}
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            (function (w, d) {
                var done = false, events = ['scroll', 'wheel', 'pointerdown', 'pointermove', 'keydown', 'touchstart'];
                function add(src) { var s = d.createElement('script'); s.async = true; s.src = src; d.head.appendChild(s); }
                function load() {
                    if (done) return;
                    done = true;
                    events.forEach(function (e) { w.removeEventListener(e, load, { passive: true }); });
                    @if($gaId)
                        gtag('js', new Date());
                        gtag('config', @json($gaId));
                        add('https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(@json($gaId)));
                    @endif
                    @if($gtmId)
                        w.dataLayer.push({'gtm.start': new Date().getTime(), event: 'gtm.js'});
                        add('https://www.googletagmanager.com/gtm.js?id=' + encodeURIComponent(@json($gtmId)));
                    @endif
                    @if($fbPixelId)
                        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(w,d,'script','https://connect.facebook.net/en_US/fbevents.js');
                        fbq('init', @json($fbPixelId));
                        fbq('track', 'PageView');
                    @endif
                    @if($clarityId)
                        w.clarity = w.clarity || function () { (w.clarity.q = w.clarity.q || []).push(arguments); };
                        add('https://www.clarity.ms/tag/' + encodeURIComponent(@json($clarityId)));
                    @endif
                    @if($hotjarId)
                        w.hj = w.hj || function () { (w.hj.q = w.hj.q || []).push(arguments); };
                        w._hjSettings = { hjid: @json($hotjarId), hjsv: 6 };
                        add('https://static.hotjar.com/c/hotjar-' + w._hjSettings.hjid + '.js?sv=6');
                    @endif
                    // TikTok Pixel
                    !function (w, d, t) {
                      w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie","holdConsent","revokeConsent","grantConsent"],ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(
                    var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e},ttq.load=function(e,n){var r="https://analytics.tiktok.com/i18n/pixel/events.js",o=n&&n.partner;ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=r,ttq._t=ttq._t||{},ttq._t[e]=+new Date,ttq._o=ttq._o||{},ttq._o[e]=n||{};n=document.createElement("script")
                    ;n.type="text/javascript",n.async=!0,n.src=r+"?sdkid="+e+"&lib="+t;e=document.getElementsByTagName("script")[0];e.parentNode.insertBefore(n,e)};
                      ttq.load('DBU1NG3C77U7CBT65HOG');
                      ttq.page();
                    }(w, d, 'ttq');
                }
                events.forEach(function (e) { w.addEventListener(e, load, { passive: true }); });
            })(window, document);
        </script>

        @if($customHeadScripts)
            {!! $customHeadScripts !!}
        @endif

        @php
            // The stylesheet downloads at full priority but doesn't hold up the first paint
            // (the home page paints its own still copy straight away). app.ts starts the app
            // once the styles are applied, so the app itself never shows unstyled.
            \Illuminate\Support\Facades\Vite::useStyleTagAttributes(fn () => [
                'rel' => 'preload',
                'as' => 'style',
                'data-app-css' => true,
                'onload' => "this.onload=null;this.rel='stylesheet'",
            ]);
        @endphp
        @if($seo['name'] === 'Home')
            {{-- Added by the script at the end of the page once the still copy has painted --}}
            <template id="app-boot">@vite(['resources/js/app.ts'])</template>
        @else
            @vite(['resources/js/app.ts'])
        @endif
    </head>
    <body class="font-sans antialiased">
        @if($gtmId)
            <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $gtmId }}" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        @endif

        <div id="app">
            @if($seo['name'] === 'Home')
                @include('partials.home-shell')
            @endif
            {{-- Replaced as soon as the app starts; gives crawlers the page content and links in the first response. --}}
            <div style="position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;">
                <nav aria-label="Main">
                    @foreach ($seo['key_links'] as $link)
                        <a href="{{ $link['url'] }}">{{ $link['label'] }}</a>
                    @endforeach
                </nav>
                @if (count($seo['breadcrumbs']) > 1)
                    <nav aria-label="Breadcrumb">
                        @foreach ($seo['breadcrumbs'] as $crumb)
                            <a href="{{ $crumb['url'] }}">{{ $crumb['name'] }}</a>
                        @endforeach
                    </nav>
                @endif
                <main>
                    @if($seo['name'] !== 'Home')
                        <h1>{{ $seo['name'] }}</h1>
                    @endif
                    <p>{{ $seo['description'] }}</p>
                    @if ($seo['body'])
                        <article>{!! $seo['body'] !!}</article>
                    @endif
                    @foreach ($seo['links'] as $link)
                        <a href="{{ $link['url'] }}">{{ $link['label'] }}</a>
                    @endforeach
                </main>
            </div>
        </div>

        @if($seo['name'] === 'Home')
            <script>
                // Start the app once the still copy of the page and its hero image are on screen,
                // so its downloads don't compete with that first paint. A tap or key press starts it at once.
                (function (w, d) {
                    var started = false, img = d.querySelector('.hs-bg');
                    function boot() {
                        if (started) return;
                        started = true;
                        d.head.appendChild(d.importNode(d.getElementById('app-boot').content, true));
                    }
                    // Browsers that report paints: start as soon as the hero image has been shown.
                    // Others (Safari): start shortly after it has loaded.
                    var P = w.PerformanceObserver;
                    if (img && P && (P.supportedEntryTypes || []).indexOf('largest-contentful-paint') > -1) {
                        new P(function (list) {
                            list.getEntries().forEach(function (e) { if (e.element === img) setTimeout(boot, 0); });
                        }).observe({ type: 'largest-contentful-paint', buffered: true });
                    }
                    function afterLoad() { setTimeout(boot, 300); }
                    if (!img || img.complete) afterLoad();
                    else { img.addEventListener('load', afterLoad); img.addEventListener('error', boot); }
                    ['pointerdown', 'keydown', 'touchstart'].forEach(function (e) { w.addEventListener(e, boot, { once: true, passive: true }); });
                    setTimeout(boot, 2500);
                })(window, document);
            </script>
        @endif

        @if($customBodyScripts)
            {!! $customBodyScripts !!}
        @endif
    </body>
</html>