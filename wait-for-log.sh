#!/bin/bash

# Käivita cache käsud alles siis, kui keskkonnamuutujad (nt APP_KEY) on olemas
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Käivita Laravel server taustal
php artisan serve --host=0.0.0.0 --port=8000 &

# Oota kuni laravel.log tekib
while [ ! -f storage/logs/laravel.log ]; do
  sleep 1
done

# Kuvame logifaili jooksvalt
tail -f storage/logs/laravel.log
