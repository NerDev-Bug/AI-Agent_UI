FROM php:8.2-fpm

# System deps
RUN apt-get update && apt-get install -y \
    zip unzip git curl nodejs npm

WORKDIR /app

# Copy everything
COPY . .

# Install composer dependencies
RUN composer install --no-dev --optimize-autoloader

# Laravel optimizations
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Install JS deps + build assets
RUN npm install && npm run build

# Permissions
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
