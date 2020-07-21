<?php

namespace Dolphin\Ting\Http\Middleware;

use Dolphin\Ting\Http\Exception\AuthException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Server\MiddlewareInterface;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Token\Plain;
use Psr\Container\ContainerInterface as Container;
use Exception;

class AuthVerifyMiddleware implements MiddlewareInterface
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Token 校验中间件
     *
     * @param  Request        $request PSR-7  request
     * @param  RequestHandler $handler PSR-15 request handler
     *
     * @return Response
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        // 排除不需要鉴权的路由
        // 读取配置
        $config         = $this->container->get('Config');
        $unAuthRouteArr = $config['auth']['unAuth'];
        // 当前路由
        $uriPath        = $request->getUri()->getPath();
        // 直接返回 Response
        if (in_array($uriPath, $unAuthRouteArr)) {
            $response = $handler->handle($request);

            return $response;
        }
        // 获取 Token
        $token  = '';
        // 首先从 Header 中的 Authorization 取，格式为 Authorization: Bearer <token>
        if ($request->hasHeader('Authorization')) {
            $authorization = $request->getHeaderLine('Authorization');
            // 用空格分割
            $authorization = explode(' ', $authorization);
            // 取出 Token
            $token         = isset($authorization[1]) ? $authorization[1] : '';
        }
        // 再从 Header 中的 Token 取
        if ($token === '' && $request->hasHeader('Token')) {
            $token = $request->getHeaderLine('Token');
        }
        // 再从 Query 参数中取，格式 ?token=<token>
        if ($token === '') {
            $params = $request->getUri()->getQuery();
            parse_str($params, $paramsArr);

            $token = isset($paramsArr['token']) ? $paramsArr['token'] : '';
        }
        // 最后从 Body Json 参数中取，字段名称 token
        if ($token === '') {
            $content = $request->getBody()->getContents();
            $data    = json_decode($content, true);

            $jsonErrorCode = json_last_error();
            // JSON 解析正确
            if ($jsonErrorCode === JSON_ERROR_NONE) {
                $token = isset($data['token']) ? $data['token'] : '';
            }
        }
        // 校验 JWT Token 有效性
        /** @var Configuration $auth */
        $auth  = $this->container->get('Auth');
        // 将 Token 字符串转成 JWT Token 对象
        try {
            /** @var Plain $token */
            $token = $auth->getParser()->parse($token);
        } catch (Exception $e) {
            return $this->returnTokenInvalid();
        }
        // 验证器
        $authVerification = $auth->getValidationConstraints();
        // 校验 Token
        try {
            $auth->getValidator()->assert($token, ...$authVerification);
        } catch (Exception $e) {
            return $this->returnTokenInvalid();
        }
        // 取出用户身份信息
        $data     = $token->claims();
        $userId   = $data->get('UserId');
        // 传递 UserId
        $request  = $request->withAttribute('UserId', $userId);
        // 返回
        $response = $handler->handle($request);

        return $response;
    }

    private function returnTokenInvalid ()
    {
        // 权限校验异常类
        $exception = new AuthException();
        // Response
        $content = json_encode([
            'code' => $exception->getCode(),
            'note' => $exception->getMessage(),
            'data' => []
        ], JSON_PRETTY_PRINT);

        $response = new \Slim\Psr7\Response();

        $response->getBody()->write($content);

        return $response->withHeader('Access-Control-Allow-Origin', '*')
                        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS')
                        ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
                        ->withHeader('Content-Type', 'application/json');
    }
}