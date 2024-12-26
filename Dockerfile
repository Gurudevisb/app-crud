# Use an official PHP runtime as the parent image
FROM php:8.1-fpm

# Install required PHP extensions and tools
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd pdo pdo_mysql && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug

# Install Composer (PHP package manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory in the container
WORKDIR /var/www

# Copy the entire project to the container
COPY . .

# Install PHP dependencies with Composer
RUN composer install --no-dev --optimize-autoloader

# Install Node.js and NPM for front-end (if you're using Laravel Mix or other tools)
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash - && \
    apt-get install -y nodejs && \
    npm install -g yarn

# Install front-end dependencies (if you have a package.json)
RUN yarn install

# Expose port 5000 to match the start script
EXPOSE 5000

# Run the PHP built-in server
CMD ["php", "-S", "0.0.0.0:5000", "-t", "public"]
