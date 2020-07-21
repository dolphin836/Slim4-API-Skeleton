#!/usr/bin/env php
<?php
// Autoload
require __DIR__ . '/../../vendor/autoload.php';

use Symfony\Component\Console\Application;
use Dolphin\Ting\Http\Command\GenerateUserCommand;

$application = new Application();
// 注册命令
$application->add(new GenerateUserCommand());

try {
    $application->run();
} catch (Exception $e) {

}

