<?php

namespace Dolphin\Ting\Http\Controller;

use DI\DependencyException;
use DI\NotFoundException;
use Doctrine\ORM\EntityManager;
use Dolphin\Ting\Bootstrap\Component\Queue;
use Dolphin\Ting\Bootstrap\Component\Verification;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use ReflectionClass;
use Redis;

class Controller
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @var Verification
     */
    protected $verification;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var Queue
     */
    protected $mq;

    /**
     * @var Redis
     */
    protected $cache;

    /**
     * @param  Container           $container
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function __construct(Container $container)
    {
        $this->container     = $container;
        // 数据校验
        $this->verification  = $container->get('Verification');
        // Doctrine ORM
        $this->entityManager = $container->get('EntityManager');
        // Queue
        $this->mq            = $container->get('Queue');
        // Cache
        $this->cache         = $container->get('Cache');
    }

    /**
     * @param  Response $response
     * @param  array    $data
     * @return Response
     */
    protected function respond ($response, $data = [])
    {
        $json = new JsonResponse($data);
        // 输出
        $response->getBody()->write(json_encode($json, JSON_PRETTY_PRINT));
        
        return $response->withHeader('Access-Control-Allow-Origin', '*')
                        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
                        ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
                        ->withHeader('Content-Type', 'application/json');
    }

    /**
     * @param  string              $name
     * @throws DependencyException
     * @throws NotFoundException
     * @return object
     */
    protected function loadModel ($name)
    {
        $container = $this->container;
        // 类名
        $className = ucfirst($name) . 'Model';

        if (! $container->has($className)) {
            $container->set($className, function () use ($container, $className) {
                $fullClassName = "\\Dolphin\\Ting\\Http\\Model\\" . $className;
                $modelClass    = new ReflectionClass($fullClassName);
                return $modelClass->newInstance($container);
            });
        }

        return $container->get($className);
    }

    /**
     * @param  string              $name
     * @throws DependencyException
     * @throws NotFoundException
     * @return object
     */
    protected function loadService ($name)
    {
        $container = $this->container;
        // 类名
        $className = ucfirst($name) . 'Service';

        if (! $container->has($className)) {
            $container->set($className, function () use ($container, $className) {
                $fullClassName = "\\Dolphin\\Ting\\Http\\Service\\" . $className;
                $serviceClass  = new ReflectionClass($fullClassName);
                return $serviceClass->newInstance($container);
            });
        }

        return $container->get($className);
    }

    /**
     * @param  string              $name
     * @throws DependencyException
     * @throws NotFoundException
     * @return object
     */
    protected function loadLibrary ($name)
    {
        $container = $this->container;
        // 类名
        $className = ucfirst($name) . 'Library';

        if (! $container->has($className)) {
            $container->set($className, function () use ($container, $className) {
                $fullClassName = "\\Dolphin\\Ting\\Http\\Library\\" . $className;
                $libraryClass  = new ReflectionClass($fullClassName);
                return $libraryClass->newInstance($container);
            });
        }

        return $container->get($className);
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