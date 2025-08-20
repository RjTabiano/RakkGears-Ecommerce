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
php artisan cache:clear 2>/dev/null || echo "Cache clear failed - continuing..."

# Cache Laravel configuration for production
php artisan config:cache

echo "Laravel setup completed. Starting web services..."

# Check what PHP-FPM sockets/ports are available
echo "Checking PHP-FPM configuration..."
ls -la /var/run/php* 2>/dev/null || echo "No /var/run/php sockets found"
netstat -ln | grep :9000 || echo "No service on port 9000"

# Start PHP-FPM if not running
php-fpm -D 2>/dev/null || echo "PHP-FPM start failed or already running"

# Wait a moment for PHP-FPM to start
sleep 2

# Check again
ls -la /var/run/php* 2>/dev/null || echo "Still no PHP-FPM sockets"
netstat -ln | grep :9000 || echo "Still no service on port 9000"

# Stop any existing nginx
pkill nginx || true

# Test nginx config first
nginx -t -c /home/site/wwwroot/nginx.conf || echo "Nginx config test failed"

# Start nginx with our custom configuration
nginx -c /home/site/wwwroot/nginx.conf -g "daemon off;" &

echo "Nginx started with custom Laravel configuration"

# Keep the script running
wait
