<?php

namespace Dolphin\Ting\Http\Business;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Dolphin\Ting\Bootstrap\Component\Queue;
use Dolphin\Ting\Http\Constant\QueueConstant;
use Dolphin\Ting\Http\Entity\UserSignIn;
use Dolphin\Ting\Http\Exception\DBException;
use Dolphin\Ting\Http\Exception\UserException;
use Dolphin\Ting\Http\Model\UserModel;
use Dolphin\Ting\Http\Model\UserSignInModel;
use Dolphin\Ting\Http\Request\UserIdRequest;
use Dolphin\Ting\Http\Request\UserRequest;
use Dolphin\Ting\Http\Response\UserListResponse;
use Dolphin\Ting\Http\Response\UserResponse;
use Exception;
use Psr\Container\ContainerInterface as Container;

class UserBusiness
{
    /**
     * @var Queue
     */
    private $queue;

    /**
     * @var UserModel
     */
    private $userModel;

    /**
     * @var UserSignInModel
     */
    private $userSignInModel;

    public function __construct (Container $container, UserModel $userModel, UserSignInModel $userSignInModel)
    {
        $this->queue           = $container->get('Queue');

        $this->userModel       = $userModel;

        $this->userSignInModel = $userSignInModel;
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
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     *
     * @author wanghaibing
     * @date   2020/9/14 14:40
     */
    public function getUserList ()
    {
        // 查询用户列表
        $userList = $this->userModel->getUserList();

        $userArr  = [];

        foreach ($userList as $user) {
            $userResponse = new UserResponse();
            $userResponse->setUserId($user->getId());
            $userResponse->setUsername($user->getUsername());

            $userArr[] = $userResponse;
        }
        // 查询用户数量
        $userTotal = $this->userModel->getUserTotal();
        // 设置 Response
        $userListResponse = new UserListResponse();
        $userListResponse->setUser($userArr);
        $userListResponse->setTotal($userTotal);

        return $userListResponse;
    }

    /**
     * 用户登录
     *
     * @param  UserRequest $userRequest
     *
     * @throws UserException
     * @throws DBException
     * @throws Exception
     *
     * @author wanghaibing
     * @date   2020/10/13 12:10
     */
    public function signIn (UserRequest $userRequest)
    {
        $username = $userRequest->getUsername();
        $password = $userRequest->getPassword();
        // 这里为了演示，密码直接使用了明文，请不要直接在实际项目中使用
        try {
            $user = $this->userModel->getUserByUsernameAndPassword($username, $password);
        } catch (NoResultException $e) {
            throw new UserException('USERNAME_NON_EXIST_OR_PASSWORD_ERROR');
        } catch (NonUniqueResultException $e) {
            throw new DBException($e);
        }
        // UserId
        $userId = $user->getId();
        // 开启事务
        $this->userModel->beginTransaction();

        try {
            // 更新最后登录时间
            $user->setLastSignInTime(date('Y-m-d H:i:s'));

            $this->userModel->save($user);
            // 添加登录记录
            $userSignIn = new UserSignIn();
            $userSignIn->setUserId($userId);
            $userSignIn->setIpAddress('127.0.0.1');
            $userSignIn->setSignInTime(date('Y-m-d H:i:s'));

            $this->userSignInModel->save($userSignIn);
            // 提交事务
            $this->userModel->commit();
        } catch (Exception $e) {
            // 回滚事务
            $this->userModel->rollback();
        }
        // 发送 MQ 消息
        $message = [
            'user_id' => $userId
        ];

        $this->queue->connection(QueueConstant::VIRTUAL_HOST_DEFAULT);
        $this->queue->send(json_encode($message), QueueConstant::EXCHANGE_DEFAULT);
    }
}