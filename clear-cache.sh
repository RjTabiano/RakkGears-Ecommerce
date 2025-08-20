#!/bin/bash
# Clear all Laravel caches - run this via Azure Console

cd /home/site/wwwroot

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Rebuild config cache only (not routes since they may fail)
php artisan config:cache

# Fix permissions
chmod -R 755 storage bootstrap/cache

echo "Laravel caches cleared successfully!"
