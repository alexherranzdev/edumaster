FROM php:8.2-fpm

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y \
  git \
  unzip \
  curl \
  libpq-dev \
  libzip-dev \
  zip \
  && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip

# Copiar Composer desde otra imagen
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copiar archivos de la API
COPY . .

COPY .env.docker .env

# Instalar dependencias de PHP con Composer
RUN composer install --no-dev --optimize-autoloader

# Eliminar caché de Laravel y correr migraciones + seeders
RUN rm -rf bootstrap/cache/*


# Exponer puerto de PHP-FPM
EXPOSE 9000

# Iniciar Laravel con php-fpm
COPY docker-entrypoint.sh /docker-entrypoint.sh
RUN chmod +x /docker-entrypoint.sh
CMD ["./docker-entrypoint.sh"]