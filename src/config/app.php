<?php

return [
    'name' => getenv("APP_NAME") ? getenv("APP_NAME") : 'Slim4-Skeleton',
    'url'  => getenv("APP_URL")  ? getenv("APP_URL")  : 'http://localhost',
    'env'  => getenv("APP_ENV")  ? getenv("APP_ENV")  : 'production',
    // 需要框架加载的组件，不需要的直接注释
    'component' => [
        Dolphin\Ting\Bootstrap\Component\Logger::class, // 日志
        Dolphin\Ting\Bootstrap\Component\EntityManager::class, // ORM
        Dolphin\Ting\Bootstrap\Component\Guzzle::class, // Guzzle Http Client
        Dolphin\Ting\Bootstrap\Component\Cache::class, // Cache
        Dolphin\Ting\Bootstrap\Component\Queue::class // 消息队列
    ]
];