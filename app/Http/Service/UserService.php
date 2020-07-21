<?php

namespace Dolphin\Ting\Http\Service;

use DateTimeImmutable;
use Dolphin\Ting\Http\Constant\EntityConstant;
use Dolphin\Ting\Http\Exception\UserException;
use Dolphin\Ting\Http\Model\UserModel;
use Lcobucci\JWT\Configuration;
use Psr\Container\ContainerInterface as Container;
use RandomLib\Factory as RandomFactory;
use SecurityLib\Strength;
use Dolphin\Ting\Http\Entity\User;
use Exception;

class UserService extends Service
{
    private $userModel;

    public function __construct (Container $container)
    {
        parent::__construct($container);

        $this->userModel = new UserModel($container);
    }

    /**
     * 获取用户 Token
     *
     * @param User $user
     *
     * @return string
     *
     * @throws Exception
     *
     * @author 王海兵
     * @create 2019-11-26 11:18:08
     */
    public function getUserToken (User $user)
    {
        // 配置
        $config     = $this->container->get('Config');
        /** @var Configuration $auth */
        $auth       = $this->container->get('Auth');
        // 用户信息
        $userId     = $user->getId();
        $userName   = $user->getUsername();
        // 当前时间
        $now        = new DateTimeImmutable();
        // 过期时间
        $expireTime = $now->modify('+' . (int) $config['auth']['expireTime'] . ' second');
        // 随机字符串
        $randomFactory   = new RandomFactory();
        $randomGenerator = $randomFactory->getGenerator(new Strength(Strength::MEDIUM));
        $randomCode      = $randomGenerator->generateString(32);
        // 生成令牌
        $token = $auth->createBuilder()
                      ->issuedBy($config['app']['name']) // 签发人，应用名称或者应用地址
                      ->permittedFor($userName) // 受众，应用名称或者应用地址，单个的时候设置为字符串，多个的设置为字符串数组
                      ->identifiedBy($randomCode) // JWT ID 唯一标识符，可防止重放攻击
                      ->issuedAt($now) // 令牌发布时间
                      ->canOnlyBeUsedAfter($now) // 令牌生效时间，为了兼容和客户端的时钟误差问题
                      ->expiresAt($expireTime) // 令牌过期时间
                      ->withClaim('UserId', $userId) // 自定义数据
                      ->withClaim('UserName', $userName) // 自定义数据
                      ->getToken( // 生成令牌
                          $auth->getSigner(),
                          $auth->getSigningKey()
                      );

        return (string) $token;
    }

    /**
     * 用户详情
     *
     * @param  User $user
     *
     * @return array
     *
     * @author 王海兵
     * @create 2019-11-26 11:18:08
     */
    public function getUserInfo (User $user)
    {
        return [
            'user_id'           => $user->getId(),
            'username'          => $user->getUsername(),
            'secret_key'        => $user->getSecretKey(),
            'last_sign_in_time' => $user->getLastSignInTime()->format('Y-m-d H:i:s'),
            'last_update_time'  => $user->getLastUpdateTime()->format('Y-m-d H:i:s')
        ];
    }

    /**
     * @param  integer       $userId
     * @throws UserException
     * @return string
     */
    public function getUserSecretKey ($userId)
    {
        /** @var User $user */
        $user = $this->userModel->getOne(EntityConstant::User, ['id' => $userId]);
        // 不存在
        if (empty($user)) {
            throw new UserException('USERNAME_NON_EXIST');
        }

        return $user->getSecretKey();
    }
}