#!/bin/sh
set -e

# Ejecutar migraciones y seeders
php artisan migrate --force
php artisan db:seed --force
php artisan config:clear
php artisan cache:clear
php artisan optimize

# Iniciar PHP-FPM
exec php-fpm