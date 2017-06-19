<?php

namespace Dolphin\Tan\Controller;
use Psr\Container\ContainerInterface as ContainerInterface;
use Dolphin\Tan\Librarie\Weixin as Lib_weixin;
use Dolphin\Tan\Model\Product as Model_product;

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
    * 首页
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
        // 这是一个 Library 使用的例子
        $lib_weixin                = new Lib_weixin();
        $this->data['sign']        = $lib_weixin->sign($this->data);
        // 引入额外的页面资源，如果有整站共用的静态资源也可以直接在 Template 中引入
        $this->data['css'][]       = getenv('WEB_URL') . 'dist/css/app.css';
        $this->data['script'][]    = getenv('WEB_URL') . 'dist/js/app.js';

        $this->app->log->write('Home');

        return $this->app->view->render('home', ['data' => $this->data]);
    }

    /**
    * 产品详情页
    *
    * @param object $request  请求
    * @param object $response 响应
    * @param array  $args     参数
    *
    * @return object
    **/
    public function product($request, $response, $args)
    {
        // 设置页面的基本信息
        $this->data['title']       = '产品详情页 - ' . $args['id'];
        $this->data['keywords']    = '产品详情页';
        $this->data['description'] = '产品详情页。'; 
        // 产品信息
        $model_product             = new Model_product();
        $this->data['product']     = $model_product->product($args['id']);
        // 引入额外的页面资源，如果有整站共用的静态资源也可以直接在 Template 中引入
        $this->data['css'][]       = getenv('WEB_URL') . 'dist/css/app.css';
        $this->data['script'][]    = getenv('WEB_URL') . 'dist/js/app.js';

        $this->app->log->write('product - ' . $args['id']);

        return $this->app->view->render('product', ['data' => $this->data]);
    }
}


