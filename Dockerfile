# ---------------------
# Stage 1: Node builder
# ---------------------
FROM node:18-alpine AS node-builder

WORKDIR /app

# Copy package.json & lock first (better caching)
COPY package*.json ./

RUN npm ci

# Copy source files for building assets
COPY resources/ ./resources
COPY vite.config.* ./
COPY tailwind.config.* ./
COPY postcss.config.* ./

# Build assets
RUN npm run build

# ------------------------
# Stage 2: PHP + Nginx app
# ------------------------
FROM richarvey/nginx-php-fpm:3.1.6

# Set working dir
WORKDIR /var/www/html

# Copy full Laravel app
COPY . .

# Copy built assets from Node stage
COPY --from=node-builder /app/public/build ./public/build

# Image config
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

ENV COMPOSER_ALLOW_SUPERUSER 1

CMD ["/start.sh"]
