<?php

define('VERSIONR', '1.0.0');

define('BASEPATH', __DIR__);

require BASEPATH . '/vendor/autoload.php';

use Medoo\Medoo;
use Ramsey\Uuid\Uuid;

$env = new Dotenv\Dotenv(BASEPATH);
$env->load();

$db = new Medoo(
    [
    'database_type' => 'mysql',
    'database_name' => getenv('DB_DATANAME'),
           'server' => getenv('DB_SERVERER'),
         'username' => getenv('DB_USERNAME'),
         'password' => getenv('DB_PASSWORD'),
          'charset' => 'utf8'
    ]
);

$db->query(
    "CREATE TABLE `user` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`uuid` varchar(64) NOT NULL DEFAULT '' COMMENT '用户的唯一身份标识符',
	`nickname` varchar(32) NOT NULL DEFAULT '' COMMENT '昵称/姓名',
	`telephone` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号',
    `openid` varchar(32) NOT NULL DEFAULT '' COMMENT '微信的open ID',
	`password` varchar(255) NOT NULL DEFAULT '' COMMENT '密文',
	`token` varchar(32) NOT NULL DEFAULT '' COMMENT 'Token',
	`token_invalid_time` int(11) NOT NULL DEFAULT 0 COMMENT 'Token过期时间',
	`avatar` varchar(256) NOT NULL DEFAULT '' COMMENT '头像',
	`register_time` int(11) NOT NULL DEFAULT 0 COMMENT '注册时间',
	`last_login_time` int(11) NOT NULL DEFAULT 0 COMMENT '最后登陆时间',
	`ip_address` varchar(64) NOT NULL DEFAULT '' COMMENT 'IP地址',
	PRIMARY KEY (`id`),
    UNIQUE KEY `uuid` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
);

$error = $db->error();

if ($error[0] == '00000') {
    var_dump("Table 'user' create success.");
} else {
    var_dump($error[2]);
    exit;
}

$nickname = getenv('ADMIN_USERNAME');
$phone    = getenv('ADMIN_PHONE');
$password = password_hash(getenv('ADMIN_PASSWORD'), PASSWORD_DEFAULT);

$uuid4    = Uuid::uuid4();
$uuid     = $uuid4->toString();

$db->insert(
    "user", [
               "uuid" => $uuid,
           "nickname" => $nickname,
          "telephone" => $phone,
           "password" => $password,
      "register_time" => time(),
    "last_login_time" => time()
    ]
);

if ($error[0] == '00000') {
    var_dump("Insert 'user' success.");
} else {
    var_dump($error[2]);
    exit;
}

var_dump("Install completed.");