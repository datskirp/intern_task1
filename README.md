# Task 1. Iteration5: Basic catalog App

The application was created for educational purpose. The App displays catalog of different products. A user
can add any product to a cart, go to cart, add some additional services specific to each product and get total price 
calculated. The cart was developed for guests and authenticated users. The cart allows a user to delete products, as well as services. 


#### MySQL database tables:
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


* products
  * id
  * name
  * manufacturer
  * release
  * cost
  * category


* services
  * id
  * type
  * cost
  * deadline
  * category


* cart
  * id
  * user_id
  * cart

#### Libraries loaded with Composer:
* twig/twig
* php-di/php-di
* ext-fileinfo

## Installation using Docker

Make sure you have docker installed. Make sure docker and docker compose commands are available in command line.
To see how you can install docker [click here](https://docs.docker.com/get-docker/).
Containers that will be installed: php-fpm, nginx, mysql, phpmyadmin.

Download the repository with git clone:

```#git clone -b iter5 https://github.com/datskirp/intern_task1/```

Go to the downloaded repository:

```#cd intern_task1```

Create 'dbdata' directory which will be used as shared volume with mysql docker container:

```#mkdir dbdata```

Run docker compose to build and start the containers:

```#docker compose up -d```

To stop and remove the containers:

```#docker compose down```


#### Open in browser (after containers are started up):
http://127.0.0.1:8080

http://127.0.0.1:8080/cart

http://127.0.0.1:8080/register

http://127.0.0.1:8080/login


#### PhpMyAdmin
http://127.0.0.1:8081
