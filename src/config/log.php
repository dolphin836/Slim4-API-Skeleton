<?php

return [
    'name' => getenv('LOG_NAME') ? : 'Logger',
    'path' => getenv('LOG_PATH') ? : '/var/log'
];