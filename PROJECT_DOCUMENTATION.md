# OmniviaTech - Full-Stack Tech Company Website

## 🚀 Project Overview

A production-ready, full-featured tech company website built with Laravel 12 + Vue 3, featuring:
- **CMS System** with pages, services, products, and bundles management
- **Real-time Chat** support system (Socket.IO ready)
- **User Authentication** with roles and permissions (Spatie Permission)
- **API-first architecture** with Laravel Sanctum
- **Modern UI** with TailwindCSS 4.1 (African-tech themed)
- **State Management** with Pinia
- **File Uploads** with Spatie Media Library
- **Activity Logging** with Spatie Activity Log
- **AI Integration Ready** (OpenAI PHP client installed)

---

## 📦 Technology Stack

### Backend
- **Laravel 12.52.0** - PHP framework
- **MySQL 8+** - Database
- **Laravel Sanctum 4.3.1** - API authentication
- **Spatie Permission 6.24.1** - RBAC system
- **Spatie Media Library 11.21.0** - File management
- **Spatie Activity Log 4.12.1** - Audit trails
- **Laravel Socialite 5.24.2** - OAuth authentication
- **OpenAI PHP 0.18.0** - AI integration (ready to use)

### Frontend
- **Vue 3** (Composition API) - Framework
- **TailwindCSS 4.1.1** - Styling with custom African-tech theme
- **Pinia** - State management
- **Vue Router 4** - SPA routing
- **Axios** - HTTP client
- **Socket.IO Client** - Real-time communication
- **Swiper** - Touch sliders
- **Leaflet** - Kenya heatmap visualization
- **GSAP** - Animations
- **TypeScript** - Type safety

---

## 🗄️ Database Structure (25 Tables)

### Core CMS Tables
- **pages** - Dynamic pages with SEO fields
- **page_sections** - Reusable page sections (JSON content)
- **services** - Tech services catalog (features, process steps, pricing)
- **products** - Products with pricing tiers (JSONB)
- **bundles** - Service/product bundles with discounts
- **bundle_items** - Bundle composition

### User Interaction Tables
- **reviews** - Polymorphic reviews (services/products/bundles)
- **enquiries** - Contact forms (polymorphic to services/products)
- **wishlists** - User favorites (polymorphic)
- **newsletter_subscribers** - Email subscriptions with tokens

### Chat System Tables
- **chat_sessions** - Support chat sessions (user/guest support)
- **chat_messages** - Chat history with admin assignment

### Homepage Content Tables
- **sliders** - Hero carousel slides
- **counter_items** - Stats counter section
- **clients** - Client logos showcase
- **team_members** - Team profiles with social links
- **faqs** / **faq_categories** - Knowledge base
- **map_data_points** - Kenya heatmap data (county-level)
- **settings** - Site-wide configuration (company info, socials)

### Permission System (Spatie)
- **roles**, **permissions**, **model_has_roles**, **model_has_permissions**, **role_has_permissions**

---

## 👥 User Roles & Permissions

### Default Roles
- **superadmin** - Full system access (25+ permissions)
- **admin** - Content management, user support
- **user** - Basic access (wishlist, enquiries, reviews)

### Key Permissions
- `view_dashboard`, `view_analytics`
- `manage_pages`, `manage_services`, `manage_products`, `manage_bundles`
- `manage_reviews`, `manage_enquiries`, `manage_chat`
- `manage_users`, `manage_roles`, `manage_permissions`
- `manage_settings`, `manage_media`

---

## 🔌 API Endpoints

### Public API (`/api/v1/`)
- **GET** `/home` - Homepage data (sliders, counters, featured content, settings)
- **GET** `/home/faqs` - FAQ list with categories
- **GET** `/home/team` - Team members
- **GET** `/home/map-data` - Kenya heatmap data
- **GET** `/services` - Services list with filters
- **GET** `/services/{slug}` - Service detail
- **GET** `/products` - Products with search/filters/pagination
- **GET** `/products/{slug}` - Product detail
- **GET** `/bundles` - Bundles list
- **GET** `/bundles/{slug}` - Bundle detail with items
- **POST** `/enquiries` - Submit enquiry
- **GET** `/reviews/{type}/{id}` - Get reviews
- **POST** `/reviews` - Submit review (pending approval)
- **POST** `/newsletter/subscribe` - Subscribe to newsletter
- **POST** `/newsletter/unsubscribe` - Unsubscribe via token

