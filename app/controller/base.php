<?php

namespace Dolphin\Tan\Controller;

use Psr\Container\ContainerInterface as ContainerInterface;
use Dolphin\Tan\Librarie\Log as Log;


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
    protected $lib_log;
    protected $data;

    /**
    * 构造函数
    *
    * @param interface $ci 框架
    *
    * @return void
    **/
    function __construct(ContainerInterface $app)
    {
        $this->app     = $app;
        $this->lib_log = new Log();

        if (getenv('APP_ENV') == 'development') { // 开发模式
            $this->data['css'][]    = 'dist/css/weui.css';
            $this->data['script'][] = 'dist/js/weui.js';
        } else { // 生产环境
            $this->data['css'][]    = 'https://res.wx.qq.com/open/libs/weui/1.1.2/weui.min.css';
            $this->data['script'][] = 'https://res.wx.qq.com/open/libs/weuijs/1.1.1/weui.min.js';
        }
    }
}

