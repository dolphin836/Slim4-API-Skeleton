<?php

namespace Dolphin\Tan\Model;
use Medoo\Medoo;

/** 
* 简单的类介绍
*  
* @category Model
* @package  Base
* @author   dolphin.wang <416509859@qq.com>
* @license  MIT https://mit-license.org 
* @link     https://github.com/dolphin836/Slim-Skeleton-MVC
* @since    2017-05-18
**/
class Base
{
    protected $db;

    /**
    * 构造函数
    *
    * @return void
    **/
    function __construct()
    {
        $this->db = new Medoo(
            [
            'database_type' => 'mysql',
            'database_name' => getenv('DB_DATANAME'),
                   'server' => getenv('DB_SERVERER'),
                 'username' => getenv('DB_USERNAME'),
                 'password' => getenv('DB_PASSWORD'),
                  'charset' => 'utf8'
            ]
        );
    }
}

