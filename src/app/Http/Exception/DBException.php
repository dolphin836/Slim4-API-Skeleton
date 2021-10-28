<?php

namespace Dolphin\Ting\Http\Exception;

use Exception;

class DBException extends Exception
{
    private $DBExceptionCode = 200000;

    public function __construct (Exception $e)
    {
        // 是否为生产环境
        if (ENV === 'production') {
            $message = 'DB Error.';
        } else {
            $message = $e->getMessage();
        }

        parent::__construct($message, $this->DBExceptionCode);
    }
}