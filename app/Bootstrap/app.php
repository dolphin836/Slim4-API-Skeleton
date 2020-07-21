<?php
// Bootstrap The App
use DI\Container;
use Slim\Factory\AppFactory;
use Dotenv\Dotenv;
// 定义目录
define('BASEPATH', __DIR__);
define('ROOTPATH', __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
define('CONFPATH', ROOTPATH . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR);
// Config File
$env = new Dotenv(ROOTPATH);
// Set TimeZone
date_default_timezone_set(getenv('APP_TIMEZONE'));
// Set Env
define('ENV', getenv("ENV"));
// Create Container
$container = new Container();
// Set Container
AppFactory::setContainer($container);
// Create App
$app = AppFactory::create();
// Component
require BASEPATH . DIRECTORY_SEPARATOR . 'component.php';
// Middleware
require BASEPATH . DIRECTORY_SEPARATOR . 'middleware.php';
// Route
require BASEPATH . DIRECTORY_SEPARATOR . 'route.php';
// Exception
require BASEPATH . DIRECTORY_SEPARATOR . 'error.php';