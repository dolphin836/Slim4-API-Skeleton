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
use Closure;

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
     * @var boolean
     */
    private $isConfirm;

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
        $this->config = $app->get('Config')['queue'];
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
     * 连接
     *
     * @param  string  $virtualHost Virtual Host Name
     * @param  boolean $isConfirm   是否确认回调
     *
     * @return Queue
     *
     * @throws Exception
     */
    public function connection ($virtualHost, $isConfirm = false)
    {
        $this->connection = new AMQPStreamConnection(
            $this->config['host'],
            $this->config['port'],
            $this->config['user'],
            $this->config['pass'],
            $virtualHost,
            false,
            'AMQPLAIN',
            null,
            'en_US',
            180,
            60,
            null,
            false,
            30
        );

        if (! $this->connection->isConnected()) {
            throw new Exception('Connection Fail.');
        }

        $this->isConfirm = $isConfirm;
        $this->channel   = $this->connection->channel();
        // 一个消费者一次只读取一条消息
        $this->channel->basic_qos(null, 1, null);
        // 设置为 Confirm 模式
        if ($this->isConfirm && $this->channel) {
            $this->channel->confirm_select();
        }

        return $this;
    }

    /**
     * 发送消息
     *
     * @param  string       $json     消息
     * @param  string       $exchange 交换机
     * @param  Closure|null $callback 成功确认回调
     *
     * @throws Exception
     */
    public function send ($json, $exchange, $callback = null)
    {
        $message = new AMQPMessage($json, [
            'content_type'  => 'application/json',
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
        ]);
        // 设置回调确认
        if ($this->isConfirm && $this->channel) {
            if (is_callable($callback) && $callback instanceof Closure) {
                $this->channel->set_ack_handler($callback);
            }
        }

        try {
            // 等待服务端确认
            $this->isConfirm && $this->channel->wait_for_pending_acks();
            // 发送消息
            $this->channel->basic_publish($message, $exchange);
            // 等待服务端确认
            $this->isConfirm && $this->channel->wait_for_pending_acks();
        } catch (Exception $e) {

        }
    }

    /**
     * @param string  $queue
     * @param Closure $callback
     *
     * @throws ErrorException
     */
    public function receive ($queue, $callback)
    {
        if (! is_callable($callback) || ! ($callback instanceof Closure)) {
            $callback = function () {
                echo 'RabbitMQ Receive Callback Empty.:' . PHP_EOL;
            };
        }

        $this->channel->basic_consume($queue, 'consumer', false, false, false, false, $callback);

        while (count($this->channel->callbacks)) {
            $this->channel->wait();
        }
    }

    /**
     * 关闭链接
     * @throws Exception
     */
    public function shutdown ()
    {
        if (! $this->connection || ! $this->channel) {
            throw new Exception('Connection Fail.');
        }

        $this->channel->close();
        $this->connection->close();
    }
}