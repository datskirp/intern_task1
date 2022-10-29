# Task 1.Iteration3: Basic App for user registration.

The application was created for educational purpose. Contains a web page with HTML form. Allows a  user to register and
submit user data to database. Features include: 
* client side email field validation
* server side validation
  * password to fit predefined rules
  * password and email confirm fields to match their origins
  * reload the page with invalid fields cleared
  * error messages below each field
  * success message if user was registered

#### MySQL database table:
* users
  * id
  * email
  * first_name
  * last_name
  * password
  * created_date

#### Libraries loaded with Composer:
* twig/twig
* php-di/php-di
* ext-fileinfo

## Installation using Docker

Make sure you have docker installed. Make sure docker and docker compose commands are available in command line.
To see how you can install docker [click here](https://docs.docker.com/get-docker/).
Containers that will be installed: php-fpm, nginx, mysql, phpmyadmin.

Download the repository with git clone:

```#git clone -b iter3 https://github.com/datskirp/intern_task1/```

Go to the downloaded repository:

```#cd intern_task1```

Create 'dbdata' directory which will be used as shared volume with mysql docker container:

```#mkdir dbdata```

Run docker compose to build and start the containers:

```#docker compose up -d```

To stop and remove the containers:

```#docker compose down```


#### Open in browser http://127.0.0.1:8080/register
