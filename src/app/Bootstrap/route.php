<?php
// Set Route
use Symfony\Component\Yaml\Yaml;

return function ($app) {
    // 路由配置文件
    $routeConfigFile = CONFPATH . 'route.yaml';
    // 读取路由配置
    $routeConfig     = Yaml::parseFile($routeConfigFile);
    // 设置路由
    foreach ($routeConfig as $route) {
        call_user_func_array([$app, $route['method']], [$route['path'], $route['controller']]);
    }
};

