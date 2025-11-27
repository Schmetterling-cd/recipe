#!/bin/bash

set -e

echo "Checking application setup..."

# Если это новая установка (нет artisan файла)
if [ -f artisan ]; then
    composer install
fi

echo "Permission set up..."

chmod a+x ./docker-data/scripts/mkrwusrgrp.sh
./docker-data/scripts/mkrwusrgrp.sh -u www-data -g www-data -d ./storage
./docker-data/scripts/mkrwusrgrp.sh -u www-data -g www-data -d ./bootstrap/cache/
./docker-data/scripts/mkrwusrgrp.sh -u www-data -g www-data -d ./public
./docker-data/scripts/mkrwusrgrp.sh -u www-data -g www-data -d ./resources

if [ -f package.json ]; then
    ./docker-data/scripts/mkrwusrgrp.sh -u www-data -g www-data -d ./node_modules
    npm install
    npm run build
fi

echo "Starting PHP-FPM..."
exec php-fpm
