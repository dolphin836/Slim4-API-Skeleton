<?php

namespace Dolphin\Tan\Controller;
use Psr\Container\ContainerInterface as ContainerInterface;

/** 
* 简单的类介绍
*  
* @category Controller
* @package  Base
* @author   dolphin.wang <416509859@qq.com>
* @license  MIT https://mit-license.org 
* @link     https://github.com/dolphin836/Slim-Skeleton-MVC
* @since    2017-05-18
**/
class Base
{
    protected $app;

    /**
    * 构造函数
    *
    * @param interface $ci 框架
    *
    * @return void
    **/
    function __construct(ContainerInterface $app)
    {
        $this->app = $app;
    }
}

