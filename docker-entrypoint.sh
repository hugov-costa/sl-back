#!/bin/bash

if [ ! -f .env ]; then
    cp .env.example .env
fi

if [ ! -d vendor ]; then
    composer install --no-interaction --prefer-dist --optimize-autoloader 2>/dev/null || true
fi

if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "base64:" ]; then
    php artisan key:generate
fi

RETRIES=0
MAX_RETRIES=30
while [ $RETRIES -lt $MAX_RETRIES ]; do
    if timeout 5 sqlcmd -S mssql -U sa -P "Softline@123" -C -Q "SELECT 1" > /dev/null 2>&1; then
        break
    fi
    RETRIES=$((RETRIES + 1))
    sleep 1
done

if [ $RETRIES -eq $MAX_RETRIES ]; then
    echo "Failed to connect to database" >&2
    exit 1
fi

sqlcmd -S mssql -U sa -P "Softline@123" -C -Q "IF DB_ID('softline') IS NULL CREATE DATABASE softline;" || true

timeout 60 php artisan migrate --force 2>&1 || true

exec php -S 0.0.0.0:8000 -t public
