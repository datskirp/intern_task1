# Iteration1: Basic API crud app developed using MVC model

The application was created for educational purpose. The app allows to add users to the database, update and show user's information,
delete user, view the list of all users.
Users' data is stored in MySQL database 'app_db'. The table 'users' has 5 columns:
- id (PK)
- email
- name
- gender
- status

MVC model was implemented in OOP.

## Rest API Docs

### Show All

Returns json data of all users in the database

* **URL**

  /api/v1/users

* **Method:**

  `GET`

* **Data Params**

  None

### Show user

Returns json data about a single user.

* **URL**

  /api/v1/user/:id

* **Method:**

  `GET`

*  **URL Params**

   *Required:*

   `id=[integer]`

* **Data Params**

  None

### Create user

Creates user in a database. Id field is created automatically

* **URL**

  /api/v1/users

* **Method:**

  `POST`

*  **Data Params**

JSON

`{
"email": "value",
"name": "value",
"gender": "male|female",
"status": "active|inactive"}`

### Update user

Updates user in a database. Id field is created automatically

* **URL**

  /api/v1/user/:id

* **Method:**

  `PUT`

*  **URL Params**

   *Required:*

   `id=[integer]`

*  **Data Params**

JSON

`{
"email": "value",
"name": "value",
"gender": "male|female",
"status": "active|inactive"}`

### Delete user

Deletes user from the database.

* **URL**

  /api/v1/user/:id

* **Method:**

  `DELETE`

*  **URL Params**

   *Required:*

   `id=[integer]`

* **Data Params**

  None


## Installation using Docker

Make sure you have docker installed. Make sure docker and docker compose commands are available in command line. 
To see how you can install docker [click here](https://docs.docker.com/get-docker/).
Containers that will be installed: php-fpm, nginx, mysql, phpmyadmin.

Download the repository with git clone:

```#git clone -b iteration1 https://github.com/datskirp/intern_task1/```

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
