<?php

namespace Dolphin\Ting\Bootstrap\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Server\MiddlewareInterface;
use Fig\Http\Message\RequestMethodInterface;

class CORSMiddleware implements MiddlewareInterface, RequestMethodInterface
{
    /**
     * Json 中间件
     *
     * @param  Request        $request PSR-7  request
     * @param  RequestHandler $handler PSR-15 request handler
     *
     * @return Response
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        // 请求类型
        $method = $request->getMethod();
        // METHOD_OPTIONS 请求
        if ($method === self::METHOD_OPTIONS) {

            $response = new \Slim\Psr7\Response();

            return $response->withStatus(204)
                            ->withHeader('Access-Control-Allow-Origin', '*')
                            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
                            ->withHeader('Access-Control-Allow-Headers', 'Content-Type')
                            ->withHeader('Content-Type', 'application/json');
        }

        $response = $handler->handle($request);

        return $response;
    }
}