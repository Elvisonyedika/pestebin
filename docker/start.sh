#!/bin/bash

echo "---------------- INSTALLING DEPENDENCIES -------------"
composer install --no-interaction
composer dump-autoload -o --no-interaction

chmod -R 777 storage
chmod -R 777 /var/www/storage/framework/cache
chmod -R 777 /var/www/storage/framework/views

echo "---------------- MIGRATING DATABASE -------------"
php artisan config:clear
php artisan config:cache
php artisan migrate --force

echo "---------------- RUNNING DEBUG MODE -------------"
composer require darkaonline/l5-swagger
php artisan l5-swagger:generate
php artisan serve --host=0.0.0.0 --port=8080