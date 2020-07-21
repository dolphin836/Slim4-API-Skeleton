<?php

namespace Dolphin\Ting\Http\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Server\MiddlewareInterface;
use Fig\Http\Message\RequestMethodInterface;

class JsonBodyParserMiddleware implements MiddlewareInterface, RequestMethodInterface
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
        // POST 请求
        if ($method === self::METHOD_POST) {
            $content = $request->getBody()->getContents();
            $data    = json_decode($content, true);

            $jsonErrorCode = json_last_error();
            //  Json Encoding & Decoding Error
            if ($jsonErrorCode !== JSON_ERROR_NONE) {
                $data = [];
            }

            $request = $request->withParsedBody($data);
        }

        return $handler->handle($request);
    }
}