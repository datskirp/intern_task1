<?php
//Data for PDO DSN (data source name). Had to use docker's container name instead of 'localhost'
return [
    'db' => [
        'host' => 'task1-db-1',
        'dbname' => 'app_db',
        'user' => 'db_user',
        'password' => '321',
    ]
];