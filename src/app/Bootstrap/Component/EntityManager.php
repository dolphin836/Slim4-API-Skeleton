<?php

namespace Dolphin\Ting\Bootstrap\Component;

use DI\Container;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager as ORMEntityManager;
use Doctrine\ORM\Tools\Setup;

/**
 * Doctrine ORM
 * @package Dolphin\Ting\Bootstrap\Component
 * @author  https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/index.html
 */
class EntityManager implements ComponentInterface
{
    /**
     * EntityManager register.
     *
     * @param Container $container
     */
    public static function register (Container $container)
    {
        $container->set('EntityManager', function () use ($container) {
            // 数据库配置
            /** @var Connection $pdoDriver */
            $pdoDriver    = $container->get('Config')['database'];
            // 是否为生产环境
            $isProduction = ENV === 'production';
            // 创建 ORM 配置
            $entityManagerConfig = Setup::createAnnotationMetadataConfiguration([], ! $isProduction);
            // 非生产环境记录 SQL 日志
            if (! $isProduction) {
                $entityManagerConfig->setSQLLogger(new DoctrineLogger($container));
            }

            return ORMEntityManager::create($pdoDriver, $entityManagerConfig);
        });
    }
}