<?php

namespace Dolphin\Tan\Controller;

use Psr\Container\ContainerInterface as ContainerInterface;

use Dolphin\Tan\Librarie\Weixin as Lib_weixin;
use Dolphin\Tan\Model\User as Model_user;

/** 
* 简单的类介绍
*  
* @category Controller
* @package  Home
* @author   dolphin.wang <416509859@qq.com>
* @license  MIT https://mit-license.org 
* @link     https://github.com/dolphin836/Slim-Skeleton-MVC
* @since    2017-05-18
**/

class Home extends Base
{
    /**
    * 构造函数
    *
    * @param interface $app 框架
    *
    * @return void
    **/
    function __construct(ContainerInterface $app)
    {
        parent::__construct($app);
    }
    
    /**
    * 函数说明
    *
    * @param object $request  请求
    * @param object $response 响应
    * @param array  $args     参数
    *
    * @return object
    **/
    public function index($request, $response, $args)
    {   
        // 设置页面的基本信息
        $this->data['title']       = 'Slim App';
        $this->data['keywords']    = 'Slim';
        $this->data['description'] = 'Slim-Skeleton-MVC 是基于 Slim Framework 的脚手架。'; 
        // 引入额外的页面资源
        $this->data['css'][]       = 'dist/css/app.css';

        return $this->app->view->render('home', ['data' => $this->data]);
    }

    /**
    * 如果你想要输出 JSON 格式的数据，可以参考这个例子
    *
    * @param object $request  请求
    * @param object $response 响应
    * @param array  $args     参数
    *
    * @return object
    **/
    public function view($request, $response, $args)
    {
        $json             = array();
        // Model
        $model_user       = new Model_user();
        $user             = $model_user->user($args['id']);

        if ($user) {
            $json['code'] = 0;
            $json['note'] = 'Success.';
            $json['data'] = $user;
            $json['help'] = 'http://api.app.com';
        } else {
            $json['code'] = 1;
            $json['note'] = 'No User By ID ' . $args['id'];
            $json['help'] = 'http://api.app.com';
        }
        // Log
        $this->lib_log->write($json);

        return $response->withStatus(200)
            ->withHeader("Content-Type", "application/json")
            ->write(json_encode($json));

    }
}


