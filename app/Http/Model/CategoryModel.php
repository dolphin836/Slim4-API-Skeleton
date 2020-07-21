<?php

namespace Dolphin\Ting\Http\Model;

use Dolphin\Ting\Http\Constant\EntityConstant;
use Dolphin\Ting\Http\Entity\Category;

class CategoryModel extends Model
{
    /**
     * 查询用户的分类
     * @param  int $userId
     * @return Category[]
     */
    public function getUserCategory ($userId)
    {
        return $this->entityManager->createQueryBuilder()
                                   ->select('c')
                                   ->from(EntityConstant::Category, 'c')
                                   ->where('c.user_id = :userId')
                                   ->setParameters(['userId' => $userId])
                                   ->orderBy('c.order_number', 'DESC')
                                   ->getQuery()
                                   ->getResult();
    }
}