<?php

namespace Dolphin\Ting\Http\Exception;

class UserException extends CommonException
{
    protected $exceptionCode = 101;
    protected $exception     = [
        'USERNAME_NON_EXIST'                   => [101, '用户不存在'],
        'USERNAME_NON_EXIST_OR_PASSWORD_ERROR' => [102, '用户不存在或密码错误']
    ];
}