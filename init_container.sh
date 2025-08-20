#!/bin/bash

# Change to Laravel directory
cd /home/site/wwwroot

# Clear and cache Laravel configurations
php artisan config:clear
php artisan config:cache

# Set proper permissions
chmod -R 755 storage bootstrap/cache

echo "Laravel initialization completed"
