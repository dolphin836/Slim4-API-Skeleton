<?php

namespace Dolphin\Tan\Model;

/** 
* 简单的类介绍
*  
* @category Model
* @package  Product
* @author   dolphin.wang <416509859@qq.com>
* @license  MIT https://mit-license.org 
* @link     https://github.com/dolphin836/Slim-Skeleton-MVC
* @since    2017-05-18
**/
class Product extends Base
{
    /**
    * 构造函数
    *
    * @param int $id 产品编号
    *
    * @return array
    **/
    public function product($id = 0)
    {
        $product = $this->db->get('product', ['id', 'name', 'image', 'price', 'abstract'], ['published[=]' => 1, 'id[=]' => $id]);

        return $product;
    }
}

