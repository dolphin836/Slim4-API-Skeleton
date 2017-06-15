<?php

// 默认路由
$default = 'Dolphin\\Tan\\Controller\\' . ucwords($container->get('config')['defaultController']) . ':index';

$app->get('/', $default)->setName('default');

// 自定义路由
$app->get('/index.html', 'Dolphin\Tan\Controller\Home:index')->setName('home');
$app->get('/view/{id:[0-9]+}.html', 'Dolphin\Tan\Controller\Home:view')->setName('view');

$app->get('/token', 'Dolphin\Tan\Controller\Token:index')->setName('token');
