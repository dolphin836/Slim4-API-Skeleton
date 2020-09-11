<?php

namespace Dolphin\Ting\Http\Controller;

use DI\DependencyException;
use DI\NotFoundException;
use Doctrine\ORM\EntityManager;
use DI\Container;

class Controller
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param  Container           $container
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function __construct(Container $container)
    {
        $this->container     = $container;
        // Doctrine ORM
        $this->entityManager = $container->get('EntityManager');
    }

    /**
     * 开启事务
     */
    protected function beginTransaction ()
    {
        $this->entityManager->beginTransaction();
    }

    /**
     * 提交事务
     */
    protected function commitTransaction ()
    {
        $this->entityManager->commit();
    }

    /**
     * 回滚事务
     */
    protected function rollbackTransaction ()
    {
        $this->entityManager->rollback();
    }
}