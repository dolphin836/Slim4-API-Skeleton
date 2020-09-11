<?php

use Dolphin\Ting\Bootstrap\Error\Exception;
use Dolphin\Ting\Bootstrap\Error\Error;
use Slim\Factory\ServerRequestCreatorFactory;

return function ($app) {
    // 是否为生产环境
    $isProduction = ENV === 'production';

    if ($isProduction) {
        // 关闭所有 PHP 错误
        error_reporting(0);
    } else {
        // 报告所有 PHP 错误
        error_reporting(E_ALL);
    }

    $callableResolver = $app->getCallableResolver();
    $responseFactory  = $app->getResponseFactory();
    // 异常处理
    $exception = new Exception($callableResolver, $responseFactory);

    $serverRequest = ServerRequestCreatorFactory::create();
    $request = $serverRequest->createServerRequestFromGlobals();
    // 程序中止时执行
    $error = new Error($request, $exception, $isProduction);
    register_shutdown_function($error);
    // 添加错误处理中间件
    $errorMiddleware = $app->addErrorMiddleware(true, false, !$isProduction);
    $errorMiddleware->setDefaultErrorHandler($exception);
};