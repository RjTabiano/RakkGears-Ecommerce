#!/usr/bin/env bash

# Install Node for Vite
echo "Installing Node.js..."
apt-get update && apt-get install -y nodejs npm

# Composer install
echo "Running composer..."
composer global require hirak/prestissimo
composer install --no-dev --working-dir=/var/www/html

# Vite build
echo "Installing npm dependencies..."
cd /var/www/html
npm install
npm run build

# Laravel setup
echo "Generating application key..."
php artisan key:generate --show

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force
