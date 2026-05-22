# 🏗️ SEO Management System Architecture

## System Overview

```
┌─────────────────────────────────────────────────────────────────────────┐
│                         OMNIVIATECH SEO SYSTEM                          │
│                    Enterprise-Grade Implementation                       │
└─────────────────────────────────────────────────────────────────────────┘

                                ┌──────────────────┐
                                │  Admin Panel     │
                                │ (Filament)       │
                                │   /admin/seo     │
                                └────────┬─────────┘
                                         │
                    ┌────────────────────┼────────────────────┐
                    │                    │                    │
            ┌───────▼────────┐  ┌────────▼─────────┐  ┌──────▼──────────┐
            │ Create SEO     │  │ Edit SEO         │  │ View Analytics  │
            │ Entry          │  │ Page             │  │ & Reports       │
            └───────┬────────┘  └────────┬─────────┘  └──────┬──────────┘
                    │                    │                    │
                    └────────────────────┼────────────────────┘
                                         │
                    ┌────────────────────▼────────────────────┐
                    │     API Layer                          │
                    │ (SeoManagementController)              │
                    │ /api/v1/admin/seo/*                    │
                    └────────────────────┬────────────────────┘
                                         │
                ┌────────────────────────┼────────────────────────┐
                │                        │                        │
        ┌───────▼────────────┐  ┌────────▼──────────┐  ┌─────────▼────────┐
        │ Service Layer      │  │ Configuration    │  │ Middleware       │
        │ ┌────────────────┐ │  │ ┌──────────────┐ │  │ ┌──────────────┐ │
        │ │ SeoService     │ │  │ │ config/seo   │ │  │ │ Authorization│ │
        │ │ ├─ Schema Gen  │ │  │ │ config/track │ │  │ │ Role Check   │ │
        │ │ └─ Page Lookup │ │  │ └──────────────┘ │  │ │ Auth Sanctum │ │
        │ │                │ │  │                  │  │ └──────────────┘ │
        │ │ Tracking       │ │  │                  │  │                  │
        │ │ Service        │ │  │                  │  │                  │
        │ │ ├─ GA4         │ │  │                  │  │                  │
        │ │ ├─ GTM         │ │  │                  │  │                  │
        │ │ ├─ GSC         │ │  │                  │  │                  │
        │ │ ├─ Clarity     │ │  │                  │  │                  │
        │ │ ├─ FB Pixel    │ │  │                  │  │                  │
        │ │ └─ Hotjar      │ │  │                  │  │                  │
        │ └────────────────┘ │  │                  │  │                  │
        └───────┬────────────┘  └──────────────────┘  └──────────────────┘
                │
        ┌───────▼────────────────────────────────┐
        │      Database Layer (PostgreSQL)       │
        │  ┌─────────────────────────────────┐  │
        │  │ seo_data                        │  │
        │  │ ├─ page_name (unique)          │  │
        │  │ ├─ page_type (enum)            │  │
        │  │ ├─ meta_title                  │  │
        │  │ ├─ meta_description            │  │
        │  │ ├─ meta_keywords               │  │
        │  │ ├─ og_title/og_description     │  │
        │  │ ├─ twitter_card/twitter_title  │  │
        │  │ ├─ schema_markup (JSON)        │  │
        │  │ ├─ index/follow (boolean)      │  │
        │  │ ├─ created_at/updated_at       │  │
        │  │ └─ deleted_at (soft delete)    │  │
        │  │ (22 columns total)             │  │
        │  └─────────────────────────────────┘  │
        └────────────────────────────────────────┘
                         │
        ┌────────────────┴────────────────┐
        │                                 │
        │  18 Pre-Populated Records       │
        │  ├─ Homepage                    │
        │  ├─ Services (8 pages)          │
        │  ├─ Products                    │
        │  ├─ Blog                        │
        │  ├─ Case Studies                │
        │  ├─ About                       │
        │  ├─ Contact                     │
        │  ├─ FAQs                        │
        │  ├─ Privacy Policy              │
        │  └─ Terms of Service            │
        │                                 │
        └─────────────────────────────────┘
```

---

## Data Flow Diagram

