# Stage 1: Base PHP image
FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    git \
    unzip \
    libzip-dev \
    postgresql-dev \
    supervisor \
    # Required for pcntl and sockets
    $PHPIZE_DEPS \
    && docker-php-ext-install zip pdo pdo_mysql pdo_pgsql pcntl sockets \
    && pecl install swoole \
    && docker-php-ext-enable swoole

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set up application
WORKDIR /var/www
COPY . .

# Install PHP dependencies (no dev packages)
RUN composer install --optimize-autoloader --no-dev \
    && php artisan optimize:clear \
    && chown -R www-data:www-data storage bootstrap/cache

# Configure Supervisor for multiple processes
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Health check for Render
HEALTHCHECK --interval=30s --timeout=10s \
    CMD curl -f http://localhost:8000 || exit 1

# Runtime configuration
EXPOSE 8000 8080
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
