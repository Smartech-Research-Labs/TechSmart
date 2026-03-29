@echo off
REM Simple batch script to start all Smartech Research Labs services
REM Run this with: dev.bat

echo ==================================================
echo       Smartech Research Labs Development Environment        
echo ==================================================
echo.
echo Starting all services with concurrently...
echo.

npm run serve:dev
