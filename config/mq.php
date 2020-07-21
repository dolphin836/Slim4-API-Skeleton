<?php

return [
    'host' => getenv('MQ_HOST') ? getenv('MQ_HOST') : 'localhost',
    'port' => getenv('MQ_PORT') ? getenv('MQ_PORT') : '5672',
    'user' => getenv('MQ_USER') ? getenv('MQ_USER') : 'guest',
    'pass' => getenv('MQ_PASS') ? getenv('MQ_PASS') : 'guest'
];