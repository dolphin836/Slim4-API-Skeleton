<?php

return [
    'name' => getenv('LOG_NAME') ? getenv('LOG_NAME') : 'Logger',
    'path' => getenv('LOG_PATH') ? getenv('LOG_PATH') : '/var/log'
];