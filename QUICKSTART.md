# Quick Start Guide

This guide will help you get OmniviaTech running locally in under 10 minutes.

## Prerequisites Checklist

- [ ] PHP 8.2+ installed (`php -v`)
- [ ] Composer 2.x installed (`composer -V`)
- [ ] Node.js 18+ installed (`node -v`)
- [ ] MySQL 8+ installed and running
- [ ] Redis installed and running (`redis-cli ping`)

## 1. Database Setup (2 minutes)

```bash
# Create database
mysql -u root -p
CREATE DATABASE omniviatech CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

## 2. Laravel Setup (3 minutes)

```bash
# Clone/navigate to project
cd E:\OmniviaTech

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure .env - Edit these lines:
# DB_DATABASE=omniviatech
# DB_USERNAME=root
# DB_PASSWORD=your_password
# OPENAI_API_KEY=sk-proj-your-key-here
# REDIS_HOST=127.0.0.1

# Run migrations and seed database
php artisan migrate --seed

# This creates:
# - 25 database tables
# - 3 roles: superadmin, admin, user
# - Test user: admin@omniviatech.com / password
```

## 3. Frontend Setup (2 minutes)

```bash
# Install Node.js dependencies
npm install

# This installs:
# - Vue 3, Pinia, Vue Router
# - TailwindCSS 4.1.1
# - Axios, Swiper, other frontend tools
```

## 4. Node.js Server Setup (2 minutes)

```bash
# Navigate to server directory
cd server

# Copy environment file
cp .env.example .env

# Install dependencies (if not done already)
npm install

# Generate API token for Socket.IO
php artisan tinker
# In tinker:
$user = User::first();
$token = $user->createToken('socket-server')->plainTextToken;
echo $token;
exit

# Copy the token and paste it in server/.env:
# API_TOKEN=your_generated_token_here

cd ..
```

## 5. Redis Setup (OS-Specific)

### Windows Option A: Docker (Recommended)
```bash
docker run -d -p 6379:6379 --name redis redis:alpine
```

### Windows Option B: Memurai
1. Download from https://www.memurai.com/
2. Install and start the service
3. Test: `redis-cli ping` → should return `PONG`

### Windows Option C: WSL2
```bash
wsl --install
wsl
sudo apt update && sudo apt install redis-server
sudo service redis-server start
redis-cli ping
```

### Linux/Mac
```bash
# Install Redis
sudo apt install redis-server  # Ubuntu/Debian
brew install redis             # macOS

# Start Redis
sudo systemctl start redis     # Linux
brew services start redis      # macOS

# Test
redis-cli ping  # Should return PONG
```

## 6. Start All Services

### ⚡ Quick Start (Single Command)

```bash
npm run serve:dev
```

Or use batch/PowerShell scripts:
```bash
.\dev.bat              # Windows batch
.\start-dev.ps1        # PowerShell (interactive)
```

This starts all 5 services in one terminal:
- ✅ Laravel API (http://localhost:8000)
- ✅ Vite Dev Server (HMR)
- ✅ Socket.IO Server (port 3000)
- ✅ BullMQ Worker (background jobs)
- ✅ Laravel Queue Worker (job dispatching)

---

### Manual Start (5 Terminals)

If you prefer separate terminals:

### Terminal 1: Laravel API
```bash
php artisan serve
```
✅ Visit: http://localhost:8000

### Terminal 2: Vite Dev Server
```bash
npm run dev
```
✅ Frontend with Hot Module Replacement

### Terminal 3: Socket.IO Server
```bash
cd server
npm run dev
```
✅ Real-time chat on port 3000

### Terminal 4: BullMQ Worker
```bash
cd server
npm run dev:worker
```
✅ Processes background jobs

### Terminal 5: Laravel Queue (Optional)
```bash
php artisan queue:work redis --tries=3
```
✅ Dispatches jobs to BullMQ

## 7. Test the Application

### Test Authentication
1. Visit http://localhost:8000
2. Click "Login" (top right)
3. Login with: `admin@omniviatech.com` / `password`
4. You should see the dashboard

### Test Chat (Real-time Socket.IO)
1. While logged in, click the chat icon (bottom right)
2. Type a message
3. Check Terminal 3 for Socket.IO logs
4. Message should save to database and broadcast

### Test AI Features (Admin Only)
```bash
# Generate content
curl -X POST http://localhost:8000/api/v1/admin/ai/generate-content \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Cloud Migration Services",
    "category": "Cloud Solutions",
    "content_type": "description"
  }'
