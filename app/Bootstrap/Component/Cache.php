<?php

namespace Dolphin\Ting\Bootstrap\Component;

use DI\Container;
use Redis;

class Cache implements ComponentInterface
{
    /**
     * Redis register.
     *
     * @param Container $container
     */
    public static function register (Container $container)
    {
        $container->set('Cache', function () use ($container) {
            // 日志配置
            $config = $container->get('Config')['cache'];

            $cache  = new Redis();
            $cache->connect($config['host'], $config['port']);

            return $cache;
        });
    }
}