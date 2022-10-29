# Task 1.Iteration2: Basic App for uploading image and text files.

The application was created for educational purpose. The app allows to upload image and text files to a directory. Each
upload event is logged in a file, which is created daily.

## Installation using Docker

Make sure you have docker installed. Make sure docker and docker compose commands are available in command line.
To see how you can install docker [click here](https://docs.docker.com/get-docker/).
Containers that will be installed: php-fpm, nginx, mysql, phpmyadmin.

Download the repository with git clone:

```#git clone -b iter2 https://github.com/datskirp/intern_task1/```

Go to the downloaded repository:

```#cd intern_task1```

Create 'dbdata' directory which will be used as shared volume with mysql docker container:

```#mkdir dbdata```

Run docker compose to build and start the containers:

```#docker compose up -d```

To stop and remove the containers:

```#docker compose down```


#### Open in browser http://127.0.0.1:8080/upload
