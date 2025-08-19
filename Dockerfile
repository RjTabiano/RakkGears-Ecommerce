# Stage 1: Build assets with Node
FROM node:18 AS node_builder
WORKDIR /app
COPY package*.json vite.config.js ./
COPY resources ./resources
COPY public ./public
RUN npm install && npm run build

# Stage 2: Laravel + PHP
FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libpq-dev \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy Laravel code
COPY . .

# Copy built assets from node builder
COPY --from=node_builder /app/public/build ./public/build

# Install Laravel dependencies
RUN composer install --optimize-autoloader --no-dev \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Expose port
EXPOSE 8080

# Run Laravel server
CMD php artisan serve --host=0.0.0.0 --port=8080
