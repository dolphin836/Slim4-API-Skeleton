<?php

namespace Dolphin\Ting\Http\Service;

use Dolphin\Ting\Http\Constant\EntityConstant;
use Dolphin\Ting\Http\Entity\Category;
use Dolphin\Ting\Http\Exception\CategoryException;
use Dolphin\Ting\Http\Exception\CommonException;
use Dolphin\Ting\Http\Model\CategoryModel;
use Psr\Container\ContainerInterface as Container;

class CategoryService extends Service
{
    private $categoryModel;

    public function __construct (Container $container)
    {
        parent::__construct($container);

        $this->categoryModel = new CategoryModel($container);
    }

    public function getCategoryInfo (Category $category)
    {
        return [
            'category_id'      => $category->getId(),
            'name'             => $category->getName(),
            'order_number'     => $category->getOrderNumber(),
            'password_count'   => $category->getPasswordCount(),
            'last_update_time' => $category->getLastUpdateTime()->format('Y-m-d H:i:s')
        ];
    }

    public function getCategoryNameById ($categoryId)
    {
        /** @var Category $category */
        $category = $this->categoryModel->getOne(EntityConstant::Category, ['id' => $categoryId]);

        return empty($category) ? '' : $category->getName();
    }

    /**
     * @param  integer $categoryId
     * @param  integer $userId
     * @throws CategoryException
     * @throws CommonException
     * @return void
     */
    public function isUserCategory ($categoryId, $userId)
    {
        /** @var Category $category */
        $category = $this->categoryModel->getOne(EntityConstant::Category, ['id' => $categoryId]);

        if (empty($category)) {
            throw new CategoryException('CATEGORY_NON_EXIST');
        }

        if ($category->getUserId() !== $userId) {
            throw new CommonException('AUTH_ERROR');
        }
    }
}