# Use official PHP image with Apache
FROM php:8.2-apache

# Set the working directory inside the container
#WORKDIR /var/www/html
WORKDIR C:/xampp/htdocs/
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
COPY . C:/xampp/htdocs/

# Set the correct permissions for the Laravel directory
RUN chown -R www-data:www-data C:/xampp/htdocs/
RUN chmod -R 775 C:/xampp/htdocs/
RUN chown -R www-data:www-data C:/xampp/htdocs/ storage C:/xampp/htdocs/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copy the .env.example file to .env if .env doesn't exist
RUN [ -f C:/xampp/htdocs/.env ] || cp C:/xampp/htdocs/.env.example C:/xampp/htdocs/.env

# Run Composer to install Laravel dependencies
RUN COMPOSER_MEMORY_LIMIT=-1 composer install --no-dev --optimize-autoloader

# Configure Apache to listen on port 10000
RUN echo "Listen 10000" >> /etc/apache2/ports.conf
RUN cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/10000-default.conf
RUN sed -i 's/<VirtualHost \*:80>/<VirtualHost *:10000>/' /etc/apache2/sites-available/10000-default.conf
RUN a2ensite 10000-default.conf

# Expose port 10000
EXPOSE 10000

# Start the container
CMD ["apache2-foreground"]
