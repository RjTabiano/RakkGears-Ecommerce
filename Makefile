# Project Variables
COMPOSER=composer
NPM=npm
PHP=php
ARTISAN=$(PHP) artisan
DOCKER_COMPOSE=docker compose

# Default target
.DEFAULT_GOAL := help

## One-command local setup and server
server: setup ## Install deps, run migrations, build assets, then start the Laravel dev server
	@echo "🚀 Starting Laravel server..."
	$(ARTISAN) serve

## Install all dependencies and set up Laravel
setup: check-env install-deps key-generate migrate build-assets storage-link ## Prepare the Laravel app
	@echo "✅ Setup complete!"

## Ensure .env exists
check-env:
	@if [ ! -f .env ]; then \
		echo "⚠️  No Laravel .env file found. Creating one from .env.example..."; \
		cp .env.example .env; \
		echo "✅ Laravel .env file created. Please update it if needed."; \
	fi

## Install Composer and NPM dependencies
install-deps:
	@echo "📦 Installing Composer dependencies..."
	$(COMPOSER) install
	@echo "📦 Installing NPM dependencies..."
	$(NPM) install

## Generate app key if not set
key-generate:
	@echo "🔑 Ensuring APP_KEY is set..."
	$(ARTISAN) key:generate

## Run database migrations
migrate:
	@echo "🗃️ Running migrations..."
	$(ARTISAN) migrate

## Build frontend assets
build-assets:
	@echo "📦 Building assets..."
	$(NPM) run build

## Create storage symlink
storage-link:
	@echo "🔗 Creating storage symlink (if needed)..."
	-$(ARTISAN) storage:link

## Clean Laravel cache
clean:
	@echo "🧹 Cleaning Laravel cache..."
	$(ARTISAN) cache:clear
	$(ARTISAN) config:clear
	$(ARTISAN) view:clear
	$(ARTISAN) route:clear

## Start the Dockerized dev stack
docker-up: ## Build and start containers in the background
	$(DOCKER_COMPOSE) up -d --build

## Stop and remove containers, networks, and volumes
docker-down: ## Stop and remove containers, networks, and volumes
	$(DOCKER_COMPOSE) down -v

## Follow app logs
docker-logs: ## Tail application logs
	$(DOCKER_COMPOSE) logs -f app | cat

## Run an artisan command inside the app container, e.g.: make docker-artisan cmd="migrate --seed"
docker-artisan: ## Run Artisan in the app container
	$(DOCKER_COMPOSE) exec -T app php artisan $(cmd)

## Display this help message
help:
	@echo "📌 Available commands:"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'