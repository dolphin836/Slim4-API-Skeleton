<?php

return [
    'host'     => getenv('MAIL_HOST')     ? getenv('MAIL_HOST')     : '',
    'post'     => getenv('MAIL_PORT')     ? getenv('MAIL_PORT')     : '',
    'username' => getenv('MAIL_USERNAME') ? getenv('MAIL_USERNAME') : '',
    'password' => getenv('MAIL_PASSWORD') ? getenv('MAIL_PASSWORD') : ''
];