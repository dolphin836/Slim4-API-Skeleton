<?php
// Autoload
require __DIR__ . '/../vendor/autoload.php';
// Bootstrap
$container = (require __DIR__ . '/../app/Bootstrap/app.php')['container'];
// 命令行参数数量错误
if ($argc < 2) {
    exit("Command Error: Process Name Is Empty.");
}
// 首字母大写
$processName = ucfirst($argv[1]);
$className   = 'Dolphin\\Ting\\Http\\Queue\\' . $processName;
// 判断类是否存在
if (! class_exists($className)) {
    exit("Command Error: Process Non Existed.");
}
// 移除前面两个参数
unset($argv[0]);
unset($argv[1]);
// 调用任务，并传递其他参数
new $className($container, array_values($argv));
