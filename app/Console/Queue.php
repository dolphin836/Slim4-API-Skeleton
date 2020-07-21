<?php
// Autoload
require __DIR__ . '/../../vendor/autoload.php';
// Bootstrap
require __DIR__ . '/../../app/Bootstrap/app.php';
// 命令行参数数量错误
if ($argc < 2) {
    exit("Command Error: Process Name Is Empty.");
}
// 接口命令行参数，得到任务名称
$processNameText = $argv[1];
$processNameArr  = explode('=', $processNameText);

if (count($processNameArr) < 2 || empty($processNameArr[1])) {
    exit("Command Error: Process Name Is Empty.");
}
// 首字母大写
$processName = ucfirst($processNameArr[1]);
$className   = 'Dolphin\\Ting\\Console\\Queue\\' . $processName;
// 判断类是否存在
if (! class_exists($className)) {
    exit("Command Error: Process Non Existed.");
}
// 移除前面两个参数
unset($argv[0]);
unset($argv[1]);
// 调用任务，并传递其他参数
new $className($container, array_values($argv));