### Protected API (`auth:sanctum` middleware)
- **GET** `/user/dashboard` - User stats (enquiries, reviews count)
- **GET** `/user/dashboard/enquiries` - User's enquiries
- **GET** `/user/dashboard/reviews` - User's reviews
- **GET** `/user/dashboard/profile` - User profile
- **GET** `/user/wishlist` - Wishlist items
- **POST** `/user/wishlist` - Add to wishlist
- **DELETE** `/user/wishlist/{id}` - Remove from wishlist
- **GET** `/user/chat/sessions` - Chat sessions
- **POST** `/user/chat/sessions` - Create chat session
- **GET** `/user/chat/sessions/{id}/messages` - Chat messages

---

## 🎨 Design System (African-Tech Theme)

### Color Palette
```css
--color-bg: #050a14        /* Midnight blue/black */
--color-surface: #0d1421   /* Dark surface */
--color-primary: #00d4aa   /* Electric teal */
--color-accent: #f59e0b    /* Amber gold */
```

### Typography
- **Headings**: Clash Display (bold, modern)
- **Body**: DM Sans (readable, professional)
- **Code**: JetBrains Mono

### TailwindCSS Configuration
- Updated `resources/css/app.css` with custom variables
- Supports dark mode by default
- Gradient utilities for buttons and hero sections

---

## 📂 Vue Frontend Structure

### Stores (Pinia)
- **auth.ts** - User authentication, login/register/logout, JWT token management
- **cms.ts** - Homepage data, team, map data (cached)
- **wishlist.ts** - Wishlist CRUD with optimistic updates
- **chat.ts** - Real-time chat state, Socket.IO integration

### Layouts
- **PublicLayout.vue** - Navbar, footer, mobile menu (used for homepage, services, products, etc.)
- **DashboardLayout.vue** - Sidebar navigation for user dashboard
- **AdminLayout.vue** - Admin sidebar with amber theme, role-based access

### Pages Implemented
#### Public Pages
- **Home.vue** - Homepage with Swiper slider, counters, featured services/products, clients, CTA
- **About.vue** - Company information
- **Contact.vue** - Contact form
- **Faqs.vue** - FAQ listing
- **Services/Index.vue** - Services grid
- **Products/Index.vue** - Products catalog
- **Bundles/Index.vue** - Bundle packages

#### Auth Pages (Existing from Laravel Breeze/Fortify)
- **auth/Login.vue**
- **auth/Register.vue**
- **auth/ForgotPassword.vue**
- **auth/ResetPassword.vue**
- **auth/TwoFactorChallenge.vue**
- **auth/VerifyEmail.vue**

#### Dashboard Pages
- **Dashboard/Index.vue** - User dashboard overview with stats cards, quick actions

#### Error Pages
- **NotFound.vue** - 404 page with "Go Home" / "Go Back" actions

### Shared Components
- **ToastContainer.vue** - Notification system (success/error/warning/info) with auto-dismiss
- **ChatWidget.vue** - Floating chat button + modal window (Socket.IO powered)

### Composables
- **useApi.ts** - Axios instance with auth headers, interceptors, helper methods
- **useSocket.ts** - Socket.IO connection manager (connect/disconnect/emit/on/off)
- **useToast.ts** - Toast notification system (show/success/error/warning/info)

### Router
- **router.ts** - Vue Router with:
  - Navigation guards (auth check, admin check)
  - Guest-only routes (redirect if authenticated)
  - Dynamic page titles
  - Scroll behavior (smooth scroll, hash support)

---

## 🔧 Setup & Installation

### Prerequisites
- PHP 8.2+
- Composer 2.x
- Node.js 20+ & npm
- MySQL 8+

### Installation Steps

```bash
# 1. Install PHP dependencies
composer install

# 2. Install Node dependencies
npm install

# 3. Copy environment file
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Configure database in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=omniviatech
DB_USERNAME=root
DB_PASSWORD=

# 6. Run migrations
php artisan migrate

# 7. Seed roles and permissions
php artisan db:seed

# 8. Start development servers
# Terminal 1: Laravel backend
php artisan serve

# Terminal 2: Vite frontend
npm run dev

# Visit: http://localhost:8000
```

