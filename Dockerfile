FROM php:8.2-fpm

# Install system dependencies
RUN apt update && apt install -y \
    unzip \
    curl \
    git \
    nodejs \
    npm \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev

# Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www