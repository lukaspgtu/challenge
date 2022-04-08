# Get started

After cloning the repository, follow these steps:

## 1 - Install project dependencies

`composer install`

## 2 - Create the database (MySQL)

`CREATE SCHEMA `challenge`;`

## 3 - Set environment variables for database connection

`DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=challenge
DB_USERNAME=root
DB_PASSWORD=`

## 4 - Run the migrations

`php artisan migrate`

## 5 - Start the application

`php artisan serve`

## 6 - Start scheduling and queuing service

`php artisan schedule:work`
`php artisan queue:work`
