# Stage 1: Frontend build (optional - remove if building assets locally)
FROM node:20 as frontend

WORKDIR /app
COPY package.json package-lock.json vite.config.js ./
COPY resources ./resources
RUN npm ci --silent && npm run build

# Stage 2: PHP backend
FROM php:8.2-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpq-dev \
    supervisor \
    && docker-php-ext-install zip pdo pdo_mysql pcntl \
    && pecl install swoole && docker-php-ext-enable swoole

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set up application
WORKDIR /var/www
COPY . .
COPY --from=frontend /app/public/build ./public/build

# Production optimizations
RUN composer install --optimize-autoloader --no-dev \
    && php artisan optimize:clear \
    && chown -R www-data:www-data storage bootstrap/cache

# Configure Supervisor
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Health check for Render
HEALTHCHECK --interval=30s --timeout=10s --start-period=5s \
    CMD curl -f http://localhost:8000 || exit 1

# Start services
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
