<?php

return [
    'host'     => getenv('MAIL_HOST')     ? : '',
    'post'     => getenv('MAIL_PORT')     ? : '',
    'username' => getenv('MAIL_USERNAME') ? : '',
    'password' => getenv('MAIL_PASSWORD') ? : ''
];