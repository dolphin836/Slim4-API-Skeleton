<?php

namespace Dolphin\Ting\Bootstrap\Error;

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpInternalServerErrorException;

class Error
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var Exception
     */
    private $exception;

    /**
     * @var bool
     */
    private $isProduction;

    // 系统错误类型定义
    const ERROR_TYPE = [
        E_ERROR             => 'E_ERROR',
        E_WARNING           => 'E_WARNING',
        E_PARSE             => 'E_PARSE',
        E_NOTICE            => 'E_NOTICE',
        E_CORE_ERROR        => 'E_CORE_ERROR',
        E_CORE_WARNING      => 'E_CORE_WARNING',
        E_COMPILE_ERROR     => 'E_COMPILE_ERROR',
        E_COMPILE_WARNING   => 'E_COMPILE_WARNING',
        E_USER_ERROR        => 'E_USER_ERROR',
        E_USER_WARNING      => 'E_USER_WARNING',
        E_USER_NOTICE       => 'E_USER_NOTICE',
        E_STRICT            => 'E_STRICT',
        E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',
        E_DEPRECATED        => 'E_DEPRECATED',
        E_USER_DEPRECATED   => 'E_USER_DEPRECATED',
        E_ALL               => 'E_ALL'
    ];

    /**
     * @param Request   $request
     * @param Exception $exception
     * @param bool      $isProduction
     */
    public function __construct(Request $request, Exception $exception, bool $isProduction)
    {
        $this->request      = $request;
        $this->exception    = $exception;
        $this->isProduction = $isProduction;
    }

    public function __invoke()
    {
        $programErrorData = error_get_last();

        if ($programErrorData) {
            $errorFile    = $programErrorData['file'];
            $errorLine    = $programErrorData['line'];
            $errorMessage = $programErrorData['message'];
            $errorType    = $programErrorData['type'];
            $message      = 'Server Error.';
            // 非生产环境，输出详细信息
            if (! $this->isProduction) {
                $message  = isset(self::ERROR_TYPE[$errorType]) ? self::ERROR_TYPE[$errorType] . ':' : '';
                $message .= $errorMessage . ' On Line ' . $errorLine . ' In File ' . $errorFile;
            }

            $exception    = new HttpInternalServerErrorException($this->request, $message);

            $httpResponse = $this->exception->__invoke(
                $this->request,
                $exception,
                ! $this->isProduction,
                false,
                false
            );

            $response = new Response();
            $response->respond($httpResponse);
        }
    }
}