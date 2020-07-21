<?php
// 消息队列
namespace Dolphin\Ting\Bootstrap\Component;

use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Exception;
use ErrorException;

/**
 * RabbitMQ
 * @package Dolphin\Ting\Bootstrap\Component
 * @author  https://github.com/php-amqplib/php-amqplib
 */
class Queue implements ComponentInterface
{
    /**
     * @var array 服务器配置信息
     */
    private $config;

    /**
     * @var AMQPStreamConnection
     */
    private $connection;

    /**
     * @var AMQPChannel
     */
    private $channel;

    /**
     * Queue constructor.
     *
     * @param  Container $app
     *
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function __construct (Container $app)
    {
        // 服务器配置信息
        $this->config = $app->get('Config')['mq'];
    }

    /**
     * Queue register.
     *
     * @param Container $container
     */
    public static function register (Container $container)
    {
        $container->set('Queue', function () use ($container) {
            return new Queue($container);
        });
    }

    /**
     * 链接
     * @param  string $virtualHost Virtual Host Name
     * @return Queue
     */
    public function connection ($virtualHost)
    {
        $this->connection = new AMQPStreamConnection($this->config['host'], $this->config['port'], $this->config['user'], $this->config['pass'], $virtualHost);
        $this->channel    = $this->connection->channel();

        return $this;
    }

    /**
     * 发送消息
     *
     * @param  string $json     消息
     * @param  string $exchange 交换机
     * @throws Exception
     */
    public function send ($json, $exchange)
    {
        $message = new AMQPMessage($json, [
            'content_type'  => 'application/json',
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
        ]);

        try {
            $this->channel->basic_publish($message, $exchange);
        } catch (Exception $e) {

        }
    }

    /**
     * @param $queue
     * @param $callback
     *
     * @throws ErrorException
     */
    public function receive ($queue, $callback)
    {
        $this->channel->basic_consume($queue, 'consumer', false, false, false, false, $callback);

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

    /**
     * 关闭链接
     * @throws Exception
     */
    public function shutdown ()
    {
        $this->channel->close();
        $this->connection->close();
    }
}