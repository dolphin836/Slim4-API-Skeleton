<?php
// Autoload
require __DIR__ . '/../vendor/autoload.php';
// Bootstrap
$app = (require __DIR__ . '/../app/Bootstrap/app.php')['app'];
// Run
$app->run();