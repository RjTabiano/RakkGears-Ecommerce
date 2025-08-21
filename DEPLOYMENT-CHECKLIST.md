# Quick Deployment Checklist

## Pre-Deployment Setup

### 1. Laravel Application Structure ✅
- [ ] Routes defined in `routes/web.php`
- [ ] HomeController exists with home() method
- [ ] `public/.htaccess` contains Laravel rewrite rules
- [ ] Remove any root-level `.htaccess` files

### 2. Nginx Configuration Files ✅
- [ ] `nginx.conf` - Primary configuration pointing to `/public` directory
- [ ] `nginx-fallback.conf` - Upstream fallback configuration

### 3. Startup Script ✅
- [ ] `startup.sh` with executable permissions
- [ ] Intelligent PHP-FPM detection
- [ ] Automatic Laravel directory creation
- [ ] Dynamic nginx config selection

### 4. SSL Certificates (if using Azure MySQL) ✅
- [ ] DigiCert certificates downloaded
- [ ] Combined into `ssl/combined-ca-certificates.pem`
- [ ] Database config updated to use SSL

## Azure App Service Configuration

### 1. Basic Settings
- [ ] Runtime: PHP 8.1
- [ ] Operating System: Linux
- [ ] Startup Command: `/home/site/wwwroot/startup.sh`

### 2. Environment Variables
```bash
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app.azurewebsites.net
# ... database and other Laravel config
```

### 3. Deployment
- [ ] GitHub Actions pipeline configured
- [ ] Repository connected to Azure App Service
- [ ] Deploy from main branch

## Post-Deployment Verification

### 1. Application Loading
- [ ] "/" route shows landing page (not login/auth)
- [ ] No 502 Bad Gateway errors
- [ ] Static assets loading correctly

### 2. Routing
- [ ] All Laravel routes working
- [ ] Product pages accessible
- [ ] Admin routes functioning

### 3. Database
- [ ] Connection established
- [ ] SSL working (if configured)
- [ ] Migrations ran successfully

## Troubleshooting Quick Reference

| Issue | Check | Solution |
|-------|-------|----------|
| 502 Bad Gateway | PHP-FPM connectivity | Startup script auto-selects working config |
| Routes not working | nginx config | Use provided nginx.conf with try_files |
| Permission errors | Storage directories | Startup script creates with proper permissions |
| SSL connection fails | Certificate file | Use combined-ca-certificates.pem |

## Success Criteria ✅

When everything is working correctly, you should see:
- ✅ Laravel landing page on root URL
- ✅ All application routes functional
- ✅ Database connectivity working
- ✅ No nginx/PHP-FPM errors in logs
- ✅ Static assets loading properly

---

**Total Setup Time**: ~15 minutes after initial configuration
**Zero Manual Intervention**: Startup script handles all configuration automatically
**Cross-Environment Compatibility**: Works with different Azure container setups
