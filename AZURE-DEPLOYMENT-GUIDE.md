# Laravel on Azure App Service - Complete Deployment Guide

## Overview
This guide documents the complete solution for deploying Laravel applications to Azure App Service with proper routing, SSL database connectivity, and production-ready configuration.

## Key Components

### 1. Nginx Configuration (`nginx.conf`)
- **Purpose**: Custom nginx configuration optimized for Laravel on Azure App Service
- **Document Root**: Points to `/home/site/wwwroot/public` (Laravel's public directory)
- **Key Features**:
  - Laravel-specific `try_files` directive for proper routing
  - PHP-FPM integration with optimized timeouts
  - Security headers and .git directory protection
  - Listens on port 8080 (Azure App Service requirement)

```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}

location ~ \.php$ {
    fastcgi_pass 127.0.0.1:9000;
    fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
    # ... other PHP-FPM params
}
```

### 2. Fallback Nginx Configuration (`nginx-fallback.conf`)
- **Purpose**: Alternative configuration with upstream fallback for PHP-FPM connectivity issues
- **Key Features**:
  - Upstream block with IPv4 primary and IPv6 backup
  - Automatic failover between connection methods
  - Same Laravel routing as main config

```nginx
upstream php-fpm {
    server 127.0.0.1:9000;
    server [::1]:9000 backup;
}
```

### 3. Intelligent Startup Script (`startup.sh`)
- **Purpose**: Azure App Service startup script with intelligent configuration selection
- **Key Features**:
  - Automatic Laravel directory creation with proper permissions
  - PHP-FPM connectivity testing (IPv4, IPv6, Unix sockets)
  - Dynamic nginx configuration selection based on available connectivity
  - Comprehensive diagnostics and logging

#### Directory Setup
```bash
mkdir -p storage/app/public
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/testing
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache
chmod -R 755 storage bootstrap/cache
```

#### Intelligent Config Selection
```bash
if nc -z 127.0.0.1 9000; then
    # Use IPv4 configuration
elif nc -z ::1 9000; then
    # Use IPv6 configuration
elif [ -S /var/run/php/php-fpm.sock ]; then
    # Use Unix socket configuration
else
    # Use upstream fallback configuration
fi
```

### 4. SSL Certificate Configuration
- **Purpose**: Combine DigiCert certificates for Azure MySQL SSL connection
- **Files Required**:
  - `DigiCertGlobalRootCA.crt.pem`
  - `DigiCertGlobalRootG2.crt.pem`
  - `Microsoft ECC Root Certificate Authority 2017.crt.pem`
- **Combined File**: `combined-ca-certificates.pem`

```bash
cat DigiCertGlobalRootCA.crt.pem DigiCertGlobalRootG2.crt.pem "Microsoft ECC Root Certificate Authority 2017.crt.pem" > combined-ca-certificates.pem
```

## Implementation Steps

### Step 1: Prepare Laravel Application
1. Ensure `routes/web.php` has proper route definitions
2. Verify `HomeController` exists with required methods
3. Confirm `public/.htaccess` contains Laravel rewrite rules
4. Remove any root-level `.htaccess` files that might conflict

### Step 2: Create Nginx Configuration
1. Create `nginx.conf` with Laravel-optimized settings
2. Create `nginx-fallback.conf` with upstream fallback
3. Configure document root to point to `public` directory
4. Set up PHP-FPM integration with appropriate timeouts

### Step 3: Implement Startup Script
1. Create `startup.sh` with intelligent configuration selection
2. Add Laravel directory creation and permissions setup
3. Implement PHP-FPM connectivity testing
4. Add dynamic nginx configuration selection logic

### Step 4: Configure SSL Certificates (if using Azure MySQL)
1. Download required DigiCert certificates
2. Combine certificates into single file
3. Update Laravel database configuration to use combined certificates

### Step 5: Azure App Service Configuration
1. Set startup command to `/home/site/wwwroot/startup.sh`
2. Configure PHP version (8.1 recommended)
3. Set up GitHub Actions deployment pipeline
4. Configure environment variables in Azure

## Troubleshooting Common Issues

### Issue 1: 502 Bad Gateway
- **Cause**: PHP-FPM connectivity problems
- **Solution**: Startup script automatically detects and uses working connection method

### Issue 2: Laravel Routes Not Working
- **Cause**: Incorrect nginx configuration or missing .htaccess
- **Solution**: Use provided nginx.conf with proper `try_files` directive

### Issue 3: Storage Permission Errors
- **Cause**: Missing Laravel directories or incorrect permissions
- **Solution**: Startup script automatically creates directories with proper permissions

### Issue 4: IPv6 Connectivity Issues
- **Cause**: Azure container IPv6 localhost configuration
- **Solution**: Fallback configuration with upstream and multiple connection methods

## Key Success Factors

1. **Document Root**: Must point to Laravel's `public` directory
2. **PHP-FPM Configuration**: Intelligent selection between IPv4, IPv6, and socket connections
3. **Directory Structure**: Automatic creation of all required Laravel directories
4. **Permissions**: Proper chmod settings for storage and cache directories
5. **SSL Certificates**: Combined certificate file for Azure MySQL connectivity
6. **Fallback Strategy**: Multiple nginx configurations for different environments

## File Checklist

- [ ] `nginx.conf` - Primary nginx configuration
- [ ] `nginx-fallback.conf` - Fallback configuration with upstream
- [ ] `startup.sh` - Intelligent startup script
- [ ] `routes/web.php` - Laravel routes properly defined
- [ ] `public/.htaccess` - Laravel rewrite rules
- [ ] `ssl/combined-ca-certificates.pem` - Combined SSL certificates (if needed)
- [ ] No root-level `.htaccess` files

## Environment Variables

Set these in Azure App Service Configuration:

```bash
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.azurewebsites.net
DB_CONNECTION=mysql
DB_HOST=your-mysql-host
DB_PORT=3306
DB_DATABASE=your-database
DB_USERNAME=your-username
DB_PASSWORD=your-password
DB_SSLMODE=required
DB_SSLCERT=/home/site/wwwroot/ssl/combined-ca-certificates.pem
```

## Deployment Pipeline

The solution works with standard GitHub Actions deployment to Azure App Service. The intelligent startup script handles all configuration automatically.

## Notes

- This solution automatically adapts to different Azure container configurations
- No manual intervention required after initial setup
- Provides comprehensive logging for troubleshooting
- Supports both IPv4 and IPv6 environments
- Gracefully handles PHP-FPM connectivity variations

---

**Success Indicators:**
- Laravel landing page loads correctly on "/" route
- All application routes work properly
- No 502 Bad Gateway errors
- Database connectivity with SSL works
- Static assets load correctly

This solution has been tested and verified to work across different Azure App Service configurations and PHP-FPM setups.