```

### Test Background Jobs
```bash
# In tinker:
php artisan tinker

# Dispatch an email job
use App\Jobs\SendEmailJob;
dispatch(new SendEmailJob([
    'to' => 'test@example.com',
    'subject' => 'Test Email',
    'template' => 'test',
    'data' => ['name' => 'John Doe']
]));

# Check Terminal 4 (BullMQ Worker) for job processing
```

## 8. Default Credentials

| Email | Password | Role |
|-------|----------|------|
| admin@omniviatech.com | password | Admin |
| user@omniviatech.com | password | User |

**⚠️ IMPORTANT:** Change these in production!

## Troubleshooting

### Issue: "Class 'Redis' not found"
```bash
# Install PHP Redis extension
composer require predis/predis
```

### Issue: "ECONNREFUSED 127.0.0.1:6379"
```bash
# Redis not running - start it:
# Windows (Memurai): Start service in Services
# Docker: docker start redis
# Linux: sudo systemctl start redis
```

### Issue: "OpenAI API key not configured"
```bash
# Add to .env:
OPENAI_API_KEY=sk-proj-your-key-here

# Or skip AI features for now and comment out AI routes
```

### Issue: "Vite manifest not found"
```bash
# Make sure Terminal 2 is running:
npm run dev

# Or build for production:
npm run build
```

### Issue: Socket.IO not connecting
```bash
# 1. Check if Socket.IO server is running (Terminal 3)
# 2. Verify .env has:
VITE_SOCKET_URL=http://localhost:3000

# 3. Check server/.env has:
CORS_ORIGINS=http://localhost:8000,http://localhost:5173

# 4. Restart Vite (Terminal 2):
# Ctrl+C, then npm run dev
```

### Issue: BullMQ jobs not processing
```bash
# 1. Check Redis is running:
redis-cli ping

# 2. Verify Terminal 4 (BullMQ Worker) is running
# 3. Check logs in Terminal 4 for errors
# 4. Verify server/.env has correct REDIS_HOST
```

## Next Steps

### For Developers
1. Create admin CRUD pages (Pages, Services, Products)
2. Implement file upload (Spatie Media Library is installed)
3. Add email templates (resources/views/emails/)
4. Customize theme colors (resources/css/app.css)
5. Add more AI features (improve use cases in OpenAIService.php)

### For Admins
1. Login as admin
2. Go to Settings page (create it)
3. Update company info
4. Add services, products, bundles
5. Configure OpenAI API key
6. Test chat system

### For Production
See [README.md](README.md) section "Production Deployment"

## Architecture Overview

```
┌─────────────────────────────────────────────────┐
│              Frontend (Vue 3 SPA)               │
│  ┌──────────┐  ┌──────────┐  ┌──────────────┐  │
│  │  Pinia   │  │  Router  │  │  Components  │  │
│  │  Stores  │  │  Guards  │  │  Layouts     │  │
│  └──────────┘  └──────────┘  └──────────────┘  │
└─────────────────────────────────────────────────┘
                      ↓ HTTP/Socket.IO
