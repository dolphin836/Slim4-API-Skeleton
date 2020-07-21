<?php

namespace Dolphin\Ting\Http\Constant;

class ApplicationConstant
{
    // 应用类型
    const APPLICATION_TYPE_SNS  = 0; // 社交
    const APPLICATION_TYPE_NEW  = 1; // 新闻
    const APPLICATION_TYPE_SHOP = 2; // 电商
    const APPLICATION_TYPE_TOOL = 3; // 工具

    const APPLICATION_TYPE_NAME = [
        '社交',
        '新闻',
        '电商',
        '工具'
    ];
    // 终端
    const APPLICATION_CLIENT_WEB     = 1;
    const APPLICATION_CLIENT_WINDOWS = 2;
    const APPLICATION_CLIENT_MAC     = 4;
    const APPLICATION_CLIENT_IOS     = 8;
    const APPLICATION_CLIENT_ANDROID = 16;
    const APPLICATION_CLIENT_WEIXIN  = 32;
    // 授权登录平台
    const APPLICATION_AUTH_SIGN_IN_WEIXIN   = 1;
    const APPLICATION_AUTH_SIGN_IN_QQ       = 2;
    const APPLICATION_AUTH_SIGN_IN_WEIBO    = 3;
    const APPLICATION_AUTH_SIGN_IN_GOOGLE   = 4;
    const APPLICATION_AUTH_SIGN_IN_FACEBOOK = 5;
    const APPLICATION_AUTH_SIGN_IN_GITHUB   = 6;
}