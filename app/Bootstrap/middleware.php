<?php
// Set Middleware
use Dolphin\Ting\Http\Middleware\AuthVerifyMiddleware;
use Dolphin\Ting\Http\Middleware\CORSMiddleware;
// Token 校验数据中间件
$app->add(new AuthVerifyMiddleware($container));
// Body Parsing Middleware
$app->addBodyParsingMiddleware();
// Route Middleware
$app->addRoutingMiddleware();
// Cross Origin Resource Sharing Middleware
$app->add(new CORSMiddleware());