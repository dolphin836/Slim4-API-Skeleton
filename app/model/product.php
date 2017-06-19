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
    * @param int $id 用户编号
    *
    * @return array
    **/
    public function product($id = 0)
    {
        // $product = $this->db->get('product', ['name'], ['id[=]' => $id]);

        // 返回商品详情，你应从数据库中查询数据，这里仅仅是一个例子
        $product = array(
                  'id' => $id,
                'name' => '夹克衫',
            'abstract' => '正品行货，限时出售。'
        );

        return $product;
    }
}

