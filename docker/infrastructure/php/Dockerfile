FROM php:8.3-fpm

# Install dependencies and extensions
RUN apt-get update && apt-get install -y \
    openssl \
    git \
    unzip \
    libzip-dev \
    zip \
    libpng-dev \
    zlib1g-dev \
    libicu-dev \
    curl

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
&& composer --version

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql zip gd intl bcmath

# Install Node.js and npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs && \
    npm --version && node --version

# Copy php.ini
COPY php.ini /usr/local/etc/php/

# Catalog
WORKDIR /var/www/src

# Expose port dla PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]
