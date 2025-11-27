#!/bin/bash

set -e

echo "Checking application setup..."
composer install

echo "Permission set up..."
chmod a+x ./docker-data/scripts/mkrwusrgrp.sh
./docker-data/scripts/mkrwusrgrp.sh -u www-data -g www-data -d ./storage
./docker-data/scripts/mkrwusrgrp.sh -u www-data -g www-data -d ./bootstrap/cache/
./docker-data/scripts/mkrwusrgrp.sh -u www-data -g www-data -d ./public
./docker-data/scripts/mkrwusrgrp.sh -u www-data -g www-data -d ./resources

if [ -f package.json ]; then
    echo "Build UI"
    npm install

    ./docker-data/scripts/mkrwusrgrp.sh -u www-data -g www-data -d ./node_modules

    npm run build
fi

source .env

APP_KEY_STATUS=$(php artisan tinker --execute="echo config('app.key') ? 'exists' : 'empty';" 2>/dev/null)

if [ "$APP_KEY_STATUS" = "empty" ] || [ -z "$APP_KEY_STATUS" ]; then
    echo "Key generation..."
    php artisan key:generate
fi

php artisan migrate

USER_EXISTS=$(php artisan tinker --execute="echo \App\Models\User::where('email', '${ADMIN_EMAIL}')->count();" 2>/dev/null || echo "0")

if [ "$USER_EXISTS" -eq 0 ]; then
    echo "Seed super user..."
    php artisan db:seed --class=PermissionsSeeder
fi

echo "Starting PHP-FPM..."
exec php-fpm
