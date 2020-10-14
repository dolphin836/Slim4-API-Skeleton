<?php
// MQ 消费者基础类，其他任务继承此类，并实现 callback 方法
namespace Dolphin\Ting\Http\Queue;

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
     * 虚拟主机
     *
     * @var string
     */
    protected $virtualHost;

    /**
     * 队列
     *
     * @var string
     */
    protected $queueName;

    /**
     * Queue constructor.
     *
     * @param Container $container
     */
    public function __construct (Container $container)
    {
        try {
            $this->entityManager = $container->get('EntityManager');
            /** @var Queue $queue */
            $queue = $container->get('Queue');
            // 连接 MQ
            $queue->connection($this->virtualHost);
            // 数据库心跳检测
            $this->keepConnection();
            //
            $queue->receive($this->queueName, function ($message) {
                if ($this->isJsonMessage($message)) {
                    $this->callback($message);
                }
                $this->ack($message);
                $this->exit($message);
            });
        } catch (Exception $e) {
            echo 'RabbitMQ Error:' . $e->getMessage() . PHP_EOL;
        }
    }

    /**
     * 通用 ACK 方法
     *
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
     *
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
     * 校验消息格式
     *
     * @param  AMQPMessage $message
     * @return bool
     */
    private function isJsonMessage ($message)
    {
        $json = $message->getBody();
        // 打印消息
        echo 'RabbitMQ Message:' . $json . PHP_EOL;
        // 转数组
        $data = json_decode($json, true);
        // 非法格式
        if (! is_array($data) || json_last_error() !== JSON_ERROR_NONE) {
            echo 'RabbitMQ Message Not Json.' . PHP_EOL;

            return false;
        }

        return true;
    }

    /**
     * 定义回调方法
     *
     * @param AMQPMessage $message
     */
    abstract public function callback ($message);
}