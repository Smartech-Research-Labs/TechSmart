# Media Library & SEO Management System - Setup Guide

## Overview

A comprehensive media management and SEO optimization system for your website that:
- Centralizes all website images in a media library
- Manages image metadata (title, description, alt text, caption) for SEO
- Integrates with the Industries section for enhanced image management
- Uses AI (OpenAI) to bulk generate SEO-friendly metadata
- Scans and imports images from `resources/img` folder automatically

---

## Installation & Setup

### 1. Run Migrations

```bash
php artisan migrate
```

This creates two new tables:
- `media_library` - Stores all images and their SEO metadata
- `industry_media` - Links images to industries

### 2. Verify Configuration

Ensure your OpenAI API key is set in `.env`:
```env
OPENAI_API_KEY=your_key_here
```

### 3. Scan and Import Existing Images

**Admin Panel:** Go to `/admin/media-library` and click "Scan Resources"

This automatically imports all images from:
- `resources/img/` folder
- `resources/img/services/` folder

---

## Features & Usage

### 1. Media Library Management (`/admin/media-library`)

#### View All Images
- Grid view of all website images
- Filter by folder (Resources, Services, etc.)
- Search by filename, title, or alt text
- Sort by newest, name, or file size

#### Image SEO Metadata
Each image has:
- **Title**: SEO-optimized title (max 255 characters)
- **Alt Text**: Accessibility & SEO (max 125 characters)
- **Description**: Search engine description (max 160 characters)
- **Caption**: Context/explanation for viewers

#### Edit Individual Image Metadata
1. Click on an image in the grid
2. Click the edit button (pencil icon)
3. Fill in SEO metadata
4. Save changes

#### Bulk AI-Powered SEO Generation

To generate SEO metadata for multiple images using OpenAI:

1. **Select Images**: Click checkboxes to select multiple images
2. **Generate SEO**: Click "Generate SEO (AI)" button
3. **Choose Type**:
   - **Generic**: For all images
   - **Services**: For service/product images
   - **Industries**: For industry section images
4. **Add Context**: Optionally provide context (e.g., "These are healthcare service images")
5. **Confirm**: Click "Generate for X Images"

The AI will create:
- Professional SEO titles
- Descriptive alt text (accessibility-friendly)
- Search-optimized descriptions
- Contextual captions

**Cost**: Each generation uses OpenAI API credits (gpt-4-turbo)

---

### 2. Industries Section Integration

#### Linking Images to Industries

In the Industries admin (`/admin/industries`):

1. **Edit/Create Industry**
2. **Image Selection**:
   - **Card Image**: Used on industry listing cards
     - Can upload directly OR
     - Choose from Media Library
   - **Banner Image**: Used on industry detail pages
     - Can upload directly OR
     - Choose from Media Library
3. **Save Industry**

Images are now tracked and linked to the industry record.

#### Benefits:
- SEO metadata travels with the image
- Track image usage across the site
- Easy reuse of images
- Centralized image management

---

### 3. API Endpoints

#### List Media
```bash
GET /api/v1/admin/media-library
?page=1&per_page=24&folder=all&search=keyword&sort=created_at&direction=desc
```

#### Get Single Media
```bash
GET /api/v1/admin/media-library/{id}
```

#### Update Media Metadata
```bash
PUT /api/v1/admin/media-library/{id}
{
  "title": "New Title",
  "description": "Description",
  "alt_text": "Alt text",
  "caption": "Caption"
}
```

#### Bulk Update Media
```bash
POST /api/v1/admin/media-library/bulk-update
{
  "updates": [
    {
      "id": 1,
      "title": "Title",
      "description": "Description",
      "alt_text": "Alt",
      "caption": "Caption"
    }
  ]
}
```

#### Generate SEO Metadata (AI) - Single
```bash
POST /api/v1/admin/media-library/{id}/generate-seo
{
  "context": "Optional context about the image"
}
```

#### Generate SEO Metadata (AI) - Bulk
```bash
POST /api/v1/admin/media-library/bulk-generate-seo
{
  "media_ids": [1, 2, 3],
  "context": "Optional context",
  "type": "generic|services|industries"
}
```

#### Scan & Import Resources
```bash
POST /api/v1/admin/media-library/scan-import
```

Automatically imports images from `resources/img` folder.

#### Delete Media
```bash
DELETE /api/v1/admin/media-library/{id}
```

#### Get Folder Statistics
```bash
GET /api/v1/admin/media-library/stats
```

Returns count and total size for each folder.

---

## Database Schema

### media_library Table
```sql
- id (PK)
- name (filename)
- path (storage path)
- url (access URL)
- mime_type
- file_size
- title (SEO)
- description (SEO)
- alt_text (accessibility)
- caption (context)
- image_width
- image_height
- folder (category)
- usage_count
- used_in (JSON - tracks where image is used)
- created_at
- updated_at
```

### industry_media Table
```sql
- id (PK)
- industry_id (FK to industries)
- media_id (FK to media_library)
- type ('image', 'banner', etc.)
- created_at
- updated_at
```

---

## Models & Services

### MediaLibrary Model
Located at: `app/Models/MediaLibrary.php`

**Relationships**:
- `industries()` - BelongsToMany relationship to Industries
- Tracks where each image is used

**Scopes**:
- `inFolder($folder)` - Filter by folder
- `withMetadata()` - Get only images with SEO data

**Attributes**:
- `formatted_size` - Human-readable file size
- `full_url` - Complete URL for the image

### Industry Model Updates
Located at: `app/Models/Industry.php`

**New Relationships**:
- `media()` - BelongsToMany relationship to MediaLibrary
- `cardImage()` - Get main card image
- `bannerImageMedia()` - Get banner image

### AISeoBulkUpdateService
Located at: `app/Services/AISeoBulkUpdateService.php`

**Methods**:
- `generateBulkMetadata($images, $context)` - Generate for multiple images
- `generateMetadata($image, $context)` - Generate for single image
- `generateForIndustry($images, $title, $description)` - Industry-specific
- `generateForServices($images)` - Service-specific

---

## Controllers

### MediaLibraryController
Located at: `app/Http/Controllers/Api/Admin/MediaLibraryController.php`

**Main Methods**:
- `index()` - List media with pagination & filters
- `show()` - Get single media
- `update()` - Update metadata
- `bulkUpdate()` - Update multiple items
- `generateSeoMetadata()` - AI generation (single)
- `bulkGenerateSeoMetadata()` - AI generation (bulk)
- `delete()` - Delete media
- `getFolderStats()` - Folder statistics
- `scanAndImport()` - Scan resources/img folder

### IndustryController Updates
Located at: `app/Http/Controllers/Api/Admin/IndustryController.php`

**Updates**:
- Now accepts `image_id` and `banner_image_id`
- Automatically links media to industries
- Returns media relationships in API responses

---

## Vue Components

### MediaLibrary.vue
Located at: `resources/js/pages/Admin/MediaLibrary.vue`

**Features**:
- Grid view of images
- Search & filtering
- Bulk selection
- AI-powered bulk SEO generation
- Individual image editing
- Folder statistics
- SEO readiness indicators

### Industries.vue Updates
Located at: `resources/js/pages/Admin/Industries.vue`

**Updates**:
- Media picker modal for selecting images from library
- Link to `/admin/media-library`
- Image ID field storage
- Displays selected media with SEO metadata

---

## Routes

### API Routes
All routes require admin authentication (`middleware: 'auth:sanctum', 'verified'`)

```php
// Media Library CRUD
GET /api/v1/admin/media-library
POST /api/v1/admin/media-library/scan-import
GET /api/v1/admin/media-library/stats
GET /api/v1/admin/media-library/{mediaLibrary}
PUT /api/v1/admin/media-library/{mediaLibrary}
DELETE /api/v1/admin/media-library/{mediaLibrary}

// SEO Generation
POST /api/v1/admin/media-library/{mediaLibrary}/generate-seo
POST /api/v1/admin/media-library/bulk-update
POST /api/v1/admin/media-library/bulk-generate-seo
```

### Web Routes
```
GET /admin/media-library → MediaLibrary.vue
GET /admin/industries → Industries.vue (updated)
```

---

## SEO Optimization Benefits

### On-Page SEO
- Unique, descriptive alt text for all images
- Optimized image titles and descriptions
- Relevant image captions
- Proper image metadata

### Accessibility (WCAG)
- Alt text for screen readers
- Descriptive captions
- Semantic image structure

### Search Engine Benefits
- Image appears in Google Images search
- Rich snippets with image metadata
- Better schema.org markup
- Improved page rankings

### Best Practices
- Alt text describes image content (25-125 chars)
- Title is SEO keyword-rich (max 255 chars)
- Description is unique and relevant
- Caption provides context

---

## Cost Considerations

### OpenAI API Usage
- Each image generation: ~$0.01-$0.05 (depending on model)
- Bulk generation of 20 images: ~$0.20-$1.00
- Budget planning: Set API usage limits in OpenAI account

### Storage
- Images stored in `storage/` and `resources/img/`
- Media library tracks file sizes
- View folder stats at `/admin/media-library/stats`

---

## Troubleshooting

### Images Not Scanning
1. Check if `resources/img/` folder exists
2. Ensure folder permissions allow read access
3. Verify images are in supported formats (jpg, png, webp, etc.)

### AI Generation Fails
1. Check OpenAI API key in `.env`
2. Verify API has available credits
3. Check server error logs
4. Retry with fewer images

### Media Not Linking to Industries
1. Verify `image_id` is being sent to API
2. Check `industry_media` table for relationships
3. Ensure media_library record exists

### Performance Issues
- Media library uses pagination (24 items per page)
- Add indexes: `php artisan migrate`
- Clear cache: `php artisan cache:clear`

---

## Future Enhancements

Possible additions:
- Image optimization & resizing
- Automatic WebP conversion
- Image cropping tool
- Batch uploads
- Image usage analytics
- Advanced SEO scoring
- Multi-language alt text
- CDN integration

---

## Support

For issues or questions:
1. Check error logs: `storage/logs/`
2. Verify configuration: `config/services.php`
3. Test API endpoints directly
4. Review migration status: `php artisan migrate:status`

---

## Summary

You now have:
✅ Centralized media library for all website images
✅ SEO metadata management (title, description, alt text, caption)
✅ AI-powered bulk metadata generation using OpenAI
✅ Integration with Industries section
✅ Image usage tracking
✅ Accessibility improvements (alt text, captions)
✅ Automatic image scanning from resources folder
✅ Complete admin UI at `/admin/media-library`

This system improves both SEO performance and website accessibility while providing a unified interface for managing all website images.
