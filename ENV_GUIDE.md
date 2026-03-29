# Environment Variables Configuration Guide

This guide explains all environment variables needed for Smartech Research Labs.

## Table of Contents
1. [Laravel Backend (.env)](#laravel-backend-env)
2. [Node.js Server (server/.env)](#nodejs-server-serverenv)
3. [How to Get API Keys](#how-to-get-api-keys)
4. [Production Settings](#production-settings)

---

## Laravel Backend (.env)

### Required Variables

```bash
# Application
APP_NAME="Smartech Research Labs"
APP_ENV=local
APP_DEBUG=true
APP_TIMEZONE=Africa/Johannesburg
APP_URL=http://localhost:8000

# Generate with: php artisan key:generate
APP_KEY=base64:your_generated_key_here
```

### Database (MySQL)
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=Smartech Research Labs
DB_USERNAME=root
DB_PASSWORD=your_mysql_password
```

### Redis
```bash
REDIS_CLIENT=predis
REDIS_HOST=127.0.0.1
REDIS_PORT=6379
REDIS_PASSWORD=null

# Session & Cache
SESSION_DRIVER=redis
SESSION_LIFETIME=120
CACHE_STORE=redis
CACHE_PREFIX=Smartech Research Labs_cache

# Queue
QUEUE_CONNECTION=redis
```

### OpenAI (AI Features)
```bash
# Get from: https://platform.openai.com/api-keys
OPENAI_API_KEY=sk-proj-your-api-key-here
OPENAI_ORGANIZATION=org-your-org-id  # Optional
```

### Frontend
```bash
VITE_APP_NAME="${APP_NAME}"
VITE_API_URL="${APP_URL}/api/v1"
VITE_SOCKET_URL=http://localhost:3000
```

### Mail (Optional - use 'log' driver for testing)
```bash
MAIL_MAILER=log
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@smartechresearchlabs.co.ke"
MAIL_FROM_NAME="${APP_NAME}"
```

### Social Media (Optional)
```bash
FACEBOOK_URL=https://facebook.com/yourpage
TWITTER_URL=https://twitter.com/yourhandle
LINKEDIN_URL=https://linkedin.com/company/yourcompany
INSTAGRAM_URL=https://instagram.com/yourhandle
YOUTUBE_URL=https://youtube.com/@yourchannel
```

### Analytics (Optional)
```bash
GOOGLE_ANALYTICS_ID=G-XXXXXXXXXX
FACEBOOK_PIXEL_ID=1234567890
```

### AWS S3 (Optional - for production file storage)
```bash
AWS_ACCESS_KEY_ID=your_access_key
AWS_SECRET_ACCESS_KEY=your_secret_key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your-bucket-name
AWS_USE_PATH_STYLE_ENDPOINT=false
```

### Security
```bash
# Comma-separated domains
SANCTUM_STATEFUL_DOMAINS=localhost,localhost:8000,127.0.0.1,127.0.0.1:8000

# In production, add your domain:
# SANCTUM_STATEFUL_DOMAINS=localhost,yourdomain.com,www.yourdomain.com
```

---

## Node.js Server (server/.env)

### Required Variables

```bash
# Server
PORT=3000
NODE_ENV=development

# Laravel API
APP_URL=http://localhost:8000
API_BASE_URL=http://localhost:8000/api/v1

# Generate token with: php artisan tinker
# User::first()->createToken('socket-server')->plainTextToken
API_TOKEN=your_sanctum_token_here

# Redis
REDIS_HOST=127.0.0.1
REDIS_PORT=6379
REDIS_PASSWORD=

# OpenAI (same as Laravel)
OPENAI_API_KEY=sk-proj-your-api-key-here

# CORS (comma-separated)
CORS_ORIGINS=http://localhost:8000,http://localhost:5173
```

### Optional Variables (Worker Configuration)

```bash
# Worker Concurrency
EMAIL_QUEUE_CONCURRENCY=5
AI_QUEUE_CONCURRENCY=3
NOTIFICATION_QUEUE_CONCURRENCY=10
REPORT_QUEUE_CONCURRENCY=2

# Rate Limits
EMAIL_RATE_LIMIT=10     # per second
AI_RATE_LIMIT=5         # per minute
REPORT_RATE_LIMIT=10    # per minute

# Logging
LOG_LEVEL=info  # debug, info, warn, error
```

---

## How to Get API Keys

### 1. Generate Laravel APP_KEY
```bash
php artisan key:generate
```
This will automatically update your `.env` file.

### 2. Generate Sanctum Token for Socket.IO

```bash
php artisan tinker
```

Then in tinker:
```php
$user = User::first();
$token = $user->createToken('socket-server')->plainTextToken;
echo $token;
exit
```

Copy the token and paste it in `server/.env` as `API_TOKEN`.

### 3. Get OpenAI API Key

1. Go to https://platform.openai.com/
2. Sign up or log in
3. Navigate to **API Keys** section
4. Click **Create new secret key**
5. Copy the key (starts with `sk-proj-` or `sk-`)
6. Paste in both `.env` and `server/.env`

**Cost:** 
- GPT-4: ~$0.03 per 1K tokens (~$0.06 per request)
- GPT-3.5-turbo: ~$0.005 per 1K tokens (~$0.01 per request)

**Free Tier:** $5 credit for new accounts (expires after 3 months)

### 4. Setup Gmail for Email (Optional)

If you want real emails instead of `MAIL_MAILER=log`:

1. Enable **2-Factor Authentication** on your Google account
2. Generate **App Password**:
   - Go to: https://myaccount.google.com/apppasswords
   - Select app: Mail
   - Select device: Other (custom name)
   - Click Generate
3. Update `.env`:

```bash
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password_here  # 16-character password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@smartechresearchlabs.co.ke"
```

### 5. Setup Mailtrap (Development Email Testing)

Better for testing (no real emails sent):

1. Go to https://mailtrap.io/
2. Sign up for free account
3. Create inbox
4. Copy SMTP credentials
5. Update `.env`:

```bash
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
```

### 6. Get Google Analytics ID (Optional)

1. Go to https://analytics.google.com/
2. Create account and property
3. Get Measurement ID (format: `G-XXXXXXXXXX`)
4. Add to `.env`: `GOOGLE_ANALYTICS_ID=G-XXXXXXXXXX`

---

## Production Settings

### Security Checklist

```bash
# .env changes for production:
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Use strong session driver
SESSION_DRIVER=redis
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=lax

# HTTPS
SANCTUM_STATEFUL_DOMAINS=yourdomain.com,www.yourdomain.com

# Queue
QUEUE_CONNECTION=redis

# Cache
CACHE_STORE=redis

# Update CORS in server/.env
CORS_ORIGINS=https://yourdomain.com,https://www.yourdomain.com
```

### Optimize Laravel

```bash
# Install production dependencies
composer install --optimize-autoloader --no-dev

# Cache everything
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
php artisan optimize

# Build frontend
npm run build
```

### Environment Variable Tips

1. **Never commit .env files** - Already in `.gitignore`
2. **Use .env.example as template** - Safe to commit
3. **Rotate API keys regularly** - Set calendar reminders
4. **Use different Redis databases** - 
   ```bash
   REDIS_CACHE_DB=0
   REDIS_QUEUE_DB=1
   REDIS_SESSION_DB=2
   ```
5. **Monitor API usage** - Check OpenAI dashboard monthly

---

## Environment Variables by Service

### Services that NEED configuration:
- ✅ **MySQL** - Must configure database connection
- ✅ **Redis** - Must be running (port 6379)
- ✅ **OpenAI** - Required for AI features only

### Services that are OPTIONAL:
- ⚪ **Email** - Can use `MAIL_MAILER=log` for testing
- ⚪ **Analytics** - Can skip Google Analytics/Facebook Pixel
- ⚪ **Social Media** - Only needed if using footer social links
- ⚪ **AWS S3** - Only for production file uploads (use local disk in dev)

---

## Quick Test

### Test Laravel .env
```bash
php artisan config:clear
php artisan tinker
```

In tinker:
```php
config('database.connections.mysql.database');  // Should show 'Smartech Research Labs'
config('services.openai.key');  // Should show your key
exit
```

### Test Redis Connection
```bash
redis-cli ping  # Should return PONG
```

### Test Socket.IO .env
```bash
cd server
node -e "require('dotenv').config(); console.log(process.env.API_TOKEN);"
# Should print your Sanctum token
```

### Test OpenAI Key
```bash
curl https://api.openai.com/v1/models \
  -H "Authorization: Bearer YOUR_OPENAI_KEY"
# Should return list of models
```

---

## Troubleshooting

### Issue: "SQLSTATE[HY000] [1045] Access denied"
**Fix:** Wrong MySQL credentials
```bash
# Test MySQL connection
mysql -u root -p
# If that works, update DB_USERNAME and DB_PASSWORD in .env
```

### Issue: "Connection refused [tcp://127.0.0.1:6379]"
**Fix:** Redis not running
```bash
# Check if Redis is running
redis-cli ping

# If not, start it:
# Windows (Docker): docker start redis
# Linux: sudo systemctl start redis
```

### Issue: "OpenAI API key not configured"
**Fix:** Missing/invalid OpenAI key
```bash
# Check if key is set
php artisan tinker
config('services.openai.key');
exit

# If null, add to .env:
OPENAI_API_KEY=sk-proj-your-key-here

# Then clear cache:
php artisan config:clear
```

### Issue: "CORS policy: No 'Access-Control-Allow-Origin'"
**Fix:** Update CORS_ORIGINS in server/.env
```bash
# server/.env
CORS_ORIGINS=http://localhost:8000,http://localhost:5173

# Or use wildcard in development (NOT in production):
CORS_ORIGINS=*
```

### Issue: "429 Too Many Requests" (OpenAI)
**Fix:** Rate limit exceeded
- Reduce `AI_RATE_LIMIT` in server/.env
- Upgrade OpenAI plan
- Add backoff/retry logic

---

## Environment Validation Checklist

Before starting the application, verify:

- [ ] `.env` file exists in project root
- [ ] `server/.env` file exists
- [ ] `APP_KEY` is generated (not empty)
- [ ] Database credentials are correct
- [ ] Database `Smartech Research Labs` exists
- [ ] Migrations have run (`php artisan migrate`)
- [ ] Redis is running (`redis-cli ping`)
- [ ] OpenAI API key is set (if using AI features)
- [ ] Sanctum token is generated for Socket.IO
- [ ] `VITE_SOCKET_URL` matches Socket.IO port
- [ ] CORS origins are configured

---

## Production Deployment Checklist

- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Use HTTPS URLs
- [ ] Enable `SESSION_SECURE_COOKIE=true`
- [ ] Update `SANCTUM_STATEFUL_DOMAINS`
- [ ] Update `CORS_ORIGINS` in server/.env
- [ ] Use strong database password
- [ ] Set Redis password
- [ ] Rotate all API keys
- [ ] Enable query logging
- [ ] Setup monitoring (Sentry, Bugsnag)
- [ ] Configure backups
- [ ] Setup SSL certificates
- [ ] Enable rate limiting
- [ ] Review all `.env` variables

---

**Last Updated:** February 2025  
**Version:** 1.0

For more help, see [QUICKSTART.md](QUICKSTART.md) or [README.md](README.md)
