<?php

namespace Dolphin\Ting\Http\Service;

use Dolphin\Ting\Http\Model\UserModel;
use Psr\Container\ContainerInterface as Container;
use Dolphin\Ting\Http\Entity\User;

class UserService extends Service
{
    private $userModel;

    public function __construct (Container $container)
    {
        parent::__construct($container);

        $this->userModel = new UserModel($container);
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
}