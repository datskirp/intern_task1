# Task 1. Iteration4: Basic App for user registration and authentication

The application was created for educational purpose. Allows a  user to register, login and
access a restricted '/upload' page. Features include:
* client side email field validation
* server side validation
    * password to fit predefined rules
    * password and email confirm fields to match their origins
    * reload the page with invalid fields cleared
    * error messages below each field
    * success message if user was registered
* user authentication
  * provides access to restricted '/upload' page, if authorized
  * allows only 3 login attempts (attempts reset after some time)
  * blocks user by IP for customized time period after 3 failed attempts
  * blocked IP gets logged in the database
  * Remember me feature is implemented on Login page
    * Customized time period
    * randomly created two parts token (selector:validator(hashed))
    * client token stored in a cookie, server token - in a database
* file uploads validated for text and images only
* logging of files uploaded 

#### MySQL database table:
* users
    * id
    * email
    * firstname
    * lastname
    * password
    * created_date


* user_tokens
  * id
  * selector
  * validator
  * user_id
  * expiration


* login_block
  * id
  * ip
  * end_block
  * begin_attempts


* login_block_log
  * id
  * ip
  * email
  * start_block
  * end_block

#### Libraries loaded with Composer:
* twig/twig
* php-di/php-di
* ext-fileinfo

## Installation using Docker

Make sure you have docker installed. Make sure docker and docker compose commands are available in command line.
To see how you can install docker [click here](https://docs.docker.com/get-docker/).
Containers that will be installed: php-fpm, nginx, mysql, phpmyadmin.

Download the repository with git clone:

```#git clone -b iter4 https://github.com/datskirp/intern_task1/```

Go to the downloaded repository:

```#cd intern_task1```

Create 'dbdata' directory which will be used as shared volume with mysql docker container:

```#mkdir dbdata```

Run docker compose to build and start the containers:

```#docker compose up -d```

To stop and remove the containers:

```#docker compose down```


#### Open in browser (after containers are started up):
http://127.0.0.1:8080/register
http://127.0.0.1:8080/login
http://127.0.0.1:8080/upload

#### PhpMyAdmin
http://127.0.0.1:8081
