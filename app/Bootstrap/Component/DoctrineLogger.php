<?php
// Doctrine ORM 日志
namespace Dolphin\Ting\Bootstrap\Component;

use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Doctrine\DBAL\Logging\SQLLogger;

class DoctrineLogger implements SQLLogger
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var string[]
     */
    private $type = [
        'SELECT',
        'UPDATE',
        'INSERT',
        'DELETE',
        'CREATE'
    ];

    /**
     * DoctrineLogger constructor.
     *
     * @param  Container $container
     *
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function __construct (Container $container)
    {
        $this->logger   = $container->get('Logger');
    }

    /**
     * @param  string $sql
     * @param  array  $params
     * @param  array  $types
     *
     * @author wanghaibing
     * @date   2020/10/13 15:02
     */
    public function startQuery($sql, $params = [], $types = [])
    {
        // 替换参数
        if ($this->isType($sql)) {
            if (!empty($params)) {
                $count = count($params);

                while ($count > 0) {
                    $count--;
                    $sql = preg_replace('/\?/', array_shift($params), $sql, 1);
                }
            }
            // 记录日志
            $this->logger->info($sql);
        }
    }

    /**
     * @author wanghaibing
     * @date   2020/10/13 15:06
     */
    public function stopQuery()
    {

    }

    /**
     * 判断是否为允许的类型
     *
     * @param  string $sql
     *
     * @return boolean
     *
     * @author wanghaibing
     * @date   2020/10/13 15:41
     */
    private function isType ($sql)
    {
        foreach ($this->type as $type) {
            if (strpos($sql, $type) === 0) {
                return true;
            }
        }

        return false;
    }
}