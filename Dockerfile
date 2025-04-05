# Stage 1: Build frontend
FROM node:18 as frontend

WORKDIR /app
COPY package.json vite.config.js /app/
COPY resources /app/resources
RUN npm install && npm run build

# Stage 2: Backend
FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install zip pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy app files
COPY . .
COPY --from=frontend /app/public/build /var/www/public/build

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev

# Reverb-specific setup
RUN php artisan reverb:install

# Permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Health check (required by Render)
HEALTHCHECK --interval=30s --timeout=30s --start-period=5s --retries=3 \
    CMD curl -f http://localhost:8000 || exit 1

# Start command (modified for Render)
CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=${PORT:-8000} & php artisan reverb:start --host=0.0.0.0 --port=8080"]
