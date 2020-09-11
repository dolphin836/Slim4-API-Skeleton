<?php

namespace Dolphin\Ting\Http\Controller;

use DI\Container;
use Doctrine\ORM\ORMInvalidArgumentException;
use Dolphin\Ting\Http\Business\UserBusiness;
use Dolphin\Ting\Http\Exception\CommonException;
use Dolphin\Ting\Http\Response\BusinessResponse;
use Dolphin\Ting\Http\Response\UserResponse;
use Psr\Http\Message\ResponseInterface as Response;

class UserController extends Controller
{
    /**
     * @var UserBusiness
     */
    private $userBusiness;

    public function __construct(Container $container, UserBusiness $userBusiness)
    {
        parent::__construct($container);

        $this->userBusiness = $userBusiness;
    }

    /**
     * 查询用户信息
     *
     * @throws CommonException
     * @throws ORMInvalidArgumentException
     *
     * @return Response
     */
    public function getUser () : Response
    {
        $userId = 1;
        $user   = $this->userBusiness->getUserById($userId);

        $userResponse = new UserResponse();
        $userResponse->setUserId($user->getId());
        $userResponse->setUsername($user->getUsername());

        return new BusinessResponse($userResponse);
    }
}