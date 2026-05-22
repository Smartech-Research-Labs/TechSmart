<?php

namespace App\Services;

use Exception;
use Google\Analytics\Data\V1beta\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Dimension;
use Google\Analytics\Data\V1beta\Metric;
use Google\Analytics\Data\V1beta\RunReportRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class TrackingService
{
    protected $config;

    public function __construct()
    {
        $this->config = config('tracking');
    }

    /**
     * Get Google Analytics data for a date range.
     */
    public function getGoogleAnalyticsData($startDate = '30daysAgo', $endDate = 'today'): array
    {
        try {
            if (!$this->config['google_analytics']['enabled']) {
                return [];
            }

            $cacheKey = "ga_data_{$startDate}_{$endDate}";
            
            if (Cache::has($cacheKey)) {
                return Cache::get($cacheKey);
            }

            $propertyId = $this->config['google_analytics']['property_id'];
            $credentialsPath = $this->config['google_analytics']['credentials_path'];

            if (!file_exists($credentialsPath)) {
                return ['error' => 'Google Analytics credentials not found'];
            }

            $client = new BetaAnalyticsDataClient([
                'credentials' => $credentialsPath,
            ]);

            $request = new RunReportRequest([
                'property' => "properties/{$propertyId}",
                'date_ranges' => [
                    new DateRange([
                        'start_date' => $startDate,
                        'end_date' => $endDate,
                    ]),
                ],
                'dimensions' => [
                    new Dimension(['name' => 'pagePath']),
                    new Dimension(['name' => 'country']),
                ],
                'metrics' => [
                    new Metric(['name' => 'activeUsers']),
                    new Metric(['name' => 'sessions']),
                    new Metric(['name' => 'screenPageViews']),
                    new Metric(['name' => 'bounceRate']),
                    new Metric(['name' => 'engagementRate']),
                    new Metric(['name' => 'averageSessionDuration']),
                ],
            ]);

            $response = $client->runReport($request);

            $data = [
                'date_range' => [
                    'start' => $startDate,
                    'end' => $endDate,
                ],
                'rows' => [],
                'totals' => [],
            ];

            // Process rows
            foreach ($response->getRows() as $row) {
                $data['rows'][] = [
                    'page' => $row->getDimensions()[0]->getValue(),
                    'country' => $row->getDimensions()[1]->getValue(),
                    'users' => (int)$row->getMetricValues()[0]->getValue(),
                    'sessions' => (int)$row->getMetricValues()[1]->getValue(),
                    'views' => (int)$row->getMetricValues()[2]->getValue(),
                    'bounce_rate' => (float)$row->getMetricValues()[3]->getValue(),
                    'engagement_rate' => (float)$row->getMetricValues()[4]->getValue(),
                    'avg_duration' => (float)$row->getMetricValues()[5]->getValue(),
                ];
            }

            // Process totals
            foreach ($response->getTotals() as $total) {
                $data['totals'] = [
                    'users' => (int)$total->getMetricValues()[0]->getValue(),
                    'sessions' => (int)$total->getMetricValues()[1]->getValue(),
                    'views' => (int)$total->getMetricValues()[2]->getValue(),
                    'bounce_rate' => (float)$total->getMetricValues()[3]->getValue(),
                    'engagement_rate' => (float)$total->getMetricValues()[4]->getValue(),
                    'avg_duration' => (float)$total->getMetricValues()[5]->getValue(),
                ];
            }

            Cache::put($cacheKey, $data, 3600); // Cache for 1 hour

            return $data;
        } catch (Exception $e) {
            \Log::error('Google Analytics Error: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Submit URL to Google Search Console for indexing.
     */
    public function submitUrlToSearchConsole(string $url): array
    {
        try {
            if (!$this->config['google_search_console']['enabled']) {
                return ['error' => 'Google Search Console not enabled'];
            }

            $siteUrl = $this->config['google_search_console']['site_url'];
            $credentialsPath = $this->config['google_search_console']['credentials_path'];

            if (!file_exists($credentialsPath)) {
                return ['error' => 'Search Console credentials not found'];
            }

            $credentials = json_decode(file_get_contents($credentialsPath), true);
            $accessToken = $this->getGoogleAccessToken($credentials);

            if (!$accessToken) {
                return ['error' => 'Failed to get access token'];
            }

            $response = Http::withToken($accessToken)->post(
                "https://www.googleapis.com/indexing/v3/urlNotifications:publish",
                [
                    'url' => $url,
                    'type' => 'URL_UPDATED',
                ]
            );

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'URL submitted to Search Console',
                    'data' => $response->json(),
                ];
            }

            return [
                'error' => $response->body(),
            ];
        } catch (Exception $e) {
            \Log::error('Search Console Error: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Get access token for Google APIs.
     */
    protected function getGoogleAccessToken(array $credentials): ?string
    {
        try {
            $response = Http::post('https://oauth2.googleapis.com/token', [
                'type' => $credentials['type'],
                'project_id' => $credentials['project_id'],
                'private_key_id' => $credentials['private_key_id'],
                'private_key' => $credentials['private_key'],
                'client_email' => $credentials['client_email'],
                'client_id' => $credentials['client_id'],
                'auth_uri' => $credentials['auth_uri'],
                'token_uri' => $credentials['token_uri'],
                'auth_provider_x509_cert_url' => $credentials['auth_provider_x509_cert_url'],
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $this->createJWT($credentials),
            ]);

            if ($response->successful()) {
                return $response->json()['access_token'];
            }

            return null;
        } catch (Exception $e) {
            \Log::error('Google Token Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Create JWT for Google service account.
     */
    protected function createJWT(array $credentials): string
    {
        $now = time();
        $header = json_encode(['alg' => 'RS256', 'typ' => 'JWT']);
        $claims = json_encode([
            'iss' => $credentials['client_email'],
            'scope' => 'https://www.googleapis.com/auth/indexing',
            'aud' => 'https://oauth2.googleapis.com/token',
            'exp' => $now + 3600,
            'iat' => $now,
        ]);

        $header64 = rtrim(strtr(base64_encode($header), '+/', '-_'), '=');
        $claims64 = rtrim(strtr(base64_encode($claims), '+/', '-_'), '=');
        $signature64 = rtrim(strtr(base64_encode(
            hash_hmac('sha256', "{$header64}.{$claims64}", $credentials['private_key'], true)
        ), '+/', '-_'), '=');

        return "{$header64}.{$claims64}.{$signature64}";
    }

    /**
     * Get Microsoft Clarity script tag.
     */
    public function getClarityScriptTag(): ?string
    {
        if (!$this->config['microsoft_clarity']['enabled']) {
            return null;
        }

        $projectId = $this->config['microsoft_clarity']['project_id'];

        if (!$projectId) {
            return null;
        }

        return <<<HTML
            <script type="text/javascript">
                (function(c,l,a,r,i,t,y){
                    c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
                    t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
                    y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
                })(window, document, "clarity", "script", "{$projectId}");
            </script>
            HTML;
    }

    /**
     * Get Google Analytics script tag.
     */
    public function getAnalyticsScriptTag(): ?string
    {
        if (!$this->config['google_analytics']['enabled']) {
            return null;
        }

        $measurementId = $this->config['google_analytics']['measurement_id'];

        if (!$measurementId) {
            return null;
        }

        return <<<HTML
            <!-- Google Analytics -->
            <script async src="https://www.googletagmanager.com/gtag/js?id={$measurementId}"></script>
            <script>
              window.dataLayer = window.dataLayer || [];
              function gtag(){dataLayer.push(arguments);}
              gtag('js', new Date());
              gtag('config', '{$measurementId}');
            </script>
            HTML;
    }

    /**
     * Get Google Tag Manager script tag.
     */
    public function getGTMScriptTag(): ?string
    {
        if (!$this->config['google_tag_manager']['enabled']) {
            return null;
        }

        $containerId = $this->config['google_tag_manager']['container_id'];

        if (!$containerId) {
            return null;
        }

        return <<<HTML
            <!-- Google Tag Manager -->
            <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','{$containerId}');</script>
            HTML;
    }

    /**
     * Get Facebook Pixel script tag.
     */
    public function getFacebookPixelScriptTag(): ?string
    {
        if (!$this->config['facebook_pixel']['enabled']) {
            return null;
        }

        $pixelId = $this->config['facebook_pixel']['pixel_id'];

        if (!$pixelId) {
            return null;
        }

        return <<<HTML
            <!-- Facebook Pixel -->
            <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{$pixelId}');
            fbq('track', 'PageView');
            </script>
            <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id={$pixelId}&ev=PageView&noscript=1"
            /></noscript>
            HTML;
    }

    /**
     * Get all tracking scripts for head section.
     */
    public function getHeadTrackingScripts(): string
    {
        $scripts = [
            $this->getGTMScriptTag(),
            $this->getAnalyticsScriptTag(),
            $this->getClarityScriptTag(),
        ];

        return implode("\n", array_filter($scripts));
    }

    /**
     * Get GTM noscript fallback.
     */
    public function getGTMNoScriptTag(): ?string
    {
        if (!$this->config['google_tag_manager']['enabled']) {
            return null;
        }

        $containerId = $this->config['google_tag_manager']['container_id'];

        if (!$containerId) {
            return null;
        }

        return <<<HTML
            <!-- Google Tag Manager (noscript) -->
            <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={$containerId}"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
            HTML;
    }

    /**
     * Push event to data layer for GTM.
     */
    public function pushDataLayerEvent(string $event, array $data = []): array
    {
        return [
            'event' => $event,
            'timestamp' => now()->toIso8601String(),
            ...$data,
        ];
    }
}
