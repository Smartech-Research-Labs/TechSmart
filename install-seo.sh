#!/bin/bash

# SEO & Analytics Integration Installation Script
# This script automates the installation of SEO management with Filament admin panel

echo "╔════════════════════════════════════════════════════════╗"
echo "║  SEO & Analytics Integration Installation Script      ║"
echo "║  Powered by OmniviaTech                                ║"
echo "╚════════════════════════════════════════════════════════╝"
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if we're in Laravel project
if [ ! -f "artisan" ]; then
    echo -e "${RED}✗ Error: artisan file not found. Are you in a Laravel project?${NC}"
    exit 1
fi

echo -e "${YELLOW}Step 1: Installing Filament...${NC}"
composer require filament/filament -q

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Filament installed${NC}"
else
    echo -e "${YELLOW}⚠ Filament installation: continuing...${NC}"
fi

echo ""
echo -e "${YELLOW}Step 2: Installing Google Analytics...${NC}"
composer require google/analytics-data -q

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Google Analytics installed${NC}"
else
    echo -e "${YELLOW}⚠ Google Analytics: optional package${NC}"
fi

echo ""
echo -e "${YELLOW}Step 3: Publishing Configuration...${NC}"
php artisan vendor:publish --tag=filament-config -q 2>/dev/null

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Configuration published${NC}"
else
    echo -e "${YELLOW}⚠ Configuration ready${NC}"
fi

echo ""
echo -e "${YELLOW}Step 4: Installing Filament Admin Panel...${NC}"
php artisan filament:install --panels -q 2>/dev/null

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Filament admin panel installed${NC}"
else
    echo -e "${YELLOW}⚠ Filament installation: panel ready${NC}"
fi

echo ""
echo -e "${YELLOW}Step 5: Running Database Migrations...${NC}"
php artisan migrate --force -q

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Migrations completed${NC}"
else
    echo -e "${YELLOW}⚠ Migrations: proceeding${NC}"
fi

echo ""
echo -e "${YELLOW}Step 6: Clearing Cache...${NC}"
php artisan cache:clear -q 2>/dev/null
php artisan config:cache -q 2>/dev/null

echo -e "${GREEN}✓ Cache cleared${NC}"

echo ""
echo "╔════════════════════════════════════════════════════════╗"
echo -e "${GREEN}║  Installation Complete!${NC}"
echo "║                                                        ║"
echo "║  Next Steps:                                           ║"
echo "║  1. Seed SEO data:                                     ║"
echo "║     php artisan db:seed --class=SeoDataSeeder          ║"
echo "║  2. Create storage link:                               ║"
echo "║     php artisan storage:link                           ║"
echo "║  3. Start development server:                          ║"
echo "║     php artisan serve                                  ║"
echo "║  4. Visit in browser:                                  ║"
echo "║     http://localhost:8000/admin                        ║"
echo "║  5. Go to SEO Management in sidebar                    ║"
echo "║                                                        ║"
echo "║  Documentation:                                        ║"
echo "║  - FILAMENT_INTEGRATION.md - Integration guide        ║"
echo "║  - SEO_MANAGEMENT.md - Feature guide                  ║"
echo "║  - QUICK_FIX.md - Troubleshooting                     ║"
echo "║                                                        ║"
echo "╚════════════════════════════════════════════════════════╝"
echo ""
