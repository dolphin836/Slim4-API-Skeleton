<?php

namespace Dolphin\Tan\Controller;
use Dolphin\Tan\Librarie\Weixin as Weixin;
use Dolphin\Tan\Model\Product as Product;
use Psr\Container\ContainerInterface as ContainerInterface;

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
        $data         = array('name' => 'dolphin', 'sex' => 'M');

        // Librarie
        $lib_weixin   = new Weixin();
        $sign         = $lib_weixin->sign($data);
        $data['sign'] = $sign;

        // Resources
        $data['css'][]    = 'dist/css/home.css';
        $data['script'][] = 'dist/js/home.js';

        return $this->app->view->render('home', ['data' => $data]);
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
    public function view($request, $response, $args)
    {
        $json             = array();
        // Model
        $product_model    = new Product();
        $product          = $product_model->product($args['id']);

        if ($product) {
            $json['code'] = 0;
            $json['data'] = $product;
        } else {
            $json['code'] = 1;
            $json['note'] = 'No Product By ID ' . $args['id'];
            $json['help'] = 'http://api.app.com';
        }
        // Log
        $this->ci->log->write($json);

        return $response->withStatus(200)
            ->withHeader("Content-Type", "application/json")
            ->write(json_encode($json));

    }
}