┌─────────────────────────────────────────────────┐
│          Laravel 12 Backend (API)               │
│  ┌──────────┐  ┌──────────┐  ┌──────────────┐  │
│  │  Sanctum │  │  Spatie  │  │   OpenAI     │  │
│  │   Auth   │  │  RBAC    │  │   Service    │  │
│  └──────────┘  └──────────┘  └──────────────┘  │
└─────────────────────────────────────────────────┘
         ↓ Queue Dispatch        ↓ WebSocket
┌──────────────────┐    ┌─────────────────────────┐
│  Redis (Queue)   │    │  Socket.IO Server       │
│  ┌────────────┐  │    │  ┌────────────────────┐ │
│  │  BullMQ    │←─┤    │  │  Chat Handlers     │ │
│  │  Workers   │  │    │  │  Admin Notifs      │ │
│  └────────────┘  │    │  └────────────────────┘ │
└──────────────────┘    └─────────────────────────┘
```

## Performance Tips

1. **Enable Opcache** (PHP accelerator)
2. **Use Redis for sessions** (already configured)
3. **Queue everything** (emails, reports, AI tasks)
4. **CDN for assets** (in production)
5. **Database indexes** (check slow query log)

## Security Checklist

- [ ] Change default passwords
- [ ] Enable 2FA (Fortify is installed)
- [ ] Use HTTPS in production
- [ ] Set strong APP_KEY
- [ ] Whitelist CORS origins
- [ ] Rate limit API endpoints
- [ ] Sanitize all user input
- [ ] Keep dependencies updated

## Resources

- Laravel Docs: https://laravel.com/docs
- Vue 3 Docs: https://vuejs.org/
- Socket.IO Docs: https://socket.io/docs/
- BullMQ Docs: https://docs.bullmq.io/
- OpenAI API: https://platform.openai.com/docs

---

**Need help?** Open an issue or contact support@omniviatech.com

---

## 🆕 9. SEO & Analytics Setup (Optional - 5 minutes)

OmniviaTech now includes an **enterprise-grade SEO management system** with Filament admin panel and multi-service tracking.

### Quick Install

```bash
# Option 1: Automatic (Windows)
install-seo.bat

# Option 2: Automatic (macOS/Linux)
chmod +x install-seo.sh
./install-seo.sh

# Option 3: Manual
composer require ralphjsmit/laravel-seo filament/filament google/analytics-data
php artisan filament:install --panels
php artisan migrate
php artisan db:seed --class=SeoDataSeeder
```

### Configuration

Add to `.env`:
```env
GOOGLE_ANALYTICS_ENABLED=true
GOOGLE_ANALYTICS_MEASUREMENT_ID=G-XXXXXXXXXX
GOOGLE_TAG_MANAGER_ENABLED=true
GOOGLE_TAG_MANAGER_ID=GTM-XXXXXXX
FACEBOOK_PIXEL_ENABLED=true
FACEBOOK_PIXEL_ID=123456789012345
```

Add Google credentials files to `storage/app/`:
- `google-analytics-credentials.json`
- `google-search-console-credentials.json`

### Access Admin Panel

```
http://localhost:8000/admin
→ SEO Management (in sidebar)
```

### Features

✅ Per-page SEO management  
✅ Meta tags & Open Graph  
✅ Twitter cards  
✅ Schema markup (JSON-LD)  
✅ Google Analytics integration  
✅ Google Tag Manager  
✅ Facebook Pixel  
✅ Microsoft Clarity  
✅ Google Search Console  
✅ SEO audit reports  

### Documentation

- **Quick Start**: See `QUICKSTART_SEO.md`
- **Setup Guide**: See `SEO_SETUP.md`
- **Environment Variables**: See `ENV_VARIABLES_SEO.md`
- **Feature Guide**: See `SEO_MANAGEMENT.md`
- **Full Documentation**: See `COMPLETE_SEO_IMPLEMENTATION.md`
- **Architecture**: See `ARCHITECTURE_DIAGRAM.md`
- **Testing Checklist**: See `TESTING_CHECKLIST.md`
