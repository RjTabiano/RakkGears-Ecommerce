#!/usr/bin/env bash

# Install Node.js (LTS)
echo "Installing Node.js..."
curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
apt-get install -y nodejs

# Composer install
echo "Running composer..."
composer install --no-dev --working-dir=/var/www/html

# Vite build
echo "Installing npm dependencies..."
cd /var/www/html
npm ci
npm run build

# Laravel setup
echo "Generating application key..."
php artisan key:generate --show

echo "Caching config..."
php artisan config:cache
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force
