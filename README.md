### RakkGears E-commerce

Modern Laravel-based e-commerce app for RAKK gears and peripherals. This repo contains the Laravel API, Blade views, assets, and a Makefile-driven workflow. Optional Docker support ensures consistent setup across devices.

### Tech stack
- **Backend**: Laravel (PHP 8.2)
- **Frontend**: Bootstrap, SCSS/CSS, JS
- **Database**: MySQL 8
- **Dev tooling**: Composer, Node.js, Makefile, Docker + Compose

### Prerequisites
- PHP 8.2+
- Composer 2+
- Node.js 18+ (20+ recommended)
- MySQL 8 (or use Docker-provided DB)
- Make (on Windows: `choco install make`)
- Optional: Docker Desktop (with Compose v2)

### Quick start (local, no Docker)
1) Create env file (auto if missing):
```bash
make server
```
2) Open: `http://127.0.0.1:8000`

Notes:
- If using XAMPP/MySQL locally, ensure `.env` contains:
```
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rakkgears
DB_USERNAME=root
DB_PASSWORD=
```
- The command installs Composer/NPM deps, generates app key, runs migrations, builds assets, and starts the dev server.

### Quick start (Docker)
Start the full stack (PHP app + MySQL):
```bash
make docker-up
```
Open: `http://localhost:8000`

Handy commands:
```bash
make docker-logs
make docker-artisan cmd="migrate --seed"
make docker-down
```

Docker details:
- App runs with `php artisan serve` on port 8000.
- MySQL runs internally (not exposed to host) to avoid conflicts with XAMPP.
- On first run, the container auto-installs deps, sets APP_KEY, syncs `.env` DB settings to the Docker DB, waits for MySQL, runs migrations, and builds assets.

### Makefile commands
```bash
make server          # Install deps, migrate, build assets, start Laravel server
make setup           # One-time setup (env, deps, key, migrate, build, storage link)
make clean           # Clear caches (config, route, view, app)
make docker-up       # Build and start containers in background
make docker-down     # Stop and remove containers and volumes
make docker-logs     # Tail app logs
make docker-artisan cmd="migrate --seed"  # Run Artisan inside the app container
```

### Environment configuration
The `.env` file is created from `.env.example` if missing. Key variables:
```
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1        # or 'db' when using Docker
DB_PORT=3306
DB_DATABASE=rakkgears
DB_USERNAME=root         # or 'laravel' when using Docker
DB_PASSWORD=             # or 'laravel' when using Docker
```

When using Docker, the entrypoint syncs the above DB_* to the container values:
```
DB_HOST=db
DB_DATABASE=rakkgears
DB_USERNAME=laravel
DB_PASSWORD=laravel
```

### Project structure (high level)
- `app/` Laravel application code (controllers, models, policies)
- `resources/views/` Blade templates
- `public/` Public assets and entry point
- `routes/` Route definitions
- `database/` Migrations, factories, seeders
- `docker/` Docker entrypoint script
- `Dockerfile`, `docker-compose.yml`, `.dockerignore`
- `Makefile`

### Common tasks
- Run migrations/seed locally:
```bash
php artisan migrate --seed
```
- Rebuild assets:
```bash
npm run build
```
- Storage symlink (already handled in setup):
```bash
php artisan storage:link
```

### Troubleshooting
- **Port 8000 in use**: Stop the process using 8000 or run `php artisan serve --port=8001` locally. In Docker, change the mapped port in `docker-compose.yml`.
- **MySQL conflicts with XAMPP**: Use Docker DB (default in Compose) or change local `.env` to point to your XAMPP instance.
- **Node/Composer missing**: Install Node.js and Composer or use Docker for a self-contained environment.
- **Windows make not found**: Install via Chocolatey: `choco install make`.
- **Docker Compose not found**: Ensure Docker Desktop is installed and use `docker compose` (v2). If you only have legacy `docker-compose`, let us know to adjust the Makefile.

### License
MIT
