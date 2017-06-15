<?php

$app->add(new Dolphin\Tan\Middleware\Weixin());

$app->add(new Dolphin\Tan\Middleware\Zhi());

// JSON Web Tokens 身份验证中间件 https://github.com/tuupola/slim-jwt-auth
$app->add(
    new \Slim\Middleware\JwtAuthentication(
        [
               "path" => "/account", // 需要进行 JWT 的请求
        "passthrough" => "/token", // 不需要进行 JWT 的请求
             "cookie" => "token", // 使用 cookie 存储 Token
             "secure" => true, // 是否启用 HTTPS
            "relaxed" => ["app.hbdx.cc"], // 不进行 HTTPS 安全验证的域名
             "secret" => getenv("JWT_SECRET"), // 密钥
              "error" => function ($request, $response, $args) { // 错误处理
                $json['code'] = -1;
                $json['note'] = $args["message"];
                $json['help'] = 'http://api.app.com';
                // $json['token'] = htmlspecialchars($_COOKIE["token"]);

                return $response->withStatus(401)
                                ->withHeader("Content-Type", "application/json")
                                ->write(json_encode($json, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
            }
        ]
    )
);

