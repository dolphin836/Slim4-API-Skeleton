<?php
/**
 * 用户登录
 */
namespace Dolphin\Ting\Http\Controller\User;

use DI\DependencyException;
use DI\NotFoundException;
use Dolphin\Ting\Http\Constant\EntityConstant;
use Dolphin\Ting\Http\Constant\UserConstant;
use Dolphin\Ting\Http\Controller\Controller;
use Dolphin\Ting\Http\Exception\UserException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Doctrine\ORM\ORMInvalidArgumentException;
use Dolphin\Ting\Http\Entity\User;
use Dolphin\Ting\Http\Exception\CommonException;
use Dolphin\Ting\Http\Exception\DBException;
use Exception;
use DateTime;

class SignInController extends Controller
{
    /**
     * @param  Request  $request
     * @param  Response $response
     * @param  array    $args
     *
     * @throws CommonException
     * @throws ORMInvalidArgumentException
     * @throws DBException
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     *
     * @return Response
     */
    public function __invoke (Request $request, Response $response, $args) : Response
    {
        // 获取参数
        $data = $request->getParsedBody();
        // 参数校验
        $this->verification->run($data, [
            'username' => 'required|string|minLength:1|maxLength:64',
            'password' => 'required|string|minLength:6|maxLength:32'
        ]);

        $username = $data['username']; // 用户名
        $password = $data['password']; // 密码
        /** @var User $user */
        $user = $this->loadModel('User')->getOne(EntityConstant::User, ['username' => $username]);
        // 用户名不存在
        if (empty($user)) {
            throw new UserException('USERNAME_NON_EXIST', [$username]);
        }
        // 用户未激活
        if ($user->getIsActive() !== UserConstant::IS_ACTIVE) {
            throw new UserException('USERNAME_NOT_ACTIVE', [$username]);
        }
        // 密码错误
        if (! password_verify($password, $user->getPassword())) {
            throw new UserException('USERNAME_PASSWORD_ERROR', [$username]);
        }
        // 更新最后登录时间
        $user->setLastSignInTime(new DateTime());
        // 保存实体
        try {
            $this->loadModel('User')->saveOne($user);
        } catch (Exception $e) {
            throw new DBException($e);
        }
        // 输出
        $data = [
            'token' => $this->loadService('User')->getUserToken($user),
            'info'  => $this->loadService('User')->getUserInfo($user)
        ];

        return $this->respond($response, $data);
    }
}