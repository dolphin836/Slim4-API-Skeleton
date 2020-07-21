<?php

return [
    'driver'   => 'pdo_mysql',
    'host'     => getenv('DB_HOSTNAME') ? getenv('DB_HOSTNAME') : 'localhost',
    'user'     => getenv('DB_USERNAME') ? getenv('DB_USERNAME') : 'root',
    'password' => getenv('DB_PASSWORD') ? getenv('DB_PASSWORD') : '',
    'dbname'   => getenv('DB_DATANAME') ? getenv('DB_DATANAME') : 'test',
    'charset'  => 'utf8'
];