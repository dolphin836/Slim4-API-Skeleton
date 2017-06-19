# Slim-Skeleton-MVC

[![Latest Stable Version](https://poser.pugx.org/dolphin836/slim-skeleton-mvc/v/stable)](https://packagist.org/packages/dolphin836/slim-skeleton-mvc)
[![Total Downloads](https://poser.pugx.org/dolphin836/slim-skeleton-mvc/downloads)](https://packagist.org/packages/dolphin836/slim-skeleton-mvc)
[![Latest Unstable Version](https://poser.pugx.org/dolphin836/slim-skeleton-mvc/v/unstable)](https://packagist.org/packages/dolphin836/slim-skeleton-mvc)
[![License](https://poser.pugx.org/dolphin836/slim-skeleton-mvc/license)](https://packagist.org/packages/dolphin836/slim-skeleton-mvc)

Slim-Skeleton-MVC 是基于 Slim Framework 的脚手架。其主体框架来源于我 2017 年开发的一个商业项目。如果你还不了解 Slim Framework，可以从其 [官网](https://www.slimframework.com/) 和 [中文网站](http://www.slimphp.net/) 了解相关信息。和 Laravel、Yii 等全能型框架相比，Micro Framework 拥有更好的性能和更大的灵活性。

Slim-Skeleton-MVC 使用 [Medoo](https://github.com/catfan/Medoo/) 作为 MYSQL 数据库中间件，使用 [Plates](https://github.com/thephpleague/plates) 提供视图模版输出。

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
WEB_URL="http://app.hbdx.cc/" # 应用地址，必须带反斜杠
DB_SERVERER="localhost"       # 数据库服务器
DB_USERNAME="root"            # 数据用户名
DB_PASSWORD=""                # 数据库用户密码
DB_DATANAME=""                # 数据吗名称
```

### 添加路由

详细的路由规则请阅读 [Slim Documentation Router](https://www.slimframework.com/docs/objects/router.html)

在 core/routes.php 中已经存在了一个简单的例子供你参考。

### TODO

- 完善介绍，标准化
- 测试用例
- 持续集成
- 自动文档
