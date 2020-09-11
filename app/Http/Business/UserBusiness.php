<?php

namespace Dolphin\Ting\Http\Business;

use Dolphin\Ting\Http\Constant\EntityConstant;
use Dolphin\Ting\Http\Entity\User;
use Dolphin\Ting\Http\Exception\UserException;
use Dolphin\Ting\Http\Model\UserModel;

class UserBusiness
{
    private $userModel;

    public function __construct (UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    /**
     * @param  $userId
     *
     * @throws UserException
     *
     * @return User
     *
     * @author wanghaibing
     * @date   2020/8/21 9:32
     */
    public function getUserById ($userId)
    {
        /** @var User $user */
        $user = $this->userModel->getOne(EntityConstant::User, ['id' => $userId]);
        // 不存在
        if (empty($user)) {
            throw new UserException('USERNAME_NON_EXIST');
        }

        return $user;
    }
}