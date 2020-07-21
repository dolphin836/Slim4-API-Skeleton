<?php

namespace Dolphin\Ting\Http\Controller\User;

use DI\DependencyException;
use DI\NotFoundException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Dolphin\Ting\Http\Constant\EntityConstant;
use Dolphin\Ting\Http\Controller\Controller;
use Dolphin\Ting\Http\Entity\User;
use Dolphin\Ting\Http\Exception\CommonException;
use Dolphin\Ting\Http\Exception\UserException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController extends Controller
{
    /**
     * @param  Request  $request
     * @param  Response $response
     * @param  array    $args
     *
     * @throws CommonException
     * @throws ORMInvalidArgumentException
     * @throws DependencyException
     * @throws NotFoundException
     *
     * @return Response
     */
    public function __invoke (Request $request, Response $response, $args) : Response
    {
        // UserId
        $userId = $request->getAttribute('UserId');
        /** @var User $user */
        $user   = $this->loadModel('User')->getOne(EntityConstant::User, ['id' => $userId]);
        // 不存在
        if (empty($user)) {
            throw new UserException('USERNAME_NON_EXIST');
        }
        // 输出
        $data = $this->loadService('User')->getUserInfo($user);

        return $this->respond($response, $data);
    }
}