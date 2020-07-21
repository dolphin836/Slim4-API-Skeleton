<?php

namespace Dolphin\Ting\Http\Model;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Psr\Container\ContainerInterface as Container;
use Exception;

class Model
{
    /** @var EntityManager */
    protected $entityManager;

    function __construct(Container $container)
    {
        $this->entityManager = $container->get('EntityManager');
    }

    /**
     * 保存单条记录
     *
     * @param  $entity
     *
     * @throws ORMInvalidArgumentException
     * @throws ORMException
     *
     * @return string
     *
     * @author 王海兵
     * @create 2019-10-18 18:01:38
     */
    public function saveOne ($entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function isHas ($entity, $data = [])
    {
        $count = $this->entityManager->getRepository($entity)->count($data);

        return (boolean) $count;
    }

    public function getOne ($entity, $data)
    {
       return $this->entityManager->getRepository($entity)->findOneBy($data);
    }

    public function getMore ($entity, $data)
    {
        return $this->entityManager->getRepository($entity)->findBy($data);
    }

    public function removeOne ($entity)
    {
        try {
            $this->entityManager->remove($entity);
            $this->entityManager->flush();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}