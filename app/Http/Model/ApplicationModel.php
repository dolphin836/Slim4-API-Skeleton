<?php

namespace Dolphin\Ting\Http\Model;

use Dolphin\Ting\Http\Constant\EntityConstant;
use Dolphin\Ting\Http\Entity\Application;

class ApplicationModel extends Model
{
    /**
     * 查询某个分类下所有的应用
     * @param  integer $categoryId
     * @return Application[]
     */
    public function getCategoryApplication ($categoryId)
    {
        return $this->entityManager->createQueryBuilder()
                                   ->select('a')
                                   ->from(EntityConstant::Application, 'a')
                                   ->where('a.category_id = :categoryId')
                                   ->setParameters(['categoryId' => $categoryId])
                                   ->orderBy('a.id', 'DESC')
                                   ->getQuery()
                                   ->getResult();
    }
}