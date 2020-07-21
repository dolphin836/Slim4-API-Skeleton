<?php
// MQ 消费者基础类，其他任务继承此类，并实现 callback 方法
namespace Dolphin\Ting\Console\Queue;

use DI\Container;
use Exception;
use Dolphin\Ting\Bootstrap\Component\Queue;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Channel\AMQPChannel;

abstract class Common
{
    /**
     * @var string 虚拟主机
     */
    protected $virtualHost;

    /**
     * @var string 交换机
     */
    protected $exchange;

    /**
     * @var string 队列
     */
    protected $queue;

    /**
     * Queue constructor.
     *
     * @param Container $container
     * @param Config    $config
     */
    public function __construct (Container $container, Config $config)
    {
        try {
            /** @var Queue $mq */
            $mq = $container->get('Queue');
            $mq->connection($config->getVirtualHost());
            $mq->receive($config->getQueue(), function ($message) {
                $this->callback($message);
                $this->ack($message);
                $this->exit($message);
            });
        } catch (Exception $e) {
            echo $e->getMessage() . PHP_EOL;
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
        }
    }

    /**
     * 定义回调方法
     * @param string $message
     */
    abstract public function callback ($message);
}