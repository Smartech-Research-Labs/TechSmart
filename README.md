# Smartech Research Labs - Full Stack Tech Company Website

A comprehensive tech company website built with Laravel 12, Vue 3, Socket.IO, and BullMQ. Features include CMS management, real-time chat, AI-powered content generation, wishlist functionality, and advanced admin dashboard.

## 🚀 Tech Stack

### Backend
- **Laravel 12.52.0** - PHP framework with Sanctum authentication
- **MySQL 8+** - Primary database
- **Redis** - Queue backend and caching
- **Spatie Packages** - Permission, Media Library, Activity Log
- **OpenAI PHP** - AI content generation

### Frontend
- **Vue 3** - Progressive JavaScript framework (Composition API + TypeScript)
- **Pinia** - State management
- **Vue Router 4** - SPA routing
- **TailwindCSS 4.1.1** - Utility-first CSS framework
- **Axios** - HTTP client
- **Swiper.js** - Touch slider

### Node.js Microservices
- **Socket.IO** - Real-time chat server (port 3000)
- **BullMQ** - Background job processing
- **Express.js** - Health check endpoints
- **ioredis** - Redis client

## 📦 Features

### Public Features
- ✅ Dynamic homepage with services/products showcase
- ✅ Service catalog with categories and detailed pages
- ✅ Product catalog with filtering
- ✅ Bundle packages
- ✅ Reviews and ratings system
- ✅ FAQ section with search
- ✅ Contact enquiries
- ✅ Newsletter subscription
- ✅ Real-time chat support (with Socket.IO)

### User Dashboard
- ✅ Personal dashboard
- ✅ Wishlist management
- ✅ Enquiry history
- ✅ Review management
- ✅ Profile settings
- ✅ Live chat sessions

### Admin Dashboard
- ✅ Role-based access control (superadmin, admin, user)
- ✅ CMS management (pages, services, products, bundles)
- ✅ Spatie Media Library integration (images/files)
- ✅ AI-powered features:
  - Content generation suggestions
  - SEO meta tag generation
  - Review sentiment analysis
  - Process step generation
  - Text improvement
- ✅ Chat session management
- ✅ Enquiry management
- ✅ Review moderation
- ✅ Activity logging

### Background Jobs (BullMQ)
- **Email Queue** - Transactional emails (5 concurrent, 10/sec)
- **AI Tasks Queue** - AI operations (3 concurrent, 5/min)
- **Notifications Queue** - User notifications (10 concurrent)
- **Reports Queue** - Analytics reports (2 concurrent, 10/min)

## 🛠️ Installation

### Prerequisites
- PHP 8.2+
- Composer 2.x
- Node.js 18+ and npm
- MySQL 8+
- Redis 6+

### Step 1: Clone & Install Laravel

```bash
# Navigate to project
cd E:\Smartech Research Labs

# Install PHP dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate app key
php artisan key:generate

# Configure database in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=Smartech Research Labs
DB_USERNAME=root
DB_PASSWORD=your_password

# Configure Redis
REDIS_CLIENT=predis
REDIS_HOST=127.0.0.1
REDIS_PORT=6379
QUEUE_CONNECTION=redis

# Add OpenAI API key
OPENAI_API_KEY=sk-proj-your-api-key-here

# Add Socket.IO URL
VITE_SOCKET_URL=http://localhost:3000

# Run migrations with seeders
php artisan migrate --seed

# Install frontend dependencies
npm install

# Build frontend assets (or run dev server)
npm run dev
```

### Step 2: Install Redis (Windows)

**Option A: Using Docker**
```bash
docker run -d -p 6379:6379 --name redis redis:alpine
```

**Option B: Using Memurai (Native Windows)**
1. Download from https://www.memurai.com/
2. Install and start service
3. Test: `redis-cli ping` → should return `PONG`

**Option B: Using WSL2**
```bash
wsl --install
wsl
sudo apt update && sudo apt install redis-server
sudo service redis-server start
redis-cli ping
```

### Step 3: Setup Node.js Microservices

```bash
cd server

# Install dependencies (already done)
npm install

# Copy environment file
cp .env.example .env

# Configure .env
PORT=3000
APP_URL=http://localhost:8000
REDIS_HOST=127.0.0.1
REDIS_PORT=6379
REDIS_PASSWORD=
API_BASE_URL=http://localhost:8000/api/v1
API_TOKEN=your_sanctum_api_token_here
OPENAI_API_KEY=sk-proj-your-api-key-here

# Generate API token from Laravel
# php artisan tinker
# User::find(1)->createToken('socket-server')->plainTextToken

# Return to project root
cd ..
```

### Step 4: Run All Services

**Option 1: Single Command (Recommended)**

Run all 5 services simultaneously with one command:

```bash
# Using npm
npm run serve:dev

# Or using the batch script (Windows)
.\dev.bat

# Or using PowerShell script
.\start-dev.ps1
```

This will start:
- Laravel API (port 8000)
- Vite Dev Server (HMR)
- Socket.IO Server (port 3000)
- BullMQ Worker
- Laravel Queue Worker

All services run in a single terminal with colored output for easy monitoring.

---

**Option 2: Manual (5 Separate Terminals)**

**Terminal 1: Laravel API**
```bash
php artisan serve
# Runs on http://localhost:8000
```

**Terminal 2: Vite Dev Server**
```bash
npm run dev
# Compiles Vue frontend with HMR
```

**Terminal 3: Socket.IO Server**
```bash
cd server
npm run dev
# Real-time chat on port 3000
```

**Terminal 4: BullMQ Worker**
```bash
cd server
npm run dev:worker
# Processes background jobs
```

**Terminal 5: Laravel Queue Worker** (optional, for dispatching to BullMQ)
```bash
php artisan queue:work redis --tries=3
# Processes Laravel queued jobs
```

## 🗄️ Database Structure

### Core Tables
- `users` - User accounts with 2FA support
- `roles` & `permissions` - Spatie RBAC
- `pages` - CMS pages (about, privacy, terms)
- `services` - Service catalog
- `products` - Product catalog
- `bundles` - Package bundles
- `reviews` - Reviews with sentiment analysis
- `enquiries` - Contact form submissions
- `faqs` - FAQ management
- `chat_sessions` & `chat_messages` - Real-time chat
- `wishlists` - User wishlist items
- `settings` - Site configuration
- `newsletters` - Email subscriptions
- `activity_log` - Spatie activity tracking
- `media` - Spatie media library

## 🔐 Authentication & Authorization

### Roles
- **superadmin** - Full system access
- **admin** - Content management, chat support
- **user** - Public user features

### Sanctum API Auth
```javascript
// Login
POST /api/v1/auth/login
{
  "email": "user@example.com",
  "password": "password"
}

// Use token in headers
Authorization: Bearer {token}
```

## 🤖 AI Features (OpenAI)

### Available Endpoints (Admin Only)

```javascript
// Generate content
POST /api/v1/admin/ai/generate-content
{
  "title": "Cloud Migration Services",
  "category": "Cloud Solutions",
  "content_type": "description" // or "features", "benefits"
}

// Generate SEO meta tags
POST /api/v1/admin/ai/generate-seo
{
  "title": "Cloud Migration",
  "content": "Full page content..."
}

// Analyze review sentiment
POST /api/v1/admin/ai/analyze-sentiment
{
  "text": "Great service! Very satisfied.",
  "review_id": 123 // optional
}

// AI chatbot response
POST /api/v1/admin/ai/chatbot
{
  "message": "What services do you offer?",
  "context": [], // previous messages
  "session_id": 456
}

// Generate process steps
POST /api/v1/admin/ai/generate-steps
{
  "title": "Web Development",
  "category": "Development"
}

// Improve text
POST /api/v1/admin/ai/improve-text
{
  "text": "we make good websties for u"
}
```

## 💬 Real-time Chat (Socket.IO)

### Client Events (Emit)
```javascript
// Join chat session
socket.emit('join-session', { sessionId: 123 });

// Send message
socket.emit('send-message', { 
  sessionId: 123, 
  message: 'Hello!' 
});

// Typing indicator
socket.emit('typing', { sessionId: 123, isTyping: true });

// Leave session
socket.emit('leave-session', { sessionId: 123 });

// Admin: Register for notifications
socket.emit('register-admin');

// Admin: Send message
socket.emit('admin-send-message', { 
  sessionId: 123, 
  message: 'How can I help?' 
});
```

### Server Events (Listen)
```javascript
// New message received
socket.on('new-message', (data) => {
  console.log(data.message);
});

// User typing
socket.on('user-typing', (data) => {
  console.log(`${data.userName} is typing...`);
});

// Admin assigned
socket.on('session-assigned', (data) => {
  console.log(`Assigned to ${data.adminName}`);
});

// Errors
socket.on('message-error', (error) => {
  console.error(error.message);
});
```

### Health Check
```bash
curl http://localhost:3000/health
```

## 📊 Background Jobs (BullMQ)

### Job Queues

**1. Email Queue**
```javascript
// Add email job from Laravel
dispatch(new SendEmailJob([
  'to' => 'user@example.com',
  'subject' => 'Welcome!',
  'template' => 'welcome',
  'data' => ['name' => 'John']
]));
```

**2. AI Tasks Queue**
```javascript
// Process AI task
dispatch(new ProcessAITaskJob([
  'task' => 'generate-content',
  'data' => ['title' => 'Service Title', 'category' => 'Web Dev']
]));
```

**3. Notifications Queue**
```javascript
// Send notification
dispatch(new SendNotificationJob([
  'userId' => 123,
  'type' => 'enquiry_response',
  'message' => 'Your enquiry received a response'
]));
```

**4. Reports Queue**
```javascript
// Generate report
dispatch(new GenerateReportJob([
  'reportType' => 'monthly_analytics',
  'filters' => ['month' => '2025-02']
]));
```

## 🎨 Frontend Structure

```
resources/js/
├── app.ts                 # Vue app entry
├── router.ts              # Vue Router config
├── axios.ts               # Axios setup
├── components/
│   ├── ToastContainer.vue # Notifications
│   └── ChatWidget.vue     # Floating chat
├── stores/
│   ├── auth.ts            # Auth state
│   ├── cms.ts             # Homepage cache
│   ├── wishlist.ts        # Wishlist CRUD
│   └── chat.ts            # Socket.IO integration
├── layouts/
│   ├── PublicLayout.vue   # Public pages
│   ├── DashboardLayout.vue # User dashboard
│   └── AdminLayout.vue    # Admin panel
├── pages/
│   ├── Home.vue           # Landing page
│   ├── Services/          # Service pages
│   ├── Products/          # Product pages
│   ├── Auth/              # Login/Register
│   └── Dashboard/         # Protected pages
└── lib/
    └── utils.ts           # Helper functions
```

## 🔧 Configuration Files

### Laravel Config
- `config/services.php` - OpenAI credentials
- `config/queue.php` - Redis queue config
- `config/permission.php` - Spatie roles/permissions
- `config/media-library.php` - File uploads
- `config/fortify.php` - Auth features

### Frontend Config
- `vite.config.ts` - Vite bundler
- `tsconfig.json` - TypeScript
- `tailwind.config.js` - TailwindCSS theme
- `components.json` - shadcn/ui config

### Node.js Config
- `server/package.json` - Dependencies & scripts
- `server/.env` - Server environment variables

## 📝 API Documentation

### Public Endpoints
```
GET  /api/v1/home                          # Homepage data
GET  /api/v1/services                      # All services
GET  /api/v1/services/{slug}               # Service details
GET  /api/v1/products                      # All products
GET  /api/v1/products/{slug}               # Product details
GET  /api/v1/bundles                       # All bundles
GET  /api/v1/faqs                          # FAQs
POST /api/v1/enquiries                     # Submit enquiry
POST /api/v1/newsletter/subscribe          # Subscribe
POST /api/v1/reviews                       # Submit review (auth)
```

### User Endpoints (Auth Required)
```
GET  /api/v1/user/dashboard                # Dashboard data
GET  /api/v1/user/wishlist                 # User wishlist
POST /api/v1/user/wishlist                 # Add to wishlist
GET  /api/v1/user/chat/sessions            # Chat sessions
POST /api/v1/user/chat/messages            # Send chat message
```

### Admin Endpoints (Admin Role Required)
```
POST /api/v1/admin/ai/generate-content     # AI content
POST /api/v1/admin/ai/generate-seo         # AI SEO
POST /api/v1/admin/ai/analyze-sentiment    # Sentiment
POST /api/v1/admin/ai/chatbot              # Chatbot
POST /api/v1/admin/ai/generate-steps       # Process steps
POST /api/v1/admin/ai/improve-text         # Text improvement
```

## 🧪 Testing

```bash
# Run PHPUnit tests
php artisan test

# Run specific test file
php artisan test --filter=DashboardTest

# With coverage
php artisan test --coverage
```

## 🚀 Production Deployment

### Laravel Optimization
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

npm run build
```

### Environment Variables
```env
APP_ENV=production
APP_DEBUG=false
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis
CACHE_DRIVER=redis
```

### Process Management (PM2)
```bash
# Install PM2
npm install -g pm2

# Start Socket.IO server
pm2 start server/socket.js --name "socket-server"

# Start BullMQ worker
pm2 start server/worker.js --name "bullmq-worker"

# Save PM2 config
pm2 save

# Auto-start on boot
pm2 startup
```

### Nginx Configuration
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/Smartech Research Labs/public;

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
    }

    # Socket.IO proxy
    location /socket.io/ {
        proxy_pass http://localhost:3000;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection "upgrade";
    }
}
```

## 🤝 Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## 📄 License

This project is proprietary software. All rights reserved.

## 👥 Team

- **Backend Developer** - Laravel, BullMQ, OpenAI integration
- **Frontend Developer** - Vue 3, Pinia, TailwindCSS
- **DevOps** - Redis, Socket.IO, deployment

## 📞 Support

For issues or questions:
- Email: support@smartechresearchlabs.co.ke
- GitHub Issues: [https://github.com/smartechresearchlabs/issues](https://github.com/smartechresearchlabs/issues)

---

**Built with ❤️ using Laravel, Vue 3, and modern web technologies**
