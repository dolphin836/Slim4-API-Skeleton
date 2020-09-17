<?php

namespace Dolphin\Ting\Http\Controller;

use DI\Container;
use Dolphin\Ting\Http\Business\UserBusiness;
use Dolphin\Ting\Http\Request\UserIdRequest;
use Dolphin\Ting\Http\Response\BusinessResponse;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Dolphin\Ting\Http\Exception\UserException;
use Dolphin\Ting\Http\Exception\CommonException;

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
     * 用户信息
     *
     * @param  Request $request
     *
     * @return Response
     *
     * @throws UserException
     * @throws CommonException
     */
    public function getUser (Request $request) : Response
    {
        $data = $this->userBusiness->getUserById(new UserIdRequest($request));

        return new BusinessResponse($data);
    }

    /**
     * 查询用户列表
     *
     * @return Response
     */
    public function getUserList () : Response
    {
        $data = $this->userBusiness->getUserList();

        return new BusinessResponse($data);
    }
}