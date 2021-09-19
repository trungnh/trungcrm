# Compile assets (js, css)
    `docker-compose start compiler`

## Install & Setting EAV
```
composer require rinvex/laravel-attributes "4.1"
php artisan rinvex:publish:attributes
php artisan rinvex:migrate:attributes
```
