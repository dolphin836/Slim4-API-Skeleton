<?php

namespace Dolphin\Ting\Http\Exception;

use Exception;

class CommonException extends Exception
{
    protected $exceptionCode = 100;
    protected $exception = [
        'AUTH_ERROR'           => [100, '权限错误'],
        'PARAMETER_REQUIRED'   => [101, '缺少必须的参数 %s'],
        'PARAMETER_TYPE_ERROR' => [102, '参数 %s 不是 %s 类型'],
        'PARAMETER_IS_EMPTY'   => [103, '参数 %s 不能为空'],
        'PARAMETER_MIN_LENGTH' => [104, '参数 %s 长度不得小于 %d'],
        'PARAMETER_MAX_LENGTH' => [105, '参数 %s 长度不得大于 %d'],
        'PARAMETER_MAX_VALUE'  => [106, '参数 %s 不得大于 %s'],
        'PARAMETER_MIN_VALUE'  => [107, '参数 %s 不得小于 %s'],
        'RECORD_ALREADY_EXIST' => [108, '参数 %s 等于 %s 的记录已经存在'],
        'RECORD_NOT_EXIST'     => [109, '记录不存在'],
        'UNKNOWN_ERROR'        => [110, '未知错误']
    ];

    private $unknownExceptionCode = 100100;
    private $unknownException     = '未定义的错误';

    public function __construct ($exceptionCode, $data = [], $message = '')
    {

        if (isset($this->exception[$exceptionCode])) {
            $exceptionContent = $this->exception[$exceptionCode];

            $code = $this->exceptionCode . $exceptionContent[0];

            if ($message === '') {
                if (empty($data)) {
                    $message = $exceptionContent[1];
                } else {
                    array_unshift($data, $exceptionContent[1]);

                    $message = call_user_func_array('sprintf', $data);
                }
            }
        } else {
            $code    = $this->unknownExceptionCode;
            $message = $this->unknownException;
        }

        parent::__construct($message, $code);
    }
}