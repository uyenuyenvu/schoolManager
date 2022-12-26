<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel
1. create file .env in root, copy content from .env.example to .env . config in env:
   DB_CONNECTION=mysql
    <br>
   DB_HOST=127.0.0.1
   <br>DB_DATABASE=vnuaJob
   <br>DB_USERNAME=root
   <br>DB_PASSWORD=
   <br>DB_PORT=3306
2. create database with name vnuaJob
3. run commands:
   <br>composer install
   <br>php artisan key:generate
   <br>php artisan migrate
   <br>npm install
   <br>npm run dev
   <br>php artisan db:seed --class=UserTableSeeder
   <br>php artisan db:seed --class=StudentTableSeeder
   <br>php artisan db:seed --class=TeacherTableSeeder
   <br>php artisan cache:clear
   <br>php artisan config:clear
   <br>php artisan config:cache
4. run project
    php artisan ser <br>
   open link: http://127.0.0.1:8000<br>
    user: admin@gmail.com <br>
    password: 12345678


