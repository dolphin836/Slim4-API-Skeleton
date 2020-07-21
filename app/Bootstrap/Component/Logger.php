<?php

namespace Dolphin\Ting\Bootstrap\Component;

use DI\Container;
use Monolog\Handler\StreamHandler;
use Monolog\Logger as MonoLog;
use Monolog\Processor\UidProcessor;
use Exception;

/**
 * 日志组件
 * @package Dolphin\Ting\Bootstrap\Component
 * @author  https://github.com/Seldaek/monolog
 */
class Logger implements ComponentInterface
{
    /**
     * Logger register.
     *
     * @param  Container $container
     *
     * @throws Exception
     */
    public static function register (Container $container)
    {
        $container->set('Logger', function () use ($container) {
            // 日志配置
            $config       = $container->get('Config')['log'];
            $logger       = new MonoLog($config['name']);
            $processor    = new UidProcessor();
            $logger->pushProcessor($processor);
            // 触发日志的最低级别
            $minLogLevel  = ENV === 'production' ? MonoLog::ERROR : MonoLog::DEBUG;
            // 按月存储
            $logFileName  = __DIR__ . '/../../..' . $config['path'] . '/' . date('Y') . '/' . date('m') . '/' . date('Ymd') . '.log';
            // 初始化
            $logHandler   = new StreamHandler($logFileName, $minLogLevel);
            $logger->pushHandler($logHandler);

            return $logger;
        });
    }
}