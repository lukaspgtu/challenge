# Get started

After cloning the repository, follow these steps:

## 1 - Install project dependencies

`composer install`

## 2 - Create the database (MySQL)

`CREATE SCHEMA challenge;`

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

# Description

- An API (Post) was created http://localhost:8000/api/contact to send the data file that will be processed. The payload is just a file attribute of type File.

![image](https://user-images.githubusercontent.com/25958351/162434173-d036f792-0e39-4ae4-98f0-7bb24632409c.png)

- Or if you prefer, you can access http://localhost:8000 in your browser, to send the file through the application frontend.

![image](https://user-images.githubusercontent.com/25958351/162443520-2ff8ae33-b043-4d4f-a401-94db6ab81faa.png)