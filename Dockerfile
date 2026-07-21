FROM node:20-slim AS assets
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git curl zip unzip libpq-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql mbstring zip xml bcmath \
    && a2enmod rewrite

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf
RUN sed -ri -e "s!/var/www/!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .
COPY --from=assets /app/public/build ./public/build

RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 80

CMD php artisan config:clear \
    && php artisan migrate --force \
    && php artisan storage:link || true \
    && apache2-foreground
