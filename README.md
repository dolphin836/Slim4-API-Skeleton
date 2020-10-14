# Slim4-API-Skeleton

Slim-Skeleton-MVC 是基于 Slim Framework 的脚手架。其主体框架来源于我 2017 年开发的一个商业项目。如果你还不了解 Slim Framework，可以从其 [官网](https://www.slimframework.com/) 了解相关信息。和 Laravel、Yii 等全能型框架相比，Micro Framework 拥有更好的性能和更大的灵活性。

#### 安装方法

使用 Composer 快速创建项目

```bash
composer create-project dolphin836/slim4-api-skeleton [app-name]
```

#### 配置 WEB 服务器

详细的配置方法请阅读 [Slim Documentation Web Servers](http://www.slimframework.com/docs/v4/start/web-servers.html)

#### 初始化配置文件

将 .env.example 重命名为 .env，然后填写相应的信息。

```bash
# 当前环境：dev - 开发、test - 测试、production - 生产
ENV=dev
# 时区
TIMEZONE=Asia/Shanghai
# 数据库服务器地址
DB_SERVERER=localhost
# 数据用户名
DB_USERNAME=root
# 数据库用户密码
DB_PASSWORD=password
# 数据吗名称
DB_DATANAME=app
```

#### 使用方法

命令：批量生成随机用户

```bash
$ php public/command.php generate-random-user 1
```

#### 开源组件

- [Doctrine ORM](https://www.doctrine-project.org)
- [PHP Dotenv](https://github.com/vlucas/phpdotenv)
- [PHP-DI](https://php-di.org/)
- [Guzzle](https://docs.guzzlephp.org/en/stable/index.html)
- [PHP Amqplib](https://github.com/php-amqplib/php-amqplib)
- [Monolog](https://github.com/Seldaek/monolog)
- [Yaml component](https://symfony.com/components/Yaml)

#### TODO

- 完善介绍，标准化
- 测试用例
- 持续集成
- 自动文档
