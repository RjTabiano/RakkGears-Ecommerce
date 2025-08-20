#!/bin/bash

# Simple Laravel setup for Azure App Service
# Let Azure handle nginx, we just configure Laravel

echo "Setting up Laravel for Azure App Service..."

# Set proper permissions
chmod -R 755 /home/site/wwwroot/storage
chmod -R 755 /home/site/wwwroot/bootstrap/cache

# Change to Laravel directory
cd /home/site/wwwroot

# Clear and cache Laravel configuration
php artisan config:clear
php artisan route:clear
php artisan cache:clear 2>/dev/null || echo "Cache clear failed - continuing..."
php artisan config:cache

echo "Laravel setup completed. Letting Azure handle web server..."

# Don't start custom nginx - let Azure's default nginx handle it
# This script will exit and let Azure's init continue
