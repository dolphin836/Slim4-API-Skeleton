<?php

namespace Dolphin\Ting\Bootstrap\Component;

use DI\Container;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Validation\Constraint\IssuedBy;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Validation\Constraint\ValidAt;
use Lcobucci\Clock\SystemClock;

class Auth implements ComponentInterface
{
    /**
     * JWT register.
     *
     * @param Container $container
     */
    public static function register (Container $container)
    {
        $container->set('Auth', function () use ($container) {
            // 配置
            $config = $container->get('Config');
            // 初始化
            $auth   = Configuration::forSymmetricSigner(
                new Sha256(),
                new Key($config['auth']['secret'])
            );
            // 设置需要检查哪些项
            $auth->setValidationConstraints(
                new IssuedBy($config['app']['name']), // 签发人
                new SignedWith(new Sha256(), new Key($config['auth']['secret'])), // 签名
                new ValidAt(new SystemClock()) // 签发时间、生效时间、过期时间
            );

            return $auth;
        });
    }
}