<?php

namespace Dolphin\Tan\Model;

/** 
* 简单的类介绍
*  
* @category Model
* @package  User
* @author   dolphin.wang <416509859@qq.com>
* @license  MIT https://mit-license.org 
* @link     https://github.com/dolphin836/Slim-Skeleton-MVC
* @since    2017-05-18
**/
class User extends Base
{
    /**
    * 构造函数
    *
    * @param int $id 用户编号
    *
    * @return array
    **/
    public function user($id = 0)
    {
        $user = $this->db->get('user', ['uuid', 'nickname', 'telephone', 'register_time'], ['id[=]' => $id]);

        return $user;
    }
}

