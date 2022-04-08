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

# About

- An API (Post) was created http://localhost:8000/api/contact to send the data file that will be processed. The payload is just a file attribute of type File.

![image](https://user-images.githubusercontent.com/25958351/162434173-d036f792-0e39-4ae4-98f0-7bb24632409c.png)

- Or if you prefer, you can access http://localhost:8000 in your browser, to send the file through the application frontend.

![image](https://user-images.githubusercontent.com/25958351/162443520-2ff8ae33-b043-4d4f-a401-94db6ab81faa.png)

# Considerations

- What if the source file suddenly becomes 500 times larger?
    - The file is divided into pieces to be processed in stages, regardless of size.

- Is the process easily deployed for an XML or CSV file with similar content?
    - Yes. As an example, a function was created that identifies the type of the file (json, xml or csv), and regardless of the type, the data will be extracted in an array.

    <br>

    <img src="https://user-images.githubusercontent.com/25958351/162449403-00533fbc-2267-47e1-9348-77c9cd209daf.png" width="600px">
    
- Suppose that only records need to be processed for which the credit card number contains three consecutive same digits, how would you handle that?
    
    <br>

    <img src="https://user-images.githubusercontent.com/25958351/162451937-c1dd2fe1-b221-4ecd-b149-e76a5bc86a3a.png" width="600px">
    
-  Note that there is no guarantee that there are no duplicate records in the source file (there are no guaranteed unique (combinations of) properties) - and all duplicates do need to be replicated 1-to-1 in the database.
    - For this, it was considered that the combination of email and account are unique, and if there is already a record with this combination, it will only be updated and not duplicated.


