<?php

namespace Dolphin\Ting\Bootstrap\Component;

use DI\Container;
use GuzzleHttp\Client;

/**
 * Http 请求
 * @package Dolphin\Ting\Bootstrap\Component
 * @author  http://docs.guzzlephp.org/en/stable/index.html
 */
class Guzzle implements ComponentInterface
{
    /**
     * Guzzle register.
     *
     * @param Container $container
     */
    public static function register (Container $container)
    {
        $container->set('Guzzle', function () use ($container) {
            return new Client();
        });
    }
}