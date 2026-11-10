# ==============================================================================
# Mimouna Bookstore - Laravel 11 Dockerfile (Ubuntu 24.04 LTS)
# ==============================================================================
FROM ubuntu:24.04

LABEL maintainer="Mimouna Bookstore"
LABEL description="Ubuntu 24.04 container for Mimouna Bookstore Laravel 11 application"

# Prevent interactive prompts during apt package installation
ENV DEBIAN_FRONTEND=noninteractive \
    TZ=UTC \
    COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_HOME=/tmp/composer

# Install system dependencies, PHP 8.3 CLI, and required Laravel PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    ca-certificates \
    curl \
    git \
    unzip \
    zip \
    sqlite3 \
    libsqlite3-dev \
    php8.3-cli \
    php8.3-common \
    php8.3-mysql \
    php8.3-sqlite3 \
    php8.3-mbstring \
    php8.3-xml \
    php8.3-curl \
    php8.3-zip \
    php8.3-bcmath \
    php8.3-intl \
    php8.3-gd \
    php8.3-opcache \
    php8.3-readline \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer from official Composer image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set application working directory
WORKDIR /var/www/html

# Copy Composer dependency manifests first to leverage Docker layer caching
COPY composer.json composer.lock ./

# Install PHP dependencies without running post-autoload scripts before app code is copied
RUN composer install \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts

# Copy the rest of the Laravel application files (filtered by .dockerignore)
COPY . .

# Ensure required Laravel storage, cache, and upload directories exist with proper permissions
RUN mkdir -p \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    public/uploads \
    && chmod -R 775 storage bootstrap/cache public/uploads \
    && composer dump-autoload --optimize --no-interaction

# Expose port 8000 for the Laravel application
EXPOSE 8000

# Prepare .env / APP_KEY if missing at runtime, then start the Laravel server on 0.0.0.0:8000
CMD ["sh", "-c", "if [ ! -f .env ] && [ -f .env.example ]; then cp .env.example .env; fi && if [ -f .env ] && ! grep -q '^APP_KEY=base64:' .env; then php artisan key:generate --force --no-interaction; fi && php artisan serve --host=0.0.0.0 --port=8000"]
