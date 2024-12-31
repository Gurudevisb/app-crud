# Use official PHP image with Apache
FROM php:8.2-apache

# Set the working directory inside the container
WORKDIR /var/www/app-crud

# Install necessary system dependencies and PHP extensions for Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libxml2-dev \
    zip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Enable Apache mod_rewrite (important for Laravel)
RUN a2enmod rewrite

# Install Composer (Laravel dependency manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the Laravel project files into the container
COPY . /var/www/app-crud

# Set the correct permissions for the Laravel directory
RUN chown -R www-data:www-data /var/www/app-crud
RUN chmod -R 775 /var/www/app-crud
RUN chown -R www-data:www-data /var/www/app-crud/storage /var/www/app-crud/bootstrap/cache
RUN chmod -R 775 /var/www/app-crud/storage /var/www/app-crud/bootstrap/cache

# Copy the .env.example file to .env if .env doesn't exist
RUN [ -f /var/www/app-crud/.env ] || cp /var/www/app-crud/.env.example /var/www/app-crud/.env

# Run Composer to install Laravel dependencies
RUN COMPOSER_MEMORY_LIMIT=-1 composer install --no-dev --optimize-autoloader

# Ensure the default virtual host listens on port 80 and points to the Laravel public directory
RUN sed -i 's|/var/www/html|/var/www/app-crud/public|' /etc/apache2/sites-available/000-default.conf

# Expose port 80 (standard HTTP port)
EXPOSE 80

# Start the container
CMD ["apache2-foreground"]
