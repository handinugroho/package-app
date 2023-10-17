<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Package Services

### Requirements

1. PHP 7.4.x
2. MySQL 8.0.x
3. Composer installed

### How to run on local machine:

1. Create user in MySQL with `username = root` and empty password
2. Create new database in mysql called `package`
3. Run `composer install`
4. Create a new file name `.env` based on the `.env.example` file
5. Run `php artisan key:generate`
6. Run `php artisan migrate` to run migration
7. Run `php artisan db:seed` to run default seeder
8. Run `php artisan server` and the server will listen on http://127.0.0.1:8000
