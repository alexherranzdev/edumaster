FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
  git \
  unzip \
  curl \
  libpq-dev \
  libzip-dev \
  zip \
  && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip

COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]