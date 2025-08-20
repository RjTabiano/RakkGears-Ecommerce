#!/bin/bash

# Ensure proper permissions
chmod 755 /home/site/wwwroot/init_container.sh

# Start PHP-FPM in the background with proper configuration
php-fpm -D

# Wait a moment for PHP-FPM to start
sleep 2

# Start Nginx in the foreground
exec nginx -c /home/site/wwwroot/nginx.conf -g "daemon off;"
