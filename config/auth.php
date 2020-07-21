<?php

return [
    'secret'     => getenv('AUTH_SECRET')      ? getenv('AUTH_SECRET')      : '',
    'expireTime' => getenv('AUTH_EXPIRE_TIME') ? getenv('AUTH_EXPIRE_TIME') : 3600,
    'unAuth'     => [ // 不需要鉴权的路由
        '/signin',
        '/signup',
        '/password/generator',
        '/confirm'
    ]
];