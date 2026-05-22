# SEO & Analytics Integration - Environment Variables Setup

## Required Environment Variables

Add these to your `.env` file to configure SEO and tracking integrations:

### Google Analytics
```env
GOOGLE_ANALYTICS_ENABLED=true
GOOGLE_ANALYTICS_MEASUREMENT_ID=G-XXXXXXXXXX
GOOGLE_ANALYTICS_PROPERTY_ID=123456789
```

### Google Tag Manager
```env
GOOGLE_TAG_MANAGER_ENABLED=true
GOOGLE_TAG_MANAGER_ID=GTM-XXXXXXX
```

### Google Search Console
```env
GOOGLE_SEARCH_CONSOLE_ENABLED=true
GOOGLE_SEARCH_CONSOLE_CODE=your-verification-code
```

### Microsoft Clarity
```env
MICROSOFT_CLARITY_ENABLED=true
MICROSOFT_CLARITY_ID=your-project-id
```

### Facebook Pixel
```env
FACEBOOK_PIXEL_ENABLED=true
FACEBOOK_PIXEL_ID=123456789012345
```

### Twitter Configuration
```env
TWITTER_CARD_TYPE=summary_large_image
TWITTER_HANDLE=@omniviatech
TWITTER_CREATOR=@omniviatech
```

### Schema.org Configuration
```env
SCHEMA_ORG_TYPE=Organization
SCHEMA_ORG_NAME=OmniviaTech
SCHEMA_ORG_LOGO=/storage/logo.png
```

### Contact Information (for Schema)
```env
CONTACT_EMAIL=info@omniviatech.com
CONTACT_PHONE=+254710351517
```

### Caching
```env
SEO_CACHE_ENABLED=true
```

## Google Credentials Files

### 1. Google Analytics Credentials
Place your service account JSON file at: `storage/app/google-analytics-credentials.json`

To get this file:
1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project
3. Enable Google Analytics API
4. Create a Service Account
5. Download the JSON key file

### 2. Google Search Console Credentials
Place your service account JSON file at: `storage/app/google-search-console-credentials.json`

To get this file:
1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Enable Google Search Console API
3. Create a Service Account or use existing one
4. Download the JSON key file with appropriate permissions

## Installation Commands

```bash
# Install dependencies
composer require ralphjsmit/laravel-seo
composer require filament/filament
composer require google/analytics-data

# Publish configuration
php artisan vendor:publish --provider="RalphJSmit\Seo\SeoServiceProvider"
php artisan vendor:publish --tag=seo-config

# Install Filament
php artisan filament:install --panels

# Run migrations
php artisan migrate

# Seed SEO data
php artisan db:seed --class=SeoDataSeeder

# Create symlink for storage (if not already done)
php artisan storage:link
```

## File Structure

After installation, your project will have:

```
├── config/
│   ├── seo.php                          # SEO configuration
│   └── tracking.php                     # Tracking configuration
├── app/
│   ├── Services/
│   │   ├── SeoService.php              # SEO utilities
│   │   └── TrackingService.php          # Tracking integrations
│   ├── Http/Controllers/Api/Admin/
│   │   ├── SeoDataController.php        # Basic SEO CRUD
│   │   └── SeoManagementController.php  # Advanced SEO management
│   ├── Filament/
│   │   ├── Resources/
│   │   │   └── SeoDataResource.php      # Filament SEO admin panel
│   │   └── Widgets/
│   │       └── SeoAuditWidget.php       # SEO audit dashboard
│   └── Models/
│       └── SeoData.php                  # SEO data model
├── storage/app/
│   ├── google-analytics-credentials.json    # Google Analytics service account
│   └── google-search-console-credentials.json # Search Console service account
├── routes/
│   └── api.php                          # API routes with SEO endpoints
└── database/
    ├── migrations/
    │   └── 2026_05_21_000001_create_seo_data_table.php
    └── seeders/
        └── SeoDataSeeder.php
```

## API Endpoints

### SEO Management
- `GET /api/v1/admin/seo` - List all SEO data
- `POST /api/v1/admin/seo` - Create new SEO entry
- `GET /api/v1/admin/seo/{id}` - Get specific SEO entry
- `PUT /api/v1/admin/seo/{id}` - Update SEO entry
- `DELETE /api/v1/admin/seo/{id}` - Delete SEO entry
- `POST /api/v1/admin/seo/preview` - Preview SEO on search results, Facebook, Twitter
- `GET /api/v1/admin/seo/audit/report` - Get SEO audit report
- `POST /api/v1/admin/seo/bulk-update` - Bulk update multiple pages

### Tracking & Analytics
- `GET /api/v1/admin/seo/tracking/config` - Get tracking configuration
- `GET /api/v1/admin/seo/analytics/data` - Get Google Analytics data
- `POST /api/v1/admin/seo/search-console/submit` - Submit URL to Search Console

### Public Endpoints
- `GET /api/v1/seo/page/{pageName}` - Get SEO data for public page

## Access Control

All SEO management endpoints are restricted to:
- Admin role
- Editor role

SEO data is read-only for other authenticated users.

## Front-End Integration

SEO data is automatically injected into the page head via:
- `resources/views/app.blade.php` - Uses SeoService to fetch and render SEO data

The layout file automatically:
1. Fetches SEO data for current page
2. Renders meta tags
3. Includes tracking scripts
4. Adds schema markup

## Testing

To test SEO implementation:

```php
// Get SEO data for a page
$seoData = \App\Models\SeoData::where('page_name', 'homepage')->first();

// Get analytics data
$trackingService = new \App\Services\TrackingService();
$analyticsData = $trackingService->getGoogleAnalyticsData('30daysAgo', 'today');

// Submit URL to Search Console
$result = $trackingService->submitUrlToSearchConsole('https://omniviatech.com/services');
```

## Troubleshooting

### Google Analytics credentials not found
- Ensure JSON file exists at `storage/app/google-analytics-credentials.json`
- Check file permissions

### Search Console submission failing
- Verify credentials file is correct
- Check that service account has appropriate permissions
- Ensure URL is valid and accessible

### Tracking scripts not showing
- Verify environment variables are set
- Check that configurations are enabled in `config/tracking.php`
- Clear browser cache

## Documentation Links

- [Filament Admin Panel](https://filamentphp.com/)
- [Google Analytics API](https://developers.google.com/analytics)
- [Google Search Console API](https://developers.google.com/webmaster-tools)
- [Microsoft Clarity](https://clarity.microsoft.com/)
- [Open Graph Protocol](https://ogp.me/)
- [Twitter Card Documentation](https://developer.twitter.com/en/docs/twitter-for-websites/cards)
