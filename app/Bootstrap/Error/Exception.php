<?php

namespace Dolphin\Ting\Bootstrap\Error;

use Dolphin\Ting\Http\Constant\HttpResponseCodeConstant;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Handlers\ErrorHandler as SlimErrorHandler;

class Exception extends SlimErrorHandler
{
    protected function respond(): Response
    {
        $exception        = $this->exception;
        $exceptionCode    = $exception->getCode();
        $exceptionMessage = $exception->getMessage();

        $content = json_encode([
            'code' => $exceptionCode,
            'note' => $exceptionMessage,
            'data' => []
        ], JSON_PRETTY_PRINT);

        $response = $this->responseFactory->createResponse(HttpResponseCodeConstant::HTTP_OK);

        $response->getBody()->write($content);

        return $response->withHeader('Access-Control-Allow-Origin', '*')
                        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
                        ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
                        ->withHeader('Content-Type', 'application/json');
    }
}