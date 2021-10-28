<?php

return [
    'host' => getenv('RABBITMQ_HOST') ? : 'localhost',
    'port' => getenv('RABBITMQ_PORT') ? : '5672',
    'user' => getenv('RABBITMQ_USER') ? : 'guest',
    'pass' => getenv('RABBITMQ_PASS') ? : 'guest'
];