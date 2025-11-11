# Base image
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libssl-dev \
    postgresql-client \
    libpq-dev \
    usbutils \
    udev \
    minicom \
    && docker-php-ext-install pdo_pgsql pdo_mysql mbstring exif pcntl bcmath gd zip sockets \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Copy default environment file (only if not exists)
RUN cp .env.example .env || true

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 9000 (PHP-FPM)
EXPOSE 9000

# Set default command
CMD ["php-fpm"]
