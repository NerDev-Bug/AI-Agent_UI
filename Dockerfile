FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    zip unzip git curl nodejs npm libpq-dev \
    && docker-php-ext-install pdo pdo_mysql

WORKDIR /app

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy project files
COPY . .

# Create .env from Railway env vars
RUN cp .env.example .env || true

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Frontend build
RUN npm install && npm run build

# Cache Laravel stuff
RUN php artisan key:generate || true
RUN php artisan config:cache || true
RUN php artisan route:cache || true
RUN php artisan view:cache || true

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose Railway port
EXPOSE 8080

# Start using Railway PORT
CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"]