```
CLIENT REQUEST
      │
      ▼
┌─────────────────┐
│ HTTP Request    │
│ /admin/seo      │
└────────┬────────┘
         │
         ▼
┌─────────────────────────────────┐
│ Filament Admin Panel            │
│ - Routes authenticated          │
│ - Role-based access check       │
└────────┬────────────────────────┘
         │
         ▼
┌─────────────────────────────────┐
│ SeoDataResource                 │
│ - Form Builder                  │
│ - Validation Rules              │
│ - Image Uploads                 │
└────────┬────────────────────────┘
         │
    ┌────┴────┐
    │          │
    ▼          ▼
SAVE      PREVIEW
    │          │
    ▼          ▼
┌────────────────────────────────┐
│ SeoManagementController        │
│ - store() / update()           │
│ - preview()                    │
│ - analyticsData()              │
│ - audit()                      │
└────────┬───────────────────────┘
         │
         ▼
┌──────────────────────────────────┐
│ Database Operations              │
│ - SeoData::create()             │
│ - SeoData::update()             │
│ - SeoData::find()               │
│ - Image storage (public/seo)    │
└────────┬─────────────────────────┘
         │
         ▼
┌──────────────────────────────────┐
│ Tracking Service Calls           │
│ - submitUrlToSearchConsole()     │
│ - getGoogleAnalyticsData()       │
│ - getClarityScriptTag()          │
│ (Optional - if enabled)          │
└────────┬─────────────────────────┘
         │
         ▼
┌──────────────────────────────────┐
│ Response to Admin Panel          │
│ - Updated table view             │
│ - Success/Error message          │
│ - Redirect to list              │
└──────────────────────────────────┘
```

---

## Component Interaction Diagram

```
                    ┌─────────────────────────┐
                    │  Front-End User         │
                    │  (Admin accessing UI)   │
                    └────────────┬────────────┘
                                 │
                                 ▼
                    ┌─────────────────────────┐
                    │  Filament Admin Panel   │
                    │                         │
                    │  SeoDataResource       │
                    │  ├─ Form (6 tabs)      │
                    │  ├─ Table (List view) │
                    │  └─ Actions (CRUD)    │
                    │                         │
                    │  Pages:                │
                    │  ├─ ListSeoData        │
                    │  ├─ CreateSeoData      │
                    │  └─ EditSeoData        │
                    └────────────┬────────────┘
                                 │
                                 ▼
                    ┌─────────────────────────┐
                    │  API Routes             │
                    │  /api/v1/admin/seo/*   │
                    │                         │
                    │  Protected by:          │
                    │  ├─ auth:sanctum       │
                    │  ├─ role:admin|editor  │
                    │  └─ Middleware checks   │
                    └────────────┬────────────┘
                                 │
                                 ▼
                    ┌─────────────────────────┐
                    │  Controllers            │
                    │                         │
                    │  SeoManagement         │
                    │  Controller (10 methods)│
                    │  ├─ index()             │
                    │  ├─ store()             │
                    │  ├─ show()              │
                    │  ├─ update()            │
                    │  ├─ destroy()           │
                    │  ├─ preview()           │
                    │  ├─ tracking/config()   │
                    │  ├─ analytics/data()    │
                    │  ├─ search-console/    │
                    │  │  submit()            │
                    │  └─ audit/report()      │
                    │                         │
                    │  SeoData               │
                    │  Controller            │
                    │  ├─ CRUD ops           │
                    │  └─ getByPageName()    │
                    └────────────┬────────────┘
                                 │
                    ┌────────────────────────────┐
                    │                            │
                    ▼                            ▼
        ┌─────────────────────────┐  ┌──────────────────────────┐
        │  SeoService             │  │  TrackingService         │
        │                         │  │                          │
        │  Schema Generation:     │  │  Integrations:           │
        │  ├─ Organization()      │  │  ├─ Google Analytics    │
        │  ├─ Service()           │  │  ├─ Google Tag Manager  │
        │  ├─ Product()           │  │  ├─ Facebook Pixel      │
        │  ├─ Breadcrumb()        │  │  ├─ Microsoft Clarity   │
        │  ├─ FAQ()               │  │  ├─ Google Search       │
        │  │                      │  │  │  Console             │
        │  ├─ getCurrentPageSeo() │  │  └─ Hotjar              │
        │  └─ routeToPageName()   │  │                          │
        │                         │  │  Methods:                │
        │                         │  │  ├─ getGoogleAnalytics  │
        │                         │  │  │  Data()              │
        │                         │  │  ├─ submitUrlToSearch   │
        │                         │  │  │  Console()           │
        │                         │  │  ├─ create JWT()        │
        │                         │  │  ├─ getClarityScript    │
        │                         │  │  │  Tag()               │
        │                         │  │  ├─ getAnalyticsScript  │
        │                         │  │  │  Tag()               │
        │                         │  │  ├─ getGTMScriptTag()   │
        │                         │  │  └─ getFacebookPixel    │
        │                         │  │     ScriptTag()         │
        │                         │  │                          │
        └────────┬────────────────┘  └──────────┬───────────────┘
                 │                              │
                 └──────────────┬───────────────┘
                                │
                    ┌───────────▼─────────────┐
                    │  SeoData Model          │
                    │  (Eloquent ORM)         │
                    │                         │
                    │  Attributes:            │
                    │  - page_name (unique)   │
                    │  - route_name           │
                    │  - page_type (enum)     │
                    │  - meta_title           │
                    │  - meta_description     │
                    │  - meta_keywords        │
                    │  - og_*, twitter_*      │
                    │  - schema_markup (JSON) │
                    │  - index, follow        │
                    │                         │
                    │  Scopes:                │
                    │  - byPageName()         │
                    │  - byRouteName()        │
                    │  - withTrashed()        │
                    │                         │
                    │  Casts:                 │
                    │  - JSON (schema)        │
                    │  - Boolean (index/fol)  │
                    │  - Soft Deletes         │
                    └───────────┬─────────────┘
                                │
                    ┌───────────▼─────────────┐
                    │  Database               │
                    │  seo_data table         │
                    │  (22 columns)           │
                    │                         │
                    │  Primary Storage:       │
                    │  ├─ Meta information   │
                    │  ├─ Social tags        │
                    │  ├─ Schema markup      │
                    │  ├─ Media files        │
                    │  └─ Soft delete flag   │
                    └───────────┬─────────────┘
                                │
                    ┌───────────▼─────────────┐
                    │  External Services     │
                    │                         │
                    │  ├─ Google APIs        │
                    │  │  ├─ Analytics       │
                    │  │  └─ Search Console  │
                    │  ├─ Facebook Pixel     │
                    │  ├─ Microsoft Clarity  │
                    │  ├─ Hotjar             │
                    │  └─ Google Tag Manager │
                    └────────────────────────┘
```

