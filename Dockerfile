# Base image
FROM php:8.1-apache

# Set working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && \
    apt-get install -y \
    git \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libjpeg-dev \
    libfreetype6-dev

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Enable Apache mod_rewrite and mod_headers
RUN a2enmod rewrite headers

# Copy application files
COPY . .

# Replace .env.example with .env
RUN cp .env.example .env

# Set file permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install application dependencies
RUN composer install --no-interaction --no-scripts --no-autoloader

# Generate the optimized autoloader
RUN composer dump-autoload --optimize --classmap-authoritative

# Generate the application key
RUN php artisan key:generate

# Configure Apache
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Expose port 80
EXPOSE 80

# Start the Apache server
CMD ["apache2-foreground"]
