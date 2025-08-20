#!/bin/bash

# Create required directories
mkdir -p /var/run/php
mkdir -p /var/log/nginx

# Set permissions
chmod 755 /home/site/wwwroot/init_container.sh

# Copy Laravel .env if it doesn't exist
if [ ! -f /home/site/wwwroot/.env ]; then
    cp /home/site/wwwroot/.env.example /home/site/wwwroot/.env || echo "No .env.example found"
fi

# Generate Laravel key if needed
cd /home/site/wwwroot
php artisan key:generate --force || echo "Could not generate key"

# Run Laravel optimizations
php artisan config:cache || echo "Config cache failed"
php artisan route:cache || echo "Route cache failed"
php artisan view:cache || echo "View cache failed"

# Start PHP-FPM
php-fpm -y /home/site/wwwroot/php-fpm.conf -D

# Wait for PHP-FPM to start
sleep 3

# Start Nginx in the foreground
exec nginx -c /home/site/wwwroot/nginx.conf -g "daemon off;"