---

## Request Flow: Creating SEO Entry

```
1. ADMIN USER ACCESSES /admin/seo
   │
   ├─ FilamentServiceProvider loads
   ├─ SeoDataResource registered
   └─ Authentication check (auth:sanctum + role:admin|editor)

2. FILAMENT LIST PAGE LOADS
   │
   ├─ SeoDataResource::getPages() configures list
   ├─ SeoDataResource::getTableColumns() defines columns
   └─ Database query: SeoData::paginate(15)

3. USER CLICKS "+ NEW"
   │
   ├─ CreateSeoData page loads
   ├─ SeoDataResource::form() builds form
   │  ├─ Basic Information tab
   │  ├─ Meta Tags tab (with counters)
   │  ├─ Open Graph tab
   │  ├─ Twitter Card tab
   │  ├─ Schema Markup tab
   │  └─ Advanced tab
   └─ Form validation rules applied

4. USER FILLS FORM & CLICKS SAVE
   │
   ├─ Form validation runs
   ├─ Image upload processing (if any)
   └─ SeoDataResource::form()->create() called

5. FORM SUBMISSION SENT TO API
   │
   ├─ Route: POST /api/v1/admin/seo
   ├─ Middleware: auth:sanctum, role:admin|editor
   ├─ Controller: SeoManagementController::store()
   └─ Request validation

6. CONTROLLER PROCESSES REQUEST
   │
   ├─ Validate input
   │  ├─ page_name (unique)
   │  ├─ meta_title (max 60 chars)
   │  ├─ meta_description (max 160 chars)
   │  └─ Other fields
   ├─ Process image uploads
   │  └─ Move to storage/app/public/seo-images/
   ├─ Call TrackingService (if GSC submit enabled)
   │  └─ Submit URL to Search Console
   └─ Store in database

7. DATABASE OPERATIONS
   │
   ├─ SeoData::create()
   │  └─ Insert into seo_data table
   ├─ Cache clear
   └─ Response generated

8. RESPONSE SENT BACK
   │
   ├─ Status: 201 Created
   ├─ Response includes created record
   └─ Filament redirects to list

9. LIST PAGE REFRESHED
   │
   ├─ New record visible in table
   ├─ Success notification shown
   └─ Ready for next operation
```

---

## Data Model Relationships

```
┌────────────────────────────────────────┐
│         SeoData Model                  │
│         (Primary Entity)               │
├────────────────────────────────────────┤
│ id                    PK               │
│ page_name             UNIQUE STRING    │
│ route_name            NULLABLE STRING  │
│ page_type             ENUM (5 options) │
│ meta_title            VARCHAR(60)      │
│ meta_description      VARCHAR(160)     │
│ meta_keywords         TEXT             │
│ meta_image            VARCHAR(URL)     │
│ canonical_url         VARCHAR(URL)     │
│ og_title              VARCHAR(100)     │
│ og_description        TEXT             │
│ og_image              VARCHAR(URL)     │
│ twitter_card          ENUM (4 types)   │
│ twitter_title         VARCHAR(70)      │
│ twitter_description   VARCHAR(200)     │
│ twitter_image         VARCHAR(URL)     │
│ schema_type           ENUM (7 types)   │
│ schema_markup         JSON             │
│ index                 BOOLEAN (true)   │
│ follow                BOOLEAN (true)   │
│ created_at            TIMESTAMP        │
│ updated_at            TIMESTAMP        │
│ deleted_at            TIMESTAMP(NULL)  │
└────────────────────────────────────────┘
        │
        ├─ 1-to-Many with Database Logs
        ├─ Casts JSON for schema_markup
        ├─ Soft deletes enabled
        └─ Indexed on page_name, route_name
```

---

## Configuration Hierarchy

```
┌─────────────────────────────────────────┐
│  Environment Variables (.env)           │
│                                         │
│  GOOGLE_ANALYTICS_ENABLED=true          │
│  GOOGLE_ANALYTICS_MEASUREMENT_ID=...    │
│  GOOGLE_TAG_MANAGER_ID=...              │
│  MICROSOFT_CLARITY_ID=...               │
│  FACEBOOK_PIXEL_ID=...                  │
│  TWITTER_HANDLE=...                     │
│  SCHEMA_ORG_NAME=...                    │
│  And 20+ others                         │
└────────────┬────────────────────────────┘
             │
             ▼
┌─────────────────────────────────────────┐
│  Config Files                           │
│                                         │
│  config/seo.php                         │
│  ├─ Defaults (title, description)       │
│  ├─ Twitter config                      │
│  ├─ Open Graph defaults                 │
│  ├─ Schema organization info            │
│  ├─ Tracking config                     │
│  └─ Cache settings                      │
│                                         │
│  config/tracking.php                    │
│  ├─ Google Analytics                    │
│  ├─ Google Tag Manager                  │
│  ├─ Facebook Pixel                      │
│  ├─ Microsoft Clarity                   │
│  ├─ Google Search Console               │
│  └─ Hotjar                              │
└────────────┬────────────────────────────┘
             │
             ▼
┌─────────────────────────────────────────┐
│  Service Layer                          │
│                                         │
│  SeoService::getCurrentPageSeo()        │
│  └─ Uses config()->get('seo.*')         │
│                                         │
│  TrackingService::getAnalyticsTag()     │
│  └─ Uses config()->get('tracking.*')    │
│                                         │
│  Fallback: settings table if no config  │
└────────────┬────────────────────────────┘
             │
             ▼
┌─────────────────────────────────────────┐
│  View Layer (app.blade.php)             │
│                                         │
│  Renders meta tags from SeoService      │
│  Renders tracking scripts               │
│  Renders schema markup                  │
└─────────────────────────────────────────┘
```

---

## Security & Authorization Flow

```
┌──────────────────────────────────┐
│  Incoming HTTP Request           │
│  /api/v1/admin/seo               │
└─────────────┬────────────────────┘
              │
              ▼
┌──────────────────────────────────┐
│  Middleware: auth:sanctum        │
│  Verify Bearer Token             │
└─────────────┬────────────────────┘
              │
         ┌────┴────┐
         │ YES      │ NO
         ▼          ▼
      Continue    401 Unauthorized
         │
         ▼
┌──────────────────────────────────┐
│  Middleware: role:admin|editor   │
│  Check User Role                 │
└─────────────┬────────────────────┘
              │
         ┌────┴────────┐
         │ YES          │ NO
         ▼              ▼
      Continue      403 Forbidden
         │
         ▼
┌──────────────────────────────────┐
│  Controller Action               │
│  Process Request                 │
└─────────────┬────────────────────┘
              │
              ▼
┌──────────────────────────────────┐
│  Database Operation              │
│  (Protected by Eloquent)         │
└─────────────┬────────────────────┘
              │
              ▼
┌──────────────────────────────────┐
│  Response to Client              │
│  200 OK / 201 Created / etc      │
└──────────────────────────────────┘
```

---

This architecture provides a **scalable, secure, and maintainable** SEO management system that can grow with your business needs.

**Ready to launch! 🚀**
