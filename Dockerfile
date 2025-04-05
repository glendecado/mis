FROM php:8.2-fpm

# Install PHP dependencies only
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpq-dev \
    && docker-php-ext-install zip pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

# Skip frontend build in Docker
RUN composer install --optimize-autoloader --no-dev \
    && chown -R www-data:www-data storage bootstrap/cache

CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=${PORT:-8000} & php artisan reverb:start --port=8080"]
