FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libsqlite3-dev \
    sqlite3 \
    npm \
    nodejs

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_sqlite mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy application code
COPY . /var/www

# Fix permissions (especially for logs and cache)
RUN mkdir -p /var/www/storage/logs \
    && mkdir -p /var/www/bootstrap/cache \
    && chown -R www-data:www-data /var/www \
    && chmod -R ug+rwx /var/www/storage \
    && chmod -R ug+rwx /var/www/bootstrap/cache

# Install backend and frontend dependencies
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# Create SQLite DB file if needed
RUN mkdir -p database && touch database/database.sqlite

# Cache Laravel configuration
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Expose port
EXPOSE 8000

# Start Laravel server AND wait for log file, then stream it
CMD php artisan serve --host=0.0.0.0 --port=8000 & \
    bash -c 'while [ ! -f storage/logs/laravel.log ]; do sleep 1; done; tail -f storage/logs/laravel.log'
