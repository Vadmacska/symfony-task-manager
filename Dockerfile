FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git zip unzip curl libicu-dev libonig-dev libzip-dev libpq-dev libxml2-dev \
    && docker-php-ext-install intl pdo pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY .docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Włączenie mod_rewrite (potrzebne dla Symfony routes)
RUN a2enmod rewrite

WORKDIR /var/www/html
