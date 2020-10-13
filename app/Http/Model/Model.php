<?php

namespace Dolphin\Ting\Http\Model;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Psr\Container\ContainerInterface as Container;

class Model
{
    /** @var EntityManager */
    protected $entityManager;

    function __construct(Container $container)
    {
        $this->entityManager = $container->get('EntityManager');
    }

    /**
     * 保存实体
     *
     * @param  $entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @author wanghaibing
     * @date   2020/10/13 14:07
     */
    public function save ($entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    /**
     * 开启事务
     *
     * @author wanghaibing
     * @date   2020/10/13 13:57
     */
    public function beginTransaction ()
    {
        $this->entityManager->beginTransaction();
    }

    /**
     * 提交事务
     *
     * @author wanghaibing
     * @date   2020/10/13 13:57
     */
    public function commit ()
    {
        $this->entityManager->commit();
    }

    /**
     * 回滚事务
     *
     * @author wanghaibing
     * @date   2020/10/13 13:58
     */
    public function rollback ()
    {
        $this->entityManager->rollback();
    }
}