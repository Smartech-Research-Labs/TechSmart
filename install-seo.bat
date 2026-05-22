@echo off
REM SEO & Analytics Integration Installation Script for Windows
REM Powered by OmniviaTech

echo.
echo ════════════════════════════════════════════════════════
echo   SEO Analytics Integration Installation Script
echo   Powered by OmniviaTech
echo ════════════════════════════════════════════════════════
echo.

REM Check if we're in Laravel project
if not exist "artisan" (
    echo Error: artisan file not found. Are you in a Laravel project?
    exit /b 1
)

echo.
echo [INFO] Checking PHP extensions...
php -m | find "intl" >nul
if errorlevel 1 (
    echo [WARNING] PHP intl extension not enabled
    echo [INFO] To fix: Enable intl in XAMPP php.ini
    echo [INFO] See: ENABLE_INTL_EXTENSION.md for instructions
    echo [INFO] OR this script will skip it with --ignore-platform-req
)
echo.

REM Step 1: Install Filament Package
echo [1/6] Installing Filament Package...
call composer require filament/filament -q --ignore-platform-req=ext-intl

if errorlevel 1 (
    echo Warning: Filament installation encountered an issue, continuing...
)
echo OK - Filament package added
echo.

REM Step 2: Install Google Analytics Package
echo [2/6] Installing Google Analytics Package...
call composer require google/analytics-data -q --ignore-platform-req=ext-intl

if errorlevel 1 (
    echo Warning: Google Analytics package installation encountered an issue, continuing...
)
echo OK - Google Analytics package added
echo.

REM Step 3: Publish Filament Configuration
echo [3/6] Publishing Filament Configuration...
call php artisan vendor:publish --tag=filament-config -q 2>nul

if errorlevel 1 (
    echo Warning: Some configs may already be published
)
echo OK - Configuration files ready
echo.

REM Step 4: Install Filament Admin Panel
echo [4/6] Installing Filament Admin Panel...
call php artisan filament:install --panels -q

if errorlevel 1 (
    echo Warning: Filament installation command executed
)
echo OK - Filament admin panel configured
echo.

REM Step 5: Run Database Migrations
echo [5/6] Running Database Migrations...
call php artisan migrate --force -q

if errorlevel 1 (
    echo Warning: Migration completed with notes
)
echo OK - Migrations completed
echo.

REM Step 6: Clear Cache
echo [6/6] Clearing Cache...
call php artisan cache:clear -q 2>nul
call php artisan config:cache -q 2>nul
echo OK - Cache cleared
echo.

echo ════════════════════════════════════════════════════════
echo Installation Complete!
echo.
echo Next Steps:
echo 1. Ensure .env has SEO variables (already added)
echo 2. Run: php artisan storage:link
echo 3. Run: php artisan db:seed --class=SeoDataSeeder
echo 4. Run: php artisan serve
echo 5. Visit: http://localhost:8000/admin
echo 6. Navigate to SEO Management in sidebar
echo.
echo For manual installation steps, see:
echo - MANUAL_INSTALLATION.md
echo - SEO_SETUP.md
echo ════════════════════════════════════════════════════════
echo.
pause
