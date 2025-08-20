#!/bin/bash

# Azure App Service startup script for Laravel with custom nginx

echo "Starting Laravel app with custom nginx configuration..."

# Set proper permissions
chmod -R 755 /home/site/wwwroot/storage
chmod -R 755 /home/site/wwwroot/bootstrap/cache

# Change to Laravel directory
cd /home/site/wwwroot

# Clear Laravel caches
php artisan config:clear
php artisan route:clear
php artisan cache:clear

# Cache Laravel configuration for production
php artisan config:cache

echo "Laravel setup completed. Starting web services..."

# Stop any existing nginx
pkill nginx || true

# Start nginx with our custom configuration
nginx -c /home/site/wwwroot/nginx.conf -g "daemon off;" &

echo "Nginx started with custom Laravel configuration"

# Keep the script running
wait
