﻿<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @php
            $siteName = \App\Models\Setting::get('site_name', config('app.name', 'OmniviaTech'));
            $metaTitle = \App\Models\Setting::get('meta_title', $siteName);
            $metaDesc = \App\Models\Setting::get('meta_description', \App\Models\Setting::get('site_description', ''));
            $metaKeywords = \App\Models\Setting::get('meta_keywords', '');
            $canonicalUrl = \App\Models\Setting::get('canonical_url', url('/'));
            $currentUrl = url()->current();

            $faviconPath = \App\Models\Setting::get('favicon_path');
            $faviconUrl = $faviconPath ? asset('storage/' . $faviconPath) : asset('favicon.ico');
            $logoPath = \App\Models\Setting::get('logo_path');
            $logoUrl = $logoPath ? asset('storage/' . $logoPath) : '';

            $ogImageDefault = \App\Models\Setting::get('og_image_default', '');
            $ogImage = $ogImageDefault ?: (\App\Models\Setting::get('schema_org_logo', '') ?: $logoUrl);

            $schemaOrgType = \App\Models\Setting::get('schema_org_type', 'Organization');
            $schemaOrgName = \App\Models\Setting::get('schema_org_name', $siteName);
            $schemaOrgLogo = \App\Models\Setting::get('schema_org_logo', $logoUrl);
            $schemaSameAs = \App\Models\Setting::get('schema_same_as', '');
            $address = \App\Models\Setting::get('address', '');
            $city = \App\Models\Setting::get('city', '');
            $country = \App\Models\Setting::get('country', '');

            $twitterCardType = \App\Models\Setting::get('twitter_card_type', 'summary_large_image');
            $twitterHandle = \App\Models\Setting::get('twitter_handle', '');

            $gaId = \App\Models\Setting::get('google_analytics_id', '');
            $gtmId = \App\Models\Setting::get('google_tag_manager_id', '');
            $fbPixelId = \App\Models\Setting::get('facebook_pixel_id', '');
            $hotjarId = \App\Models\Setting::get('hotjar_id', '');
            $searchConsole = \App\Models\Setting::get('google_search_console', '');
            $clarityId = \App\Models\Setting::get('clarity_id', '');

            $customHeadScripts = \App\Models\Setting::get('custom_head_scripts', '');
            $customBodyScripts = \App\Models\Setting::get('custom_body_scripts', '');
        @endphp

        <title>{{ $metaTitle }}</title>
        <meta name="description" content="{{ $metaDesc }}">
        @if($metaKeywords)
            <meta name="keywords" content="{{ $metaKeywords }}">
        @endif

        <!-- Performance Optimization: Resource Hints -->
        <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://cdnjs.cloudflare.com">
        <link rel="prefetch" href="//www.google-analytics.com/analytics.js" as="script">
        @if($searchConsole)
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
        <meta property="og:type" content="website">
        <meta property="og:locale" content="en_US">
        <meta property="og:site_name" content="{{ $siteName }}">
        @if($ogImage)
            <meta property="og:image" content="{{ $ogImage }}">
            <meta property="og:image:width" content="1200">
            <meta property="og:image:height" content="630">
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

        <!-- JSON-LD: Organization -->
        <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@@type": "{{ $schemaOrgType }}",
            "name": "{{ $schemaOrgName }}",
            "url": "{{ $canonicalUrl }}",
            "description": "{{ $metaDesc }}"
            @if($schemaOrgLogo)
                ,"logo": "{{ $schemaOrgLogo }}"
            @endif
            @if($schemaSameAs)
                ,"sameAs": [@foreach(explode("\n", $schemaSameAs) as $url)"{{ trim($url) }}"@if(!$loop->last),@endif @endforeach]
            @endif
            @if($address || $city || $country)
                ,"address": {
                    "@@type": "PostalAddress"
                    @if($address)
                        ,"streetAddress": "{{ $address }}"
                    @endif
                    @if($city)
                        ,"addressLocality": "{{ $city }}"
                    @endif
                    @if($country)
                        ,"addressCountry": "{{ $country }}"
                    @endif
                }
            @endif
        }
        </script>

        <!-- JSON-LD: WebSite -->
        <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@@type": "WebSite",
            "name": "{{ $siteName }}",
            "url": "{{ $canonicalUrl }}",
            "description": "{{ $metaDesc }}"
            @if($schemaSameAs)
                ,"sameAs": [@foreach(explode("\n", $schemaSameAs) as $url)"{{ trim($url) }}"@if(!$loop->last),@endif @endforeach]
            @endif
        }
        </script>

        @if($gaId)
            <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);}
                gtag('js', new Date());
                gtag('config', '{{ $gaId }}');
            </script>
        @endif

        @if($gtmId)
            <script>
                (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
                })(window,document,'script','dataLayer','{{ $gtmId }}');
            </script>
        @endif

        @if($fbPixelId)
            <script>
                !function(f,b,e,v,n,t,s)
                {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
                n.callMethod.apply(n,arguments):n.queue.push(arguments)};
                if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
                n.queue=[];t=b.createElement(e);t.async=!0;
                t.src=v;s=b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t,s)}(window, document,'script',
                'https://connect.facebook.net/en_US/fbevents.js');
                fbq('init', '{{ $fbPixelId }}');
                fbq('track', 'PageView');
            </script>
            <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id={{ $fbPixelId }}&ev=PageView&noscript=1"/></noscript>
        @endif

        @if($clarityId)
            <script type="text/javascript">
                (function(c,l,a,r,i,t,y){
                    c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
                    t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
                    y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
                })(window, document, "clarity", "script", "{{ $clarityId }}");
            </script>
        @endif

        @if($hotjarId)
            <script>
                (function(h,o,t,j,a,r){
                    h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
                    h._hjSettings={hjid:{{ $hotjarId }},hjsv:6};
                    a=o.getElementsByTagName('head')[0];
                    r=o.createElement('script');r.async=1;
                    r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
                    a.appendChild(r);
                })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
            </script>
        @endif

        @if($customHeadScripts)
            {!! $customHeadScripts !!}
        @endif

        @vite(['resources/js/app.ts'])
    </head>
    <body class="font-sans antialiased">
        @if($gtmId)
            <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $gtmId }}" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        @endif

        <div id="app"></div>

        @if($customBodyScripts)
            {!! $customBodyScripts !!}
        @endif
    </body>
</html>