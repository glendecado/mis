# Use official PHP image
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

# Set working directory
WORKDIR /var/www

# Copy files
COPY . .

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev

# Build frontend (if using Vite)
RUN npm install && npm run build

# Permissions
RUN chown -R www-data:www-data /var/www/storage

# Expose ports
EXPOSE 8000  # HTTP
EXPOSE 8080  # Reverb WebSocket

# Start both Laravel & Reverb
CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=8000 & php artisan reverb:start --host=0.0.0.0 --port=8080"]
