<?php

namespace Dolphin\Ting\Http\Exception;

class AuthException
{
    private $code    = 100000;
    private $message = 'Token 无效';

    /**
     * @return int
     */
    public function getCode () : int
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getMessage () : string
    {
        return $this->message;
    }
}