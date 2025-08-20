#!/bin/bash

# Post-deployment script for Laravel
cd /home/site/wwwroot

# Clear all caches
php artisan config:clear
php artisan route:clear
php artisan cache:clear

# Rebuild caches for production
php artisan config:cache

# Set proper permissions
chmod -R 755 storage bootstrap/cache

echo "Post-deployment tasks completed"
