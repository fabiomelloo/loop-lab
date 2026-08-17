#!/bin/sh
set -eu

database_path="${DB_DATABASE:-/var/data/database.sqlite}"

if [ "${DB_CONNECTION:-sqlite}" = "sqlite" ]; then
    mkdir -p "$(dirname "$database_path")"
    touch "$database_path"
    chown www-data:www-data "$database_path"
fi

php artisan package:discover --ansi
php artisan migrate --force
php artisan db:seed --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

exec "$@"
