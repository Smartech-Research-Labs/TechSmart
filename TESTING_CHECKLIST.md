# 🧪 SEO & Analytics Installation - Testing Checklist

## Pre-Installation Requirements
- [ ] Laravel 10+ (Current: 12.0) ✅
- [ ] PHP 8.2+ installed
- [ ] Composer installed
- [ ] Database configured
- [ ] .env file set up
- [ ] User model with roles implemented ✅
- [ ] Storage path writable
- [ ] Sufficient disk space for packages

## Installation Checklist

### Step 1: Install Dependencies
```bash
composer require ralphjsmit/laravel-seo
composer require filament/filament
composer require google/analytics-data
```
- [ ] ralphjsmit/laravel-seo installed
- [ ] filament/filament installed
- [ ] google/analytics-data installed
- [ ] No composer conflicts
- [ ] Output: "X packages installed successfully"

### Step 2: Publish Configuration
```bash
php artisan vendor:publish --provider="RalphJSmit\Seo\SeoServiceProvider"
php artisan vendor:publish --tag=seo-config
php artisan vendor:publish --tag=filament-config
```
- [ ] config/seo.php exists
- [ ] config/tracking.php exists
- [ ] Filament config published
- [ ] No warnings about missing files

### Step 3: Install Filament
```bash
php artisan filament:install --panels
```
- [ ] Filament panel created
- [ ] Admin routes registered
- [ ] No errors during installation

### Step 4: Run Migrations
```bash
php artisan migrate
```
- [ ] Migration file exists: `database/migrations/2026_05_21_000001_create_seo_data_table.php`
- [ ] seo_data table created in database
- [ ] All 22 columns created
- [ ] No migration errors

Verify table structure:
```bash
php artisan tinker
# DB::table('seo_data')->first()
```
- [ ] page_name column exists (unique)
- [ ] page_type column exists (enum)
- [ ] meta_title column exists
- [ ] meta_description column exists
- [ ] All other columns present

### Step 5: Seed Data
```bash
php artisan db:seed --class=SeoDataSeeder
```
- [ ] SeoDataSeeder file exists
- [ ] 18 SEO records inserted
- [ ] Verify count: `php artisan tinker` → `SeoData::count()`
- [ ] Homepage record exists
- [ ] All service pages created

### Step 6: Create Storage Symlink
```bash
php artisan storage:link
```
- [ ] Symlink created successfully
- [ ] storage/app/public accessible via public/storage

### Step 7: Clear Cache
```bash
php artisan cache:clear
php artisan config:cache
```
- [ ] Cache cleared
- [ ] Config cached
- [ ] No errors

---

## Configuration Testing

### Environment Variables
- [ ] .env file updated with required variables
- [ ] GOOGLE_ANALYTICS_ENABLED set
- [ ] GOOGLE_ANALYTICS_MEASUREMENT_ID set
- [ ] GOOGLE_ANALYTICS_PROPERTY_ID set
- [ ] GOOGLE_TAG_MANAGER_ID set
- [ ] MICROSOFT_CLARITY_ID set
- [ ] FACEBOOK_PIXEL_ID set
- [ ] TWITTER_HANDLE set
- [ ] All required variables present

### Google Credentials
- [ ] storage/app/google-analytics-credentials.json exists
- [ ] File is valid JSON
- [ ] Contains service account info
- [ ] storage/app/google-search-console-credentials.json exists
- [ ] File is valid JSON
- [ ] Both files have read permissions

### Models and Services
- [ ] app/Models/SeoData.php exists and loads
- [ ] app/Services/SeoService.php exists
- [ ] app/Services/TrackingService.php exists
- [ ] Models import correctly in tinker

---

## Filament Admin Panel Testing

### Access Admin Panel
```
http://localhost:8000/admin
```
- [ ] Admin panel loads
- [ ] Login page displays
- [ ] Can log in with admin credentials
- [ ] Dashboard loads

### Navigate to SEO Management
- [ ] Sidebar shows "SEO Management" link
- [ ] Link is visible and clickable
- [ ] Navigates to SEO data list page
- [ ] List page loads without errors

### List Page
- [ ] Shows table with columns: page_name, type, title, indexed
- [ ] 18 SEO records displayed
- [ ] Pagination shows "Showing 1 to 15 of 18"
- [ ] Search box present and functional
- [ ] Filter options available
- [ ] "+ New" button visible and clickable

### Create New SEO
- [ ] Click "+ New" button
- [ ] Create form loads with all tabs
- [ ] Tabs visible:
  - [ ] Basic Information
  - [ ] Meta Tags
  - [ ] Open Graph
  - [ ] Twitter Card
  - [ ] Schema Markup
  - [ ] Advanced
- [ ] All form fields present
- [ ] Character counters visible on title/description
- [ ] File upload preview works
- [ ] Can fill form without errors
- [ ] "Save" button creates record

### Edit Page
- [ ] Click edit on existing record
- [ ] Edit form loads with data
- [ ] All fields pre-populated correctly
- [ ] Can modify values
- [ ] Can upload new images
- [ ] "Update" button saves changes
- [ ] Confirmation message shows

### Delete Operations
- [ ] Delete button visible in edit form
- [ ] Confirmation dialog appears
- [ ] Deletion works
- [ ] Record removed from list
- [ ] Success message shows

### Advanced Features
- [ ] Bulk delete works
- [ ] Table sorting works (click headers)
- [ ] Search filters results
- [ ] Page type filter works
- [ ] Index/Follow toggle filter works
- [ ] Export functionality available (if added)

---

## API Testing

### Authentication
```bash
# Get token (from login or user credentials)
POST http://localhost:8000/api/v1/login
{
  "email": "admin@example.com",
  "password": "password"
}
```
- [ ] Authentication endpoint returns token
- [ ] Token can be used for subsequent requests

### SEO CRUD Endpoints
```bash
# List
GET /api/v1/admin/seo
Authorization: Bearer TOKEN
```
- [ ] Returns 200 OK
- [ ] Response is JSON array
- [ ] Pagination metadata included
- [ ] 18 records returned

```bash
# Get Single
GET /api/v1/admin/seo/1
Authorization: Bearer TOKEN
```
- [ ] Returns 200 OK
- [ ] Returns single record
- [ ] All fields present

```bash
# Create
POST /api/v1/admin/seo
Authorization: Bearer TOKEN
Content-Type: application/json
{
  "page_name": "test-page",
  "page_type": "page",
  "meta_title": "Test Page"
}
```
- [ ] Returns 201 Created
- [ ] Record inserted in database
- [ ] Response includes created_at/updated_at

```bash
# Update
PUT /api/v1/admin/seo/1
Authorization: Bearer TOKEN
{
  "meta_title": "Updated Title"
}
```
- [ ] Returns 200 OK
- [ ] Changes reflected in database

```bash
# Delete
DELETE /api/v1/admin/seo/1
Authorization: Bearer TOKEN
```
- [ ] Returns 204 No Content
- [ ] Record soft-deleted (check with:
  ```php
  php artisan tinker
  # SeoData::withTrashed()->find(1)->deleted_at
  ```

### Advanced Endpoints
```bash
# Preview
POST /api/v1/admin/seo/preview
Authorization: Bearer TOKEN
{
  "page_name": "homepage"
}
```
- [ ] Returns 200 OK
- [ ] Preview data includes Google, Facebook, Twitter views

```bash
# Audit Report
GET /api/v1/admin/seo/audit/report
Authorization: Bearer TOKEN
```
- [ ] Returns 200 OK
- [ ] Shows score, issues, recommendations

```bash
# Analytics Data
GET /api/v1/admin/seo/analytics/data?start_date=30daysAgo&end_date=today
Authorization: Bearer TOKEN
```
- [ ] Returns 200 OK
- [ ] Returns analytics metrics (or empty if not connected)

```bash
# Tracking Config
GET /api/v1/admin/seo/tracking/config
Authorization: Bearer TOKEN
```
- [ ] Returns 200 OK
- [ ] Shows enabled/disabled services

### Authorization Testing
```bash
# Without token
GET /api/v1/admin/seo
```
- [ ] Returns 401 Unauthorized

```bash
# With non-admin user
GET /api/v1/admin/seo
Authorization: Bearer EDITOR_TOKEN
```
- [ ] Returns 403 Forbidden (if editor role not allowed) OR 200 OK (if allowed)
- [ ] Verify in code which roles have access

---

## Front-End Integration Testing

### Meta Tags in Page Source
```bash
curl http://localhost:8000
```
- [ ] Meta title present in <head>
- [ ] Meta description present
- [ ] Meta keywords present
- [ ] Open Graph tags present
- [ ] Twitter card tags present
- [ ] Canonical URL present
- [ ] Robots meta present

### Tracking Scripts
```bash
curl http://localhost:8000 | grep -i "gtag\|analytics\|clarity\|facebook"
```
- [ ] Google Analytics script present (if enabled)
- [ ] Google Tag Manager script present (if enabled)
- [ ] Microsoft Clarity script present (if enabled)
- [ ] Facebook Pixel script present (if enabled)

### Schema Markup
```bash
curl http://localhost:8000 | grep -i "application/ld+json"
```
- [ ] Schema script tags present
- [ ] Valid JSON-LD format
- [ ] Organization schema present
- [ ] Breadcrumb schema present

---

## Database Verification

```bash
php artisan tinker
```

### Table Structure
```php
# Check table exists
Schema::hasTable('seo_data')  # true

# Get all columns
Schema::getColumns('seo_data')  # lists all 22 columns

# Verify columns
DB::table('seo_data')->first()  # shows sample record
```
- [ ] Table created correctly
- [ ] All columns present
- [ ] Correct data types
- [ ] Indexes present
- [ ] Soft delete flag present

### Data Integrity
```php
# Count records
SeoData::count()  # should be 18

# Check unique constraint
SeoData::where('page_name', 'homepage')->count()  # should be 1

# Test soft deletes
$record = SeoData::first();
$record->delete();
SeoData::count()  # should be 17
SeoData::withTrashed()->count()  # should be 18
```
- [ ] 18 records inserted
- [ ] page_name unique constraint works
- [ ] Soft deletes work correctly

---

## Permission Testing

### Admin Role
- [ ] Can access /admin
- [ ] Can view SEO data
- [ ] Can create new SEO entry
- [ ] Can edit SEO entry
- [ ] Can delete SEO entry
- [ ] Can access all API endpoints

### Editor Role (if implemented)
- [ ] Can access /admin (verify in Filament config)
- [ ] Can view SEO data (verify in Resource)
- [ ] Can create new SEO entry (verify in Resource)
- [ ] Can edit SEO entry (verify in Resource)
- [ ] Can delete SEO entry (verify in Resource)

### Non-Admin User
- [ ] Cannot access /admin/seo-data
- [ ] API returns 403 for admin endpoints
- [ ] Can read public SEO data (if route exists)

---

## Performance Testing

### Page Load Times
- [ ] Admin list page loads in < 2 seconds
- [ ] Edit page loads in < 2 seconds
- [ ] API endpoints respond in < 1 second

### Database Queries
```bash
DB::enableQueryLog();
# ... run operation ...
dd(DB::getQueryLog());  # should be minimal queries
```
- [ ] Pagination uses efficient queries
- [ ] No N+1 query problems
- [ ] Indexes used correctly

### Cache
- [ ] SEO data cached properly
- [ ] Cache clears on update
- [ ] Analytics data cached

---

## Error Handling

### Missing Data
- [ ] Invalid page_name returns 404
- [ ] Invalid ID returns 404
- [ ] Missing required fields return 422

### Validation
- [ ] meta_title > 60 chars rejected
- [ ] meta_description > 160 chars rejected
- [ ] page_name unique validation works
- [ ] Invalid page_type rejected

### Database Errors
- [ ] Database offline shows error message
- [ ] Migration conflicts handled
- [ ] Duplicate key violations handled

---

## Documentation Verification

- [ ] SEO_SETUP.md exists and is readable
- [ ] ENV_VARIABLES_SEO.md exists and is readable
- [ ] SEO_MANAGEMENT.md exists and is readable
- [ ] COMPLETE_SEO_IMPLEMENTATION.md exists
- [ ] This checklist (TESTING_CHECKLIST.md) exists

---

## Final Verification

- [ ] No console errors
- [ ] No PHP errors in logs
- [ ] No JavaScript errors
- [ ] All tests passing (if tests written)
- [ ] No security vulnerabilities
- [ ] Documentation complete
- [ ] Ready for production

---

## Sign-Off

**Installation Date**: ________________  
**Tested By**: ________________  
**Status**: ☐ PASS / ☐ FAIL  
**Notes**: ________________________________________________  

---

**If all items are checked, your SEO management system is ready for use! 🎉**
