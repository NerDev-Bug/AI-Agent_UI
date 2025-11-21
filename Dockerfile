FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    zip unzip git curl nodejs npm

WORKDIR /app

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Laravel optimizations
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Build frontend
RUN npm install && npm run build

# Permissions
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

# Railway exposes $PORT — use PHP built-in server correctly
CMD php -S 0.0.0.0:${PORT:-8000} -t public
