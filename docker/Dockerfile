FROM php:8.1-fpm

# Instalações básicas
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    zip \
    libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html