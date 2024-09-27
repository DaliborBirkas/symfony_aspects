# Start from PHP 8.3-fpm base image
FROM php:8.3-fpm

# Update and install necessary packages
RUN apt-get update && apt-get install -y \
    zlib1g-dev g++ git libicu-dev zip libzip-dev libpng-dev \
    && docker-php-ext-install intl opcache pdo pdo_mysql gd \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

# Install Node.js and npm
RUN apt-get install -y curl gnupg \
    && curl -fsSL https://deb.nodesource.com/setup_16.x | bash - \
    && apt-get install -y nodejs

# Verify installations
RUN node -v
RUN npm -v

# Set working directory
WORKDIR /var/www/project

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash

# Ensure permissions are correctly set
RUN chown -R www-data:www-data /var/www/project


# Start PHP-FPM server
CMD ["php-fpm"]
