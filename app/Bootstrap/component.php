<?php

use DI\Container;

return function (Container $container) {
    // 注册组件
    $appConfig = require CONFPATH . 'app.php';
    // Config
    $container->set('Config', function () use ($appConfig) {
        return [
            'app'      => $appConfig,
            'log'      => require CONFPATH . 'log.php',
            'database' => require CONFPATH . 'database.php',
            'cache'    => require CONFPATH . 'cache.php',
            'queue'    => require CONFPATH . 'queue.php',
            'mail'     => require CONFPATH . 'mail.php'
        ];
    });
    // 启用的组件
    $enableComponent = $appConfig['component'];
    // 注册组件
    foreach ($enableComponent as $componentClassName) {
        call_user_func([$componentClassName, 'register'], $container);
    }
};
