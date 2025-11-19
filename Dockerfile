FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN echo "alias ll='ls -lah'" >> /etc/bash.bashrc

# Change www-data UID/GID to match host user (1000)
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

WORKDIR /var/www/html

COPY . .

# Install dependencies
RUN composer install --no-interaction --optimize-autoloader && \
    php artisan key:generate || true

# Set correct permissions for Laravel writable directories
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
