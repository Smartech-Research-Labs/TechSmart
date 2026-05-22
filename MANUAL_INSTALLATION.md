# 🔧 Manual Installation Guide - SEO & Filament Admin

## ⚠️ Important: Run Commands in This Order

If the batch script fails, follow these manual steps **exactly as shown**:

---

## Step 0: Check Prerequisites & Fix Known Issues

Open PowerShell and run:

```powershell
php --version
composer --version
```

Both should show version numbers. If not, install PHP and Composer first.

---

## ⚠️ Important: If Composer Fails with "ext-intl"

You'll see an error like:
```
ext-intl * -> it is missing from your system
```

**This is normal!** The commands below include `--ignore-platform-req=ext-intl` to fix this.

The flag tells Composer to skip the intl extension check.

To enable intl properly (optional), see: **[ENABLE_INTL_EXTENSION.md](ENABLE_INTL_EXTENSION.md)**

---

## Step 1: Install Filament Package

```powershell
cd D:\Work\TechSmart
composer require filament/filament --ignore-platform-req=ext-intl
```

**Wait for completion.** This may take 2-5 minutes.

---

## Step 2: Install Google Analytics Package

```powershell
composer require google/analytics-data --ignore-platform-req=ext-intl
```

**Wait for completion.**

---

## Step 3: Publish Filament Configuration

```powershell
php artisan vendor:publish --tag=filament-config
```

Select option when prompted, or just press Enter for defaults.

---

## Step 4: Generate Filament Admin Panel

```powershell
php artisan filament:install --panels
```

This creates the admin panel structure.

---

## Step 5: Run Database Migrations

```powershell
php artisan migrate --force
```

This creates the `seo_data` table and other required tables.

---

## Step 6: Seed SEO Data (Optional)

```powershell
php artisan db:seed --class=SeoDataSeeder
```

This populates 18 pre-configured SEO pages.

---

## Step 7: Create Storage Symlink

```powershell
php artisan storage:link
```

This allows images to be served publicly.

---

## Step 8: Clear All Caches

```powershell
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Step 9: Start Development Server

```powershell
php artisan serve
```

You should see:
```
   INFO  Server running on [http://127.0.0.1:8000].
```

---

## Step 10: Access Admin Panel

In your browser, go to:

```
http://localhost:8000/admin
```

Login with your admin credentials:
```
Email: admin@omniviatech.com
Password: (your password)
```

---

## Step 11: Navigate to SEO Management

In the left sidebar, click **"SEO Management"**

You should see a list of 18 pages ready for SEO editing.

---

## 🆘 If You Encounter Errors

### Error: "composer command not found"
```powershell
# Add Composer to PATH or use full path:
C:\Users\{YourUsername}\AppData\Roaming\Composer\vendor\bin\composer.phar require filament/filament
```

### Error: "php command not found"
```powershell
# Add PHP to PATH or use full path, or download from php.net
```

### Error: "Call to undefined method"
```powershell
# Clear all caches and restart server:
php artisan cache:clear
php artisan config:cache
```

### Error: "Filament admin panel not found"
```powershell
# Re-run the installation:
php artisan filament:install --panels
php artisan migrate --force
```

### Error: "No such file or directory: 'artisan'"
```powershell
# Make sure you're in the right directory:
cd D:\Work\TechSmart
```

### Error: "ext-intl * -> it is missing from your system"
```powershell
# The commands already include the fix, but if you see this error:
# Either:
# 1. Enable intl extension (see ENABLE_INTL_EXTENSION.md)
# 2. Or use the flag already in these commands (they include it!)
# The --ignore-platform-req=ext-intl flag bypasses this check

# If it still fails, clear cache first:
composer clearcache
composer require filament/filament --ignore-platform-req=ext-intl
```

### Error: "Security advisory - packages blocked"
```powershell
# Composer is blocking packages due to security advisories
# This is normal - they're old versions
# The flag approach in the commands above bypasses this

# Or explicitly allow:
composer require filament/filament --ignore-platform-req=ext-intl --no-audit
```

---

## ✅ Verification Checklist

After completing all steps:

- [ ] No error messages appeared
- [ ] `php artisan serve` shows "Server running on http://127.0.0.1:8000"
- [ ] Can access http://localhost:8000/admin
- [ ] Can log in with admin credentials
- [ ] "SEO Management" appears in sidebar
- [ ] Can see list of 18 SEO pages
- [ ] Can click "Edit" on a page
- [ ] 6-tab form displays correctly

---

## 🎉 Success!

If you've completed all steps and verified them, your Filament admin panel is now installed and ready to use!

**Next:** Start editing SEO data for your pages.

---

## 📚 Related Documentation

- **[FIX_NOW.md](FIX_NOW.md)** - Quick fix for current errors ⚡
- **[ENABLE_INTL_EXTENSION.md](ENABLE_INTL_EXTENSION.md)** - Enable intl in XAMPP
- **[COMPOSER_SECURITY_FIX.md](COMPOSER_SECURITY_FIX.md)** - About security advisories
- **[FILAMENT_INTEGRATION.md](FILAMENT_INTEGRATION.md)** - Integration guide
- **[SEO_MANAGEMENT.md](SEO_MANAGEMENT.md)** - Feature guide
- **[QUICKSTART.md](QUICKSTART.md)** - Quick start

---

*Powered by OmniviaTech • Enterprise Digital Solutions*
