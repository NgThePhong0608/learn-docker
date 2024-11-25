# Use official PHP image with Apache
FROM php:8.2-apache

# Install necessary libraries for PHP extensions
RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    && apt-get clean

# Install PHP extensions
RUN docker-php-ext-install zip pdo pdo_mysql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set the working directory
WORKDIR /var/www/html

# Copy the Laravel project files to the container
COPY . /var/www/html

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Laravel dependencies using Composer
RUN composer install --no-dev --optimize-autoloader

# Fix ownership and permissions for Laravel files and directories
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache


COPY /docker/apache2/000-default.conf /etc/apache2/sites-available/000-default.conf

# Expose port 80 for Apache
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
