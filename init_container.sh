#!/bin/bash

# Set permissions
chmod 755 /home/site/wwwroot/init_container.sh

# Change to Laravel directory
cd /home/site/wwwroot

# Copy Laravel .env if it doesn't exist
if [ ! -f /home/site/wwwroot/.env ]; then
    cp /home/site/wwwroot/.env.example /home/site/wwwroot/.env || echo "No .env.example found"
fi

# Generate Laravel key if needed
php artisan key:generate --force || echo "Could not generate key"

# Clear any existing caches
php artisan config:clear || echo "Config clear failed"
php artisan route:clear || echo "Route clear failed"
php artisan cache:clear || echo "Cache clear failed"

# Cache configurations for production
php artisan config:cache || echo "Config cache failed"

# Check if nginx is already running and stop it
pkill nginx || echo "No existing nginx processes"

# Start Nginx in the foreground
exec nginx -c /home/site/wwwroot/nginx.conf -g "daemon off;"
