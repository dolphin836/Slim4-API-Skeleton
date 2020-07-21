<?php

namespace Dolphin\Ting\Bootstrap\Component;
// 组件接口
use DI\Container;

interface ComponentInterface
{
    /**
     * 组件注册方法
     * @param  Container $container
     * @return mixed
     */
    public static function register (Container $container);
}
