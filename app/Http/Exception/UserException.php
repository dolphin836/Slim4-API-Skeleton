<?php

namespace Dolphin\Ting\Http\Exception;

class UserException extends CommonException
{
    protected $exceptionCode = 101;
    protected $exception = [
        'USERNAME_NON_EXIST'      => [101, '用户不存在'],
        'USERNAME_PASSWORD_ERROR' => [102, '用户 %s 密码错误'],
        'USERNAME_AUTH_ERROR'     => [103, '没有权限'],
        'USERNAME_NOT_ACTIVE'     => [104, '用户 %s 未激活'],
        'USERNAME_REPEAT_ACTIVE'  => [104, '重复激活'],
        'USERNAME_ACTIVE_FAIL'    => [105, '激活失败'],
    ];
}