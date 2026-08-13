#!/usr/bin/env bash
set -euo pipefail

if [ -f composer.lock ]; then
  composer install --no-interaction --prefer-dist --no-progress --no-ansi
fi

if [ -f package.json ]; then
  npm install --no-fund --no-audit
  npm run build
fi

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

php -d variables_order=EGPCS artisan serve --host=0.0.0.0 --port="${PORT:-8080}"
