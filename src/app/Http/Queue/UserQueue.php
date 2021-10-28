<?php
//
namespace Dolphin\Ting\Http\Queue;

use Dolphin\Ting\Http\Constant\QueueConstant;
use PhpAmqpLib\Message\AMQPMessage;

class UserQueue extends Common
{
    /**
     * @var string
     */
    protected $virtualHost = QueueConstant::VIRTUAL_HOST_DEFAULT;

    /**
     * @var string
     */
    protected $queueName   = QueueConstant::QUEUE_DEFAULT;

    /**
     * @param  AMQPMessage $message
     *
     * @author wanghaibing
     * @date   2020/10/14 11:52
     */
    public function callback ($message)
    {
        $json = $message->getBody();
        // 转数组
        $data = json_decode($json, true);
        // 检查参数
        if (! isset($data['user_id'])) {
            echo 'RabbitMQ Message Error.' . PHP_EOL;

            return;
        }
        // 取出 UserId
        $userId = $data['user_id'];
        // 这里只是演示，没有实际的业务实现
        echo 'User:' . $userId . PHP_EOL;
    }
}