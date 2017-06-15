<?php

namespace Dolphin\Tan\Controller;

use Psr\Container\ContainerInterface as ContainerInterface;

use Firebase\JWT\JWT;

/** 
* 生成 JWT Token 示例
*  
* @category Controller
* @package  Token
* @author   dolphin.wang <416509859@qq.com>
* @license  MIT https://mit-license.org 
* @link     https://github.com/dolphin836/Slim-Skeleton-MVC
* @since    2017-05-18
**/

class Token extends Base
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
        $data = array(
            "iss" => "http://hbdx.cc/",
            "aud" => "http://m.hbdx.cc",
            "iat" => 1356999524,
            "nbf" => 1357000000
        );

        $token = JWT::encode($data, getenv("JWT_SECRET"));

        $json  = array('token' => $token);

        // setcookie("token", $token, time() + 7200);
        
        // 前台得到 Token 后，可以写入 cookie，或者 HTTP HEADER，配合 middleware 的设置来做
        return $response->withStatus(200)
            ->withHeader("Content-Type", "application/json")
            ->write(json_encode($json, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    }
}


