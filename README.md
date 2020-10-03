## Battle Simulator made in Laravel

You have to have Composer installed to run the project.

After cloning the repository create a MySQL database and set up the 
connection in the .env file like in any other Laravel project. 

Go to the project folder and run the following commands in the terminal:

- composer install
- php artisan migrate --seed
- php artisan serve

Go to http://127.0.0.1:8000/, there you can create a new game (battle), and from there you can go the individual games.  

php 7.3.6, Laravel 7.x