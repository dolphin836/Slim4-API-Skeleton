<?php

namespace Dolphin\Ting\Http\Controller;

use DI\Container;
use Dolphin\Ting\Http\Business\UserBusiness;
use Dolphin\Ting\Http\Exception\DBException;
use Dolphin\Ting\Http\Request\UserIdRequest;
use Dolphin\Ting\Http\Request\UserRequest;
use Dolphin\Ting\Http\Response\BusinessResponse;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Dolphin\Ting\Http\Exception\UserException;
use Dolphin\Ting\Http\Exception\CommonException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

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
     * 用户详情
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
     * 用户列表
     *
     * @return Response
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getUserList () : Response
    {
        $data = $this->userBusiness->getUserList();

        return new BusinessResponse($data);
    }

    /**
     * 用户登录
     *
     * @param  Request $request
     *
     * @return Response
     *
     * @throws CommonException
     * @throws UserException
     * @throws DBException
     *
     * @author wanghaibing
     * @date   2020/10/13 11:50
     */
    public function signIn (Request $request) : Response
    {
        $this->userBusiness->signIn(new UserRequest($request));

        return new BusinessResponse([]);
    }
}