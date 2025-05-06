#!/bin/bash

# Käivita Laravel server taustal
php artisan serve --host=0.0.0.0 --port=8000 &

# Oota kuni laravel.log tekib
while [ ! -f storage/logs/laravel.log ]; do
  sleep 1
done

# Kuvame logifaili jooksvalt
tail -f storage/logs/laravel.log
