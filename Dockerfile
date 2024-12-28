# Use official PHP image with Apache
FROM php:8.2-apache

# Set the working directory inside the container
WORKDIR /var/www/html

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
COPY . /var/www/html

# Set the correct permissions for storage and cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Run Composer to install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Run Laravel Artisan commands (optional)
RUN php artisan key:generate
RUN php artisan config:cache

# Expose port 80
# EXPOSE 80
EXPOSE 10000


# Start Apache server
CMD ["apache2-foreground"]


# Update Apache config to listen on port 10000
RUN echo "Listen 10000" >> /etc/apache2/ports.conf
RUN sed -i 's/80/10000/g' /etc/apache2/sites-available/000-default.conf