---

## 🚧 TODO: Remaining Implementation

### 1. Socket.IO Server (Real-time Chat)
**File to create**: `server/socket.js` (Node.js microservice)

```javascript
const express = require('express');
const http = require('http');
const { Server } = require('socket.io');

const app = express();
const server = http.createServer(app);
const io = new Server(server, {
  cors: {
    origin: process.env.APP_URL || 'http://localhost:8000',
    credentials: true
  }
});

io.on('connection', (socket) => {
  console.log('User connected:', socket.id);

  // Join chat session room
  socket.on('join-session', ({ sessionId }) => {
    socket.join(`session-${sessionId}`);
    console.log(`User joined session: ${sessionId}`);
  });

  // Send message to session
  socket.on('send-message', async ({ sessionId, message }) => {
    // Save to database via API call
    io.to(`session-${sessionId}`).emit('new-message', {
      sessionId,
      message,
      timestamp: new Date().toISOString()
    });
  });

  // Typing indicator
  socket.on('typing', ({ sessionId, isTyping }) => {
    socket.to(`session-${sessionId}`).emit('typing-status', { sessionId, isTyping });
  });

  socket.on('disconnect', () => {
    console.log('User disconnected:', socket.id);
  });
});

server.listen(3000, () => {
  console.log('Socket.IO server running on port 3000');
});
```

**Run with**:
```bash
cd server
npm install express socket.io
node socket.js
```

**Environment variable**: Add `VITE_SOCKET_URL=http://localhost:3000` to `.env`

---

### 2. BullMQ Worker (Background Jobs)
**Package installation**:
```bash
composer require predis/predis
npm install bullmq ioredis
```

**Create worker**: `server/worker.js`
```javascript
const { Worker } = require('bullmq');
const Redis = require('ioredis');

const connection = new Redis({
  host: process.env.REDIS_HOST || '127.0.0.1',
  port: process.env.REDIS_PORT || 6379,
});

// Email notification worker
const emailWorker = new Worker('emails', async (job) => {
  console.log('Processing email job:', job.data);
  // Send email via API or directly
  await sendEmail(job.data);
}, { connection });

// AI content generation worker
const aiWorker = new Worker('ai-tasks', async (job) => {
  console.log('Processing AI task:', job.data);
  // Call OpenAI API
  const response = await generateContent(job.data);
  return response;
}, { connection });

console.log('BullMQ workers started');
```

**Laravel queue configuration**: Update `.env`
```
QUEUE_CONNECTION=redis
REDIS_CLIENT=predis
```

---

### 3. OpenAI Integration
**Service class**: `app/Services/OpenAIService.php`
```php
<?php

namespace App\Services;

use OpenAI;

class OpenAIService
{
    protected $client;

    public function __construct()
    {
        $this->client = OpenAI::client(env('OPENAI_API_KEY'));
    }

    /**
     * Generate content suggestions for services/products
     */
    public function generateContentSuggestion(string $title, string $category): string
    {
        $response = $this->client->chat()->create([
            'model' => 'gpt-4',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a tech copywriter.'],
                ['role' => 'user', 'content' => "Write a compelling 2-sentence description for a tech service called '{$title}' in the {$category} category."],
            ],
        ]);

        return $response->choices[0]->message->content;
    }

    /**
     * Sentiment analysis for reviews
     */
    public function analyzeReviewSentiment(string $reviewText): array
    {
        $response = $this->client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'Analyze sentiment as: positive, neutral, or negative. Respond with JSON: {"sentiment": "positive", "score": 0.9}'],
                ['role' => 'user', 'content' => $reviewText],
            ],
        ]);

        return json_decode($response->choices[0]->message->content, true);
    }

    /**
     * AI chat fallback (when no admin online)
     */
    public function chatbotResponse(string $userMessage, array $context = []): string
    {
        $systemPrompt = "You are a helpful tech support assistant for OmniviaTech. Answer questions about our services, products, and pricing.";
        
        $messages = [
            ['role' => 'system', 'content' => $systemPrompt],
        ];

        foreach ($context as $msg) {
            $messages[] = ['role' => $msg['role'], 'content' => $msg['content']];
        }

        $messages[] = ['role' => 'user', 'content' => $userMessage];

        $response = $this->client->chat()->create([
            'model' => 'gpt-4',
            'messages' => $messages,
            'max_tokens' => 500,
        ]);

        return $response->choices[0]->message->content;
    }
}
```

**Environment variable**: Add `OPENAI_API_KEY=sk-...` to `.env`

**Usage in controller**:
```php
use App\Services\OpenAIService;

public function generateSuggestion(Request $request, OpenAIService $ai)
{
    $suggestion = $ai->generateContentSuggestion(
        $request->title,
        $request->category
    );
    
    return response()->json(['suggestion' => $suggestion]);
}
```

---

## 🔐 Authentication Flow

1. **Register** → Creates user with `user` role
2. **Login** → Returns JWT token, stores in localStorage
3. **Token stored** → Axios interceptor adds `Authorization: Bearer {token}` to all requests
4. **Router guard** → Checks `authStore.isAuthenticated` before accessing protected routes
5. **Logout** → Clears token, redirects to login

**Admin access**:
- Users with `admin` or `superadmin` role can access `/admin/*` routes
- Middleware: `requiresAdmin: true` in route meta

---

## 🧪 Testing

### Seed Test Data
```bash
# Create sample services, products, bundles
php artisan db:seed --class=ContentSeeder

# Create test users
php artisan db:seed --class=UserSeeder
```

### Test Accounts
```
Superadmin: admin@omniviatech.com / password
User: user@omniviatech.com / password
```

---

## 📈 Next Steps (Production)

1. **Deploy Laravel API** (Laravel Forge, AWS, DigitalOcean)
2. **Deploy Vue SPA** (Netlify, Vercel, S3+CloudFront)
3. **Set up Redis** for sessions, cache, queues
4. **Configure S3** for media uploads (Spatie Media Library)
5. **SSL certificates** (Let's Encrypt)
6. **CDN** for assets (CloudFlare)
7. **Monitoring** (Laravel Telescope, Sentry)
8. **Backups** (automated daily backups)
9. **CI/CD pipeline** (GitHub Actions, GitLab CI)

---

## 📝 Development Notes

### Code Structure
- **Controllers** follow `Resource` pattern (index, show, store, update, destroy)
- **Models** use Eloquent relationships (HasMany, BelongsTo, MorphTo, MorphMany)
- **Validation** uses Form Requests (TODO: create `app/Http/Requests/`)
- **API responses** standardized:
  ```json
  {
    "success": true,
    "message": "Operation successful",
    "data": { ... }
  }
  ```

### Performance Optimizations
- **Database**: Indexes on `slug`, `status`, `is_featured` columns
- **API**: Cache homepage data (Redis) for 1 hour
- **Frontend**: Lazy-loading routes with `import()`
- **Images**: Spatie Media Library auto-generates thumbnails

### Security
- **CSRF protection**: Enabled for web routes
- **XSS prevention**: Vue escapes templates by default
- **SQL injection**: Eloquent uses prepared statements
- **Rate limiting**: Apply to login/register endpoints (TODO)

---

## 🐛 Known Issues & TODOs

- [ ] Add detailed pages for Services, Products, Bundles (Detail.vue files)
- [ ] Implement admin CRUD pages (AdminPages.vue, AdminServices.vue, etc.)
- [ ] Add user profile edit page (Profile.vue)
- [ ] Create Form Request validators for all API controllers
- [ ] Add image upload UI for Spatie Media Library
- [ ] Implement search functionality (Algolia/Meilisearch integration)
- [ ] Add pagination to product listings
- [ ] Create email templates (notifications, newsletters)
- [ ] Set up automated tests (PHPUnit, Pest, Vitest)
- [ ] Add API documentation (Scribe, L5-Swagger)
- [ ] Implement Two-Factor Authentication flow
- [ ] Add social login (Google, Facebook via Socialite)

---

## 📚 Resources

- **Laravel Docs**: https://laravel.com/docs/12.x
- **Vue 3 Docs**: https://vuejs.org/guide/
- **Pinia Docs**: https://pinia.vuejs.org/
- **TailwindCSS**: https://tailwindcss.com/docs
- **Spatie Packages**: https://spatie.be/docs
- **Socket.IO**: https://socket.io/docs/
- **OpenAI API**: https://platform.openai.com/docs

---

## 💡 Support

For questions or issues, contact the development team.

---

**Built with ❤️ using Laravel + Vue**
