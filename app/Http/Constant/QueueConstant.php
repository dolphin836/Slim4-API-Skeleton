<?php
// 消息队列
namespace Dolphin\Ting\Http\Constant;

class QueueConstant
{
    // 新用户注册发送邮件 MQ
    const NewUser = [
        'virtualHost' => '36Password',
        'exchange'    => 'NewUser',
        'queue'       => 'NewUserSendMail'
    ];
}