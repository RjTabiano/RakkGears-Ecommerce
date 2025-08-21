#!/bin/bash

# Laravel Azure App Service Quick Setup Script
# This script sets up a Laravel project for Azure App Service deployment

echo "🚀 Setting up Laravel for Azure App Service deployment..."

# Check if we're in a Laravel project
if [ ! -f "artisan" ]; then
    echo "❌ Error: This doesn't appear to be a Laravel project (no artisan file found)"
    exit 1
fi

echo "✅ Laravel project detected"

# Create nginx configuration
echo "📋 Creating nginx configuration..."
cat > nginx.conf << 'EOF'
worker_processes 1;

events {
    worker_connections 1024;
}

http {
    include       /etc/nginx/mime.types;
    default_type  application/octet-stream;
    sendfile        on;
    keepalive_timeout  65;

    server {
        listen 8080;
        listen [::]:8080;
        server_name example.com;
        root /home/site/wwwroot/public;

        add_header X-Frame-Options "SAMEORIGIN";
        add_header X-Content-Type-Options "nosniff";

        index index.php;
        charset utf-8;

        location / {
            try_files $uri $uri/ /index.php?$query_string;
        }

        location = /favicon.ico { access_log off; log_not_found off; }
        location = /robots.txt  { access_log off; log_not_found off; }

        error_page 404 /index.php;

        location ~ \.php$ {
            try_files $uri =404;
            fastcgi_split_path_info ^(.+\.php)(/.+)$;
            fastcgi_pass 127.0.0.1:9000;
            fastcgi_index index.php;
            fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
            include /etc/nginx/fastcgi_params;
            fastcgi_param PATH_INFO $fastcgi_path_info;
            fastcgi_intercept_errors on;
            fastcgi_connect_timeout 300;
            fastcgi_send_timeout 3600;
            fastcgi_read_timeout 3600;
        }

        location ~ /\.(?!well-known).* {
            deny all;
        }
    }
}
EOF

# Create fallback nginx configuration
echo "📋 Creating fallback nginx configuration..."
cat > nginx-fallback.conf << 'EOF'
worker_processes 1;

events {
    worker_connections 1024;
}

http {
    include       /etc/nginx/mime.types;
    default_type  application/octet-stream;
    sendfile        on;
    keepalive_timeout  65;
    
    upstream php-fpm {
        server 127.0.0.1:9000;
        server [::1]:9000 backup;
    }

    server {
        listen 8080;
        listen [::]:8080;
        server_name example.com;
        root /home/site/wwwroot/public;

        add_header X-Frame-Options "SAMEORIGIN";
        add_header X-Content-Type-Options "nosniff";

        index index.php;
        charset utf-8;

        location / {
            try_files $uri $uri/ /index.php?$query_string;
        }

        location = /favicon.ico { access_log off; log_not_found off; }
        location = /robots.txt  { access_log off; log_not_found off; }

        error_page 404 /index.php;

        location ~ \.php$ {
            try_files $uri =404;
            fastcgi_split_path_info ^(.+\.php)(/.+)$;
            fastcgi_pass php-fpm;
            fastcgi_index index.php;
            fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
            include /etc/nginx/fastcgi_params;
            fastcgi_param PATH_INFO $fastcgi_path_info;
            fastcgi_intercept_errors on;
            fastcgi_connect_timeout 300;
            fastcgi_send_timeout 3600;
            fastcgi_read_timeout 3600;
        }

        location ~ /\.(?!well-known).* {
            deny all;
        }
    }
}
EOF

# Create startup script
echo "🔧 Creating intelligent startup script..."
cat > startup.sh << 'EOF'
#!/bin/bash

echo "Starting Laravel app with custom nginx configuration..."

cd /home/site/wwwroot

# Create all required Laravel directories
echo "Creating Laravel directories..."
mkdir -p storage/app/public
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/testing
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Set proper permissions
chmod -R 755 storage
chmod -R 755 bootstrap/cache

echo "Laravel directories created successfully"

# Clear and cache Laravel configuration
php artisan config:clear
php artisan route:clear
php artisan cache:clear 2>/dev/null || echo "Cache clear failed - continuing..."
php artisan config:cache

echo "Laravel setup completed. Starting web services..."

# Check PHP-FPM status
echo "Checking PHP-FPM configuration..."
ls -la /var/run/php* 2>/dev/null || echo "No /var/run/php sockets found"
netstat -ln | grep :9000 || echo "No service on port 9000"

# Start PHP-FPM if not running
php-fpm -D 2>/dev/null || echo "PHP-FPM start failed or already running"
sleep 2

# Test PHP-FPM connectivity
echo "Testing PHP-FPM connectivity..."
nc -z 127.0.0.1 9000 && echo "✅ IPv4 localhost works" || echo "❌ IPv4 localhost failed"
nc -z ::1 9000 && echo "✅ IPv6 localhost works" || echo "❌ IPv6 localhost failed"

# Stop any existing nginx
pkill nginx || true

# Intelligent nginx configuration selection
echo "Selecting optimal nginx configuration..."

if nc -z 127.0.0.1 9000; then
    echo "✅ Using standard config - IPv4 connectivity works"
    NGINX_CONFIG="/home/site/wwwroot/nginx.conf"
elif nc -z ::1 9000; then
    echo "⚠️ Using IPv6 config - only IPv6 connectivity works"
    sed 's/127\.0\.0\.1:9000/[::1]:9000/' /home/site/wwwroot/nginx.conf > /tmp/nginx-ipv6.conf
    NGINX_CONFIG="/tmp/nginx-ipv6.conf"
elif [ -S /var/run/php/php-fpm.sock ] || [ -S /var/run/php-fpm.sock ]; then
    echo "🔧 Using socket config - TCP ports not working"
    sed 's/fastcgi_pass 127\.0\.0\.1:9000;/fastcgi_pass unix:\/var\/run\/php\/php-fpm.sock;/' /home/site/wwwroot/nginx-fallback.conf > /tmp/nginx-socket.conf
    NGINX_CONFIG="/tmp/nginx-socket.conf"
else
    echo "⚡ Using fallback config with upstream"
    NGINX_CONFIG="/home/site/wwwroot/nginx-fallback.conf"
fi

# Test and start nginx
nginx -t -c "$NGINX_CONFIG" || echo "Warning: Nginx config test failed"
nginx -c "$NGINX_CONFIG" -g "daemon off;" &

echo "Nginx started with configuration: $NGINX_CONFIG"
wait
EOF

# Make startup script executable
chmod +x startup.sh

# Check for root-level .htaccess and remove if exists
if [ -f ".htaccess" ]; then
    echo "⚠️  Removing root-level .htaccess file (conflicts with nginx)"
    rm .htaccess
fi

# Ensure public/.htaccess exists with Laravel rules
if [ ! -f "public/.htaccess" ]; then
    echo "📝 Creating Laravel .htaccess in public directory..."
    cat > public/.htaccess << 'EOF'
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
EOF
fi

echo ""
echo "🎉 Azure App Service setup complete!"
echo ""
echo "📁 Created files:"
echo "   - nginx.conf (primary configuration)"
echo "   - nginx-fallback.conf (fallback with upstream)"
echo "   - startup.sh (intelligent startup script)"
echo "   - public/.htaccess (Laravel rewrite rules)"
echo ""
echo "🔧 Next steps:"
echo "   1. Set Azure App Service startup command to: /home/site/wwwroot/startup.sh"
echo "   2. Configure your environment variables in Azure"
echo "   3. Deploy your application"
echo ""
echo "✅ The startup script will automatically:"
echo "   - Create Laravel directories with proper permissions"
echo "   - Test PHP-FPM connectivity methods"
echo "   - Select the optimal nginx configuration"
echo "   - Start services with comprehensive logging"
echo ""
EOF

chmod +x setup-azure.sh

echo "✅ Created Azure deployment setup script: setup-azure.sh"
