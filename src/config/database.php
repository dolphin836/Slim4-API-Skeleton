<?php

return [
    'driver'   => 'pdo_mysql',
    'host'     => getenv('DB_HOSTNAME') ? : 'localhost',
    'user'     => getenv('DB_USERNAME') ? : 'user',
    'password' => getenv('DB_PASSWORD') ? : '',
    'dbname'   => getenv('DB_DATANAME') ? : '',
    'charset'  => 'utf8'
];