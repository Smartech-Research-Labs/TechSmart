# 🔧 Enable PHP intl Extension - XAMPP Setup

## ⚠️ Problem

Composer installation failed because:
```
ext-intl * -> it is missing from your system
```

The `intl` extension is required by Filament but not enabled in your XAMPP PHP configuration.

---

## ✅ Solution 1: Enable intl Extension (Recommended)

### Step 1: Find Your php.ini File

In XAMPP, there are two php.ini files. Find them:

**Option A: Using Command Prompt**
```cmd
php --ini
```

Look for lines like:
```
Configuration File (php.ini) Path: C:\xampp\php
Loaded Configuration File:         C:\xampp\php\php.ini
```

**Option B: Manual Location**
The php.ini file is usually at:
```
C:\xampp\php\php.ini
```

---

### Step 2: Open php.ini in Text Editor

Open `C:\xampp\php\php.ini` with:
- Notepad
- Notepad++
- VS Code

---

### Step 3: Find and Enable intl Extension

**Search for**: `extension=intl`

You'll find a line that looks like one of these:

```ini
;extension=intl
```

or

```ini
;ext-intl
```

The semicolon (`;`) means it's **disabled**.

---

### Step 4: Remove the Semicolon

**Change FROM:**
```ini
;extension=intl
```

**Change TO:**
```ini
extension=intl
```

---

### Step 5: Save the File

Press `Ctrl+S` to save the file.

---

### Step 6: Restart XAMPP

1. **Stop Apache** in XAMPP Control Panel
2. **Start Apache** again

---

### Step 7: Verify intl is Enabled

Open PowerShell and run:

```powershell
php -m | Select-String intl
```

If it shows `intl`, you're good! ✅

---

## ✅ Solution 2: Skip Extension Check (Temporary)

If you can't enable intl right now, the updated installation script already includes:

```
--ignore-platform-req=ext-intl
```

This tells Composer to skip the extension check. The script will work without intl enabled.

---

## 🚀 Now Run Installation

After enabling intl (or using the updated script with the flag), run:

```powershell
cd D:\Work\TechSmart
.\install-seo.bat
```

Or manually:

```powershell
composer require filament/filament --ignore-platform-req=ext-intl
```

---

## 🆘 Still Having Issues?

### Error: "Can't find php.ini"

Try this:
```cmd
php --ini
```

This shows exact path to your php.ini file.

---

### Error: "After enabling intl, still getting error"

Restart Apache in XAMPP Control Panel:

1. Click "Stop" next to Apache
2. Wait 3 seconds
3. Click "Start" next to Apache
4. Try installation again

---

### Error: "intl extension still not found"

Your XAMPP might not have PHP compiled with intl support. Try:

```powershell
composer require filament/filament --ignore-platform-req=ext-intl
```

This bypasses the check and allows installation to proceed.

---

## 📋 Checklist

- [ ] Found php.ini location
- [ ] Opened php.ini in editor
- [ ] Found `;extension=intl` line
- [ ] Removed the semicolon
- [ ] Saved the file
- [ ] Restarted Apache
- [ ] Verified with `php -m | Select-String intl`
- [ ] Ready to run installation script

---

## 🎯 Quick Start (With Both Solutions)

**If you enabled intl:**
```powershell
.\install-seo.bat
```

**If intl won't enable:**
```powershell
composer require filament/filament --ignore-platform-req=ext-intl
composer require google/analytics-data --ignore-platform-req=ext-intl
php artisan vendor:publish --tag=filament-config
php artisan filament:install --panels
php artisan migrate --force
php artisan serve
```

---

## 📚 Related Files

- [INSTALLATION_GUIDE.md](INSTALLATION_GUIDE.md) - Main installation guide
- [MANUAL_INSTALLATION.md](MANUAL_INSTALLATION.md) - Step-by-step manual
- [QUICK_FIX.md](QUICK_FIX.md) - Common errors & fixes

---

## ℹ️ What is intl Extension?

The `intl` extension provides internationalization (i18n) functionality for PHP:
- Date/time formatting
- Character encoding
- Locale-aware operations

Filament uses it for proper formatting of data in the admin panel.

---

*Powered by OmniviaTech • Enterprise Digital Solutions*
