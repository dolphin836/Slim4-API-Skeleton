#!/usr/bin/env php
<?php
// Autoload
require __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Console\Application;

$application = new Application();
$commandMap  = require __DIR__ . '/../config/command.php';
// 注册命令
foreach ($commandMap as $command) {
    call_user_func([$application, 'add'], new $command);
}

try {
    $application->run();
} catch (Exception $e) {

}

