FROM php:8.2-fpm

WORKDIR /var/www/html

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql zip mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy only composer files first
COPY composer.json composer.lock /var/www/html/

# Install PHP dependencies without running scripts
RUN composer install --no-dev --no-interaction --prefer-dist --no-scripts --no-autoloader

# Copy the rest of the application including already built assets
COPY . /var/www/html


# Fix Git ownership issue (safe.directory)
RUN git config --global --add safe.directory /var/www/html

# Optimize autoloader and run post-install scripts
RUN composer dump-autoload --optimize && \
    if [ -f artisan ]; then php artisan package:discover --ansi; fi

# Fix permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
# Set PHP-FPM to listen on all interfaces
RUN sed -i 's/listen = .*/listen = 0.0.0.0:9000/' /usr/local/etc/php-fpm.d/www.conf

EXPOSE 9000

CMD ["php-fpm"]
