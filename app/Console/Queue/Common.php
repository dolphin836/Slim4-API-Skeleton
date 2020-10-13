<?php
// MQ 消费者基础类，其他任务继承此类，并实现 callback 方法
namespace Dolphin\Ting\Console\Queue;

use DI\Container;
use Doctrine\ORM\EntityManager;
use Exception;
use Dolphin\Ting\Bootstrap\Component\Queue;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Channel\AMQPChannel;

abstract class Common
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * Queue constructor.
     *
     * @param Container $container
     * @param string    $virtualHost
     * @param string    $queueName
     */
    public function __construct (Container $container, $virtualHost, $queueName)
    {
        try {
            $this->entityManager = $container->get('EntityManager');
            /** @var Queue $queue */
            $queue = $container->get('Queue');
            // 连接 MQ
            $queue->connection($virtualHost);
            // 数据库心跳检测
            $this->keepConnection();
            //
            $queue->receive($queueName, function ($message) {
                $this->callback($message);
                $this->ack($message);
                $this->exit($message);
            });
        } catch (Exception $e) {
            echo 'RabbitMQ Error:' . $e->getMessage() . PHP_EOL;
        }
    }

    /**
     * 通用 ACK 方法
     * @param AMQPMessage $message
     */
    private function ack ($message)
    {
        /** @var AMQPChannel $channel */
        $channel = $message->delivery_info['channel'];

        $channel->basic_ack($message->delivery_info['delivery_tag']);

        echo 'RabbitMQ Ack.' . PHP_EOL;
    }

    /**
     * 通用退出脚本方法
     * @param AMQPMessage $message
     */
    private function exit ($message)
    {
        if ($message->body === 'quit') {
            /** @var AMQPChannel $channel */
            $channel = $message->delivery_info['channel'];

            $channel->basic_cancel($message->delivery_info['consumer_tag']);

            echo 'RabbitMQ Quit.' . PHP_EOL;

            exit();
        }
    }

    /**
     * 数据库自动重连
     */
    private function keepConnection ()
    {
        $isConnection = $this->entityManager->getConnection()->ping();

        if (! $isConnection) {
            $this->entityManager->getConnection()->close();
            $this->entityManager->getConnection()->connect();
        }
    }

    /**
     * 定义回调方法
     * @param string $message
     */
    abstract public function callback ($message);
}