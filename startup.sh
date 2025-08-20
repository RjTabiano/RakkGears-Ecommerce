#!/bin/bash
# Start PHP-FPM in the background
php-fpm &

# Start Nginx in the foreground
nginx -c /home/site/wwwroot/nginx.conf -g "daemon off;"
