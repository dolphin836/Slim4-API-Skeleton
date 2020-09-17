<?php

namespace Dolphin\Ting\Http\Business;

use Dolphin\Ting\Http\Exception\UserException;
use Dolphin\Ting\Http\Model\UserModel;
use Dolphin\Ting\Http\Request\UserIdRequest;
use Dolphin\Ting\Http\Response\UserListResponse;
use Dolphin\Ting\Http\Response\UserResponse;

class UserBusiness
{
    private $userModel;

    public function __construct (UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    /**
     * @param  UserIdRequest $request
     *
     * @throws UserException
     *
     * @return UserResponse
     *
     * @author wanghaibing
     * @date   2020/8/21 9:32
     */
    public function getUserById (UserIdRequest $request)
    {
        $userId = $request->getUserId();
        $user   = $this->userModel->getUserById($userId);
        // 不存在
        if (empty($user)) {
            throw new UserException('USERNAME_NON_EXIST');
        }

        $userResponse = new UserResponse();
        $userResponse->setUserId($user->getId());
        $userResponse->setUsername($user->getUsername());

        return $userResponse;
    }

    /**
     * 用户列表
     *
     * @return UserListResponse
     * @author wanghaibing
     * @date   2020/9/14 14:40
     */
    public function getUserList ()
    {
        $userList = $this->userModel->getUserList();

        $userArr  = [];

        foreach ($userList as $user) {
            $userResponse = new UserResponse();
            $userResponse->setUserId($user->getId());
            $userResponse->setUsername($user->getUsername());

            $userArr[] = $userResponse;
        }

        $userListResponse = new UserListResponse();
        $userListResponse->setUser($userArr);
        $userListResponse->setTotal(1);

        return $userListResponse;
    }
}