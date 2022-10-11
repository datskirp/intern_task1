# Task 1: Basic CRUD app developed using MVC model

The application was created for educational purpose. The app allows to add users to the database, update and show user's information,
delete user, view the list of all users.
Users' data is stored in MySQL database 'app_db'. The table 'users' has 5 columns:
- id (PK)
- email
- name
- gender
- status

MVC model was implemented in OOP.

## Installation using Docker

Make sure you have docker installed. Make sure docker and docker compose commands are available in command line. 
To see how you can install docker [click here](https://docs.docker.com/get-docker/).
Containers that will be installed: php-fpm, nginx, mysql, phpmyadmin.

Download the repository with git clone:

```#git clone https://github.com/datskirp/intern_task1/```

Go to the downloaded repository:

```#cd intern_task1```

Create 'dbdata' directory which will be used as shared volume with mysql docker container:

```#mkdir dbdata```

Run docker compose to build and start the containers:

```#docker compose up -d```

To stop and remove the containers:

```#docker compose down```


 #### Open in browser http://127.0.0.1:8080
 ###### PhpMyAdmin http://127.0.0.1:8081  user: db_user, password: 321
