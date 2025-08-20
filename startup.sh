#!/bin/bash

# Azure App Service startup script for Laravel with custom nginx

echo "Starting Laravel app with custom nginx configuration..."

# Change to Laravel directory
cd /home/site/wwwroot

# Create all required Laravel directories
echo "Creating Laravel directories..."
mkdir -p storage/app/public
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/testing
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Set proper permissions
chmod -R 755 storage
chmod -R 755 bootstrap/cache

echo "Laravel directories created successfully"

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

# Get container IP addresses
echo "Container network configuration:"
ip addr show | grep inet || echo "IP address check failed"

# Start PHP-FPM if not running
php-fpm -D 2>/dev/null || echo "PHP-FPM start failed or already running"

# Wait a moment for PHP-FPM to start
sleep 2

# Check again and get detailed info
echo "PHP-FPM status after start:"
netstat -ln | grep :9000
ps aux | grep php-fpm | head -3

# Test PHP-FPM connectivity
echo "Testing PHP-FPM connectivity..."
echo "Testing IPv4 localhost:"
nc -z 127.0.0.1 9000 && echo "✅ IPv4 localhost works" || echo "❌ IPv4 localhost failed"
echo "Testing IPv6 localhost:"
nc -z ::1 9000 && echo "✅ IPv6 localhost works" || echo "❌ IPv6 localhost failed"

# Stop any existing nginx
pkill nginx || true

# Intelligent nginx configuration selection
echo "Selecting optimal nginx configuration..."

# Check PHP-FPM connectivity and choose config accordingly
if nc -z 127.0.0.1 9000; then
    echo "✅ Using standard config - IPv4 connectivity works"
    NGINX_CONFIG="/home/site/wwwroot/nginx.conf"
elif nc -z ::1 9000; then
    echo "⚠️ Using IPv6 config - only IPv6 connectivity works"
    sed 's/127\.0\.0\.1:9000/[::1]:9000/' /home/site/wwwroot/nginx.conf > /tmp/nginx-ipv6.conf
    NGINX_CONFIG="/tmp/nginx-ipv6.conf"
elif [ -S /var/run/php/php-fpm.sock ] || [ -S /var/run/php-fpm.sock ]; then
    echo "🔧 Using socket config - TCP ports not working"
    # Use socket-based connection
    sed 's/fastcgi_pass 127\.0\.0\.1:9000;/fastcgi_pass unix:\/var\/run\/php\/php-fpm.sock;/' /home/site/wwwroot/nginx-fallback.conf > /tmp/nginx-socket.conf
    NGINX_CONFIG="/tmp/nginx-socket.conf"
else
    echo "⚡ Using fallback config with upstream"
    NGINX_CONFIG="/home/site/wwwroot/nginx-fallback.conf"
fi

# Test the selected config
nginx -t -c "$NGINX_CONFIG" || echo "Warning: Nginx config test failed"

# Start nginx with the selected configuration
nginx -c "$NGINX_CONFIG" -g "daemon off;" &

echo "Nginx started with configuration: $NGINX_CONFIG"

# Keep the script running
wait
