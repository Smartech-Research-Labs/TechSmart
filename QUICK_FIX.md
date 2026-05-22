# ⚡ Quick Fix - PowerShell & Installation Issues

## 🚨 PowerShell Error: "install-seo.bat not found"

### The Problem
You tried to run:
```powershell
PS D:\Work\TechSmart> install-seo.bat
```

But PowerShell said it's not recognized. This is because **PowerShell doesn't run scripts from the current directory by default**.

---

## ✅ The Solution

### Option 1: Use the dot-slash prefix (RECOMMENDED)

```powershell
.\install-seo.bat
```

The `.\` tells PowerShell to run the script in the current directory.

---

### Option 2: Use Command Prompt (cmd.exe) instead

Press `Windows + R`, type `cmd`, then:

```cmd
cd D:\Work\TechSmart
install-seo.bat
```

Command Prompt runs batch scripts directly.

---

### Option 3: Use full path

```powershell
C:\Work\TechSmart\install-seo.bat
```

Use the complete path to the file.

---

## 🔧 Composer Error: "Failed to install dependencies"

If you get:
```
Error: Failed to install dependencies
```

This likely means one or more packages failed to install. **Don't worry** - follow the **manual installation steps** instead:

### Manual Installation (More Reliable)

```powershell
cd D:\Work\TechSmart

# Step 1: Install Filament
composer require filament/filament

# Step 2: Install Google Analytics
composer require google/analytics-data

# Step 3: Publish Config
php artisan vendor:publish --tag=filament-config

# Step 4: Install Admin Panel
php artisan filament:install --panels

# Step 5: Run Migrations
php artisan migrate --force

# Step 6: Seed Data
php artisan db:seed --class=SeoDataSeeder

# Step 7: Create Storage Link
php artisan storage:link

# Step 8: Clear Caches
php artisan cache:clear
php artisan config:cache

# Step 9: Start Server
php artisan serve
```

Each command should complete before you run the next one.

---

## 📋 Step-by-Step Troubleshooting

### If Filament Installation Fails

```powershell
# Try installing with specific version
composer require filament/filament:^3.0

# If that fails, check PHP version
php -v

# PHP 8.2+ is required. If older, update PHP
```

### If Google Analytics Installation Fails

```powershell
# This package is optional. You can skip it:
# Just proceed to the next step
```

### If Migrations Fail

```powershell
# Check database connection
php artisan tinker

# In tinker, run:
# DB::connection()->getPdo()

# Should return a PDO object without errors
```

### If Admin Panel Won't Load

```powershell
# Clear all caches
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Restart the server
php artisan serve
```

---

## ✅ Verification Commands

After installation, verify everything is working:

```powershell
# Check Laravel version
php artisan --version

# Check if admin panel files exist
Test-Path app\Providers\AdminPanelProvider.php
Test-Path config\filament.php

# Check database connection
php artisan tinker
# Then type: DB::connection()->getPdo()

# Should return PDO object - if error, database isn't connected
```

---

## 🎯 Quick Start After Installation

Once installation is complete:

```powershell
# Terminal 1: Start Laravel server
php artisan serve

# Terminal 2: In another terminal (optional, for asset compilation)
npm run dev
```

Then open browser to:
```
http://localhost:8000/admin
```

Login and navigate to **SEO Management**.

---

## 📖 Full Documentation

For detailed instructions, see:
- **[MANUAL_INSTALLATION.md](MANUAL_INSTALLATION.md)** - Step-by-step guide
- **[FILAMENT_INTEGRATION.md](FILAMENT_INTEGRATION.md)** - Integration details
- **[SEO_MANAGEMENT.md](SEO_MANAGEMENT.md)** - Features guide

---

## 🆘 Still Having Issues?

### Common Problems & Solutions

| Problem | Solution |
|---------|----------|
| "artisan command not found" | Make sure you're in `D:\Work\TechSmart` directory |
| "Call to undefined method" | Run `php artisan cache:clear` |
| "Filament not installed" | Run `php artisan filament:install --panels` again |
| "Database error" | Check `.env` DB_* settings match your database |
| "Permission denied" | Run PowerShell as Administrator |
| "Port 8000 already in use" | Use different port: `php artisan serve --port=8001` |

---

## 📞 Next Steps

1. **Use this command to run the installer:**
   ```powershell
   .\install-seo.bat
   ```

2. **Or follow manual steps in:**
   ```
   MANUAL_INSTALLATION.md
   ```

3. **Then access your admin panel at:**
   ```
   http://localhost:8000/admin
   ```

---

**Ready to install? Pick one:**
- Easy: Run `.\install-seo.bat` (with the dot-slash)
- Manual: Follow steps in MANUAL_INSTALLATION.md
- Detailed: See FILAMENT_INTEGRATION.md for all details

---

*Powered by OmniviaTech • Enterprise Digital Solutions*
