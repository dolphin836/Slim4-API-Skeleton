<?php

return [
    'host' => getenv("REDIS_HOST") ? : '127.0.0.1',
    'port' => getenv("REDIS_PORT") ? : '6379',
];