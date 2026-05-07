# PowerShell script to start all OmniviaTech services
# Run this with: .\start-dev.ps1

Write-Host "==================================================" -ForegroundColor Cyan
Write-Host "        OmniviaTech Development Environment        " -ForegroundColor Cyan
Write-Host "==================================================" -ForegroundColor Cyan
Write-Host ""

# Check if Redis is running
Write-Host "Checking Redis connection..." -ForegroundColor Yellow
try {
    $redisTest = redis-cli ping 2>&1
    if ($redisTest -eq "PONG") {
        Write-Host "[OK] Redis is running" -ForegroundColor Green
    } else {
        Write-Host "[ERROR] Redis is not responding" -ForegroundColor Red
        Write-Host "  Start Redis with: docker run -d -p 6379:6379 redis:alpine" -ForegroundColor Yellow
        exit 1
    }
} catch {
    Write-Host "[ERROR] Redis CLI not found or Redis not running" -ForegroundColor Red
    Write-Host "  Install Redis or start Docker container" -ForegroundColor Yellow
    exit 1
}

# Check if .env exists
if (-Not (Test-Path ".env")) {
    Write-Host "[ERROR] .env file not found" -ForegroundColor Red
    Write-Host "  Run: cp .env.example .env" -ForegroundColor Yellow
    exit 1
}

# Check if server/.env exists
if (-Not (Test-Path "server\.env")) {
    Write-Host "[ERROR] server/.env file not found" -ForegroundColor Red
    Write-Host "  Run: cd server; cp .env.example .env" -ForegroundColor Yellow
    exit 1
}

# Check if database is migrated
Write-Host ""
Write-Host "Checking database..." -ForegroundColor Yellow
$tables = php artisan db:show 2>&1
if ($tables -match "users") {
    Write-Host "[OK] Database is migrated" -ForegroundColor Green
} else {
    Write-Host "[WARNING] Database not migrated" -ForegroundColor Yellow
    Write-Host "  Run: php artisan migrate --seed" -ForegroundColor Yellow
    $migrate = Read-Host "Run migrations now? (y/N)"
    if ($migrate -eq "y" -or $migrate -eq "Y") {
        php artisan migrate --seed
    } else {
        exit 1
    }
}

Write-Host ""
Write-Host "==================================================" -ForegroundColor Cyan
Write-Host "          Starting all services...                " -ForegroundColor Cyan
Write-Host "==================================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "This will open 5 terminal windows:" -ForegroundColor Yellow
Write-Host "  1. Laravel API Server (port 8000)" -ForegroundColor White
Write-Host "  2. Vite Dev Server (HMR)" -ForegroundColor White
Write-Host "  3. Socket.IO Server (port 3000)" -ForegroundColor White
Write-Host "  4. BullMQ Worker" -ForegroundColor White
Write-Host "  5. Laravel Queue Worker" -ForegroundColor White
Write-Host ""

$continue = Read-Host "Continue? (Y/n)"
if ($continue -eq "n" -or $continue -eq "N") {
    Write-Host "Cancelled." -ForegroundColor Yellow
    exit 0
}

Write-Host ""
Write-Host "Starting services..." -ForegroundColor Green

# 1. Start Laravel API Server
Start-Process powershell -ArgumentList "-NoExit","-Command","Write-Host '=== Laravel API Server ===' -ForegroundColor Cyan; php artisan serve"

Start-Sleep -Seconds 2

# 2. Start Vite Dev Server
Start-Process powershell -ArgumentList "-NoExit","-Command","Write-Host '=== Vite Dev Server ===' -ForegroundColor Cyan; npm run dev"

Start-Sleep -Seconds 2

# 3. Start Socket.IO Server
Start-Process powershell -ArgumentList "-NoExit","-Command","Write-Host '=== Socket.IO Server ===' -ForegroundColor Cyan; cd server; npm run dev"

Start-Sleep -Seconds 2

# 4. Start BullMQ Worker
Start-Process powershell -ArgumentList "-NoExit","-Command","Write-Host '=== BullMQ Worker ===' -ForegroundColor Cyan; cd server; npm run dev:worker"

Start-Sleep -Seconds 2

# 5. Start Laravel Queue Worker
Start-Process powershell -ArgumentList "-NoExit","-Command","Write-Host '=== Laravel Queue Worker ===' -ForegroundColor Cyan; php artisan queue:work redis --tries=3"

Write-Host ""
Write-Host "==================================================" -ForegroundColor Green
Write-Host "       All services started successfully!         " -ForegroundColor Green
Write-Host "==================================================" -ForegroundColor Green
Write-Host ""
Write-Host "Access the application:" -ForegroundColor Yellow
Write-Host "  Frontend:     http://localhost:8000" -ForegroundColor White
Write-Host "  API:          http://localhost:8000/api/v1" -ForegroundColor White
Write-Host "  Socket.IO:    http://localhost:3000" -ForegroundColor White
Write-Host "  Health Check: http://localhost:3000/health" -ForegroundColor White
Write-Host ""
Write-Host "Default Credentials:" -ForegroundColor Yellow
Write-Host "  Email:    admin@omniviatech.com" -ForegroundColor White
Write-Host "  Password: password" -ForegroundColor White
Write-Host ""
Write-Host "To stop all services, close the terminal windows." -ForegroundColor Gray
Write-Host ""
