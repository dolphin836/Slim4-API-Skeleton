<?php

namespace Dolphin\Tan\Librarie;

/** 
* 简单的类介绍
*  
* @category Librarie
* @package  Weixin
* @author   dolphin.wang <416509859@qq.com>
* @license  MIT https://mit-license.org 
* @link     https://github.com/dolphin836/Slim-Skeleton-MVC
* @since    2017-05-18
**/
class Weixin
{
    /**
    * 签名
    *
    * @param array $data 需要签名的数据
    *
    * @return string
    **/
    public function sign($data = array())
    {
        ksort($data);

        $str  = urldecode(http_build_query($data));

        return strtoupper(md5($str));
    }
}

