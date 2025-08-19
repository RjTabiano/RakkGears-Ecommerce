# Multi-stage build for production
FROM node:18-alpine AS node_builder
WORKDIR /app
COPY package*.json ./
COPY vite.config.js ./
COPY resources ./resources
COPY public ./public
RUN npm ci && npm run build

FROM php:8.2-fpm-alpine

# Install system dependencies and PHP extensions
RUN apk add --no-cache \
    nginx \
    supervisor \
    mysql-client \
    git \
    unzip \
    libzip-dev \
    oniguruma-dev \
    libpng-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        zip \
        gd \
        mbstring \
        opcache \
    && rm -rf /var/cache/apk/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files first for better caching
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy application code
COPY . .

# Copy built assets from node builder
COPY --from=node_builder /app/public/build ./public/build

# Install production dependencies
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Create necessary directories and set permissions
RUN mkdir -p /var/www/html/storage/framework/{sessions,views,cache} \
    && mkdir -p /var/www/html/storage/logs \
    && mkdir -p /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Copy configuration files
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/php.ini /usr/local/etc/php/conf.d/custom.ini
COPY docker/entrypoint-prod.sh /usr/local/bin/entrypoint-prod.sh

# Make entrypoint executable
RUN chmod +x /usr/local/bin/entrypoint-prod.sh

# Expose port (Render expects 10000)
EXPOSE 10000

# Use production entrypoint
ENTRYPOINT ["/usr/local/bin/entrypoint-prod.sh"]
