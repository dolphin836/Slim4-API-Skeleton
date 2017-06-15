# Slim-Skeleton-MVC

[![Latest Stable Version](https://poser.pugx.org/dolphin836/slim-skeleton-mvc/v/stable)](https://packagist.org/packages/dolphin836/slim-skeleton-mvc)
[![Total Downloads](https://poser.pugx.org/dolphin836/slim-skeleton-mvc/downloads)](https://packagist.org/packages/dolphin836/slim-skeleton-mvc)
[![Latest Unstable Version](https://poser.pugx.org/dolphin836/slim-skeleton-mvc/v/unstable)](https://packagist.org/packages/dolphin836/slim-skeleton-mvc)
[![License](https://poser.pugx.org/dolphin836/slim-skeleton-mvc/license)](https://packagist.org/packages/dolphin836/slim-skeleton-mvc)

Slim-Skeleton-MVC 是基于 Slim Framework 的脚手架。其主体框架来源于我 2017 年开发的一个商业项目。如果你还不了解 Slim Framework，可以从其 [官网](https://www.slimframework.com/) 和 [中文网站](http://www.slimphp.net/) 了解相关信息。和 Laravel、Yii 等全能型框架相比，Micro Framework 拥有更好的性能和更大的灵活性。

如果你想要使用 PHP 实现一套 RESTful API 系统，Slim 也是不错的选择。

Slim-Skeleton-MVC 使用 [Medoo](https://github.com/catfan/Medoo/) 作为 MYSQL 数据库中间件，使用 [Plates](https://github.com/thephpleague/plates) 提供视图模版输出。

默认使用 [weui](https://github.com/weui/weui) 和 [weui.js](https://github.com/weui/weui.js) 来构建用户界面，并且已经提供了如下组件：工具栏、我的账户

另外，还使用了 [PHP dotenv](https://github.com/vlucas/phpdotenv) 解析配置文件。

## 安装方法

使用 Composer 快速创建项目

```bash
composer create-project dolphin836/slim-skeleton-mvc [slim-app]
```

## 使用方法

### 配置 WEB 服务器

详细的配置方法请阅读 [Slim Documentation Web Servers](https://www.slimframework.com/docs/start/web-servers.html)

### 初始化配置文件

将 .env.example 重命名为 .env，然后填写相应的信息。

```bash
APP_ENV="development"   # development/production
DB_SERVERER="localhost" # 数据库服务器
DB_USERNAME="root"      # 数据用户名
DB_PASSWORD=""          # 数据库用户密码
DB_DATANAME=""          # 数据吗名称
ADMIN_USERNAME=""       # 管理员昵称
ADMIN_PHONE=""          # 管理员电话号码
ADMIN_PASSWORD=""       # 管理员密码
```

开发模式下将 APP_ENV 设置为 development，生产环境下设置为 production。
development 环境下程序自动加载本地资源，production 环境下自动加载 CDN 资源。

### 初始化

运行程序初始化命令，安装程序会首先创建一张 user 表，然后使用 .env 中配置的管理员信息插入一条用户数据。

```bash
php install.php
```

### 添加路由

详细的路由规则请阅读 [Slim Documentation Router](https://www.slimframework.com/docs/objects/router.html)

在 core/routes.php 中已经存在了一个简单的例子供你参考。

### TODO

- 微信和支付宝中间件
- 完善介绍，标准化
- 测试用例
- 持续集成
- 自动文档
- 支付
