@echo off
REM Simple batch script to start all TechSmart services
REM Run this with: dev.bat

echo ==================================================
echo       TechSmart Development Environment        
echo ==================================================
echo.
echo Starting all services with concurrently...
echo.

npm run serve:dev
