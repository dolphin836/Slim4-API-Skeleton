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

## 环境

建议统一使用 `Docker` 搭建开发环境

- `Docker` 20.10.5
- `Docker-compose` 1.28.5

项目的服务依赖

- `PHP` 8.0.3
- `MySQL` 8.0.23
- `Redis` 6.2.1
- `Composer` 2.0.11

### 启动

1. 创建 `Lumen` 配置文件，并设置相应的项

```shell
cp src/.env.example src/.env
```

2. 设置日志目录权限

```shell
chmod -R 777 src/storage/logs
```

3. 创建 `Docker` 配置文件，并设置相应的项

```shell
cp .env.example .env
```

4. 初始化并启动服务

```shell
docker-compose -f docker-compose.yml up -d                                    # 创建并启动服务
docker-compose -f docker-compose.yml start                                    # 启动服务
docker-compose -f docker-compose.yml stop                                     # 停止服务
docker-compose -f docker-compose.yml down                                     # 停止并删除服务
docker-compose -f docker-compose.yml restart                                  # 重启所有服务
docker-compose -f docker-compose.yml restart service_name                     # 重启指定服务
docker-compose -f docker-compose.yml exec service_name composer update --lock # 更新 Composer 依赖
```

实际使用中，请根据当前环境选择对应的配置文件，`docker-compose.development.yml` 开发环境，`docker-compose.test.yml` 测试环境，`docker-compose.production.yml` 生产环境

生产环境由于启用了 `Opcache`，代码更新后需要重启 `php-fpm` 服务重新加载代码

5. 安装依赖

首次安装或者 `composer.lock` 文件有更新时需要更新依赖

```shell
docker compose -f docker-compose.development.yml exec php-fpm composer update --lock # Windows
docker-compose -f docker-compose.development.yml exec php-fpm composer update --lock # Linux
```

如果本地没有安装 `Composer` 又需要升级依赖包

```shell
docker compose -f docker-compose.development.yml exec php-fpm composer update # Windows
docker-compose -f docker-compose.development.yml exec php-fpm composer update # Linux
```

6. 更新代码

```shell
git fetch --all
git reset --hard origin/master
```

7. SuperVisor

```shell
docker compose -f docker-compose.development.yml exec php-fpm /usr/bin/supervisorctl reload # 新增、修改配置文件后重新加载
docker compose -f docker-compose.development.yml exec php-fpm /usr/bin/supervisorctl update
```
