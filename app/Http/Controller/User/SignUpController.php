<?php
/**
 * 用户注册
 */
namespace Dolphin\Ting\Http\Controller\User;

use Defuse\Crypto\Exception\EnvironmentIsBrokenException;
use Defuse\Crypto\Exception\WrongKeyOrModifiedCiphertextException;
use DI\DependencyException;
use DI\NotFoundException;
use Dolphin\Ting\Http\Constant\ApplicationConstant;
use Dolphin\Ting\Http\Constant\CategoryConstant;
use Dolphin\Ting\Http\Constant\QueueConstant;
use Dolphin\Ting\Http\Constant\UserConstant;
use Dolphin\Ting\Http\Controller\Controller;
use Dolphin\Ting\Http\Entity\Application;
use Dolphin\Ting\Http\Entity\Category;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Doctrine\ORM\ORMInvalidArgumentException;
use Dolphin\Ting\Http\Entity\User;
use Dolphin\Ting\Http\Exception\CommonException;
use Dolphin\Ting\Http\Exception\DBException;
use Exception;
use DateTime;
use RandomLib\Factory as RandomFactory;
use SecurityLib\Strength;
use Defuse\Crypto\Key;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\KeyProtectedByPassword;

class SignUpController extends Controller
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
     * @throws EnvironmentIsBrokenException
     * @throws WrongKeyOrModifiedCiphertextException
     * @throws Exception
     *
     * @return Response
     */
    public function __invoke (Request $request, Response $response, $args) : Response
    {
        // 获取参数
        $body = $request->getParsedBody();
        // 参数校验
        $this->verification->run($body, [
            'username' => 'required|string|minLength:1|maxLength:64|isUnique:user.username',
            'password' => 'required|string|minLength:6|maxLength:32',
            'email'    => 'required|string|minLength:3|maxLength:255|isUnique:user.email',
        ]);

        $username = $body['username']; // 用户名
        $password = $body['password']; // 密码
        $email    = $body['email']; // 密码
        // 生成随机的密钥
        $randomFactory   = new RandomFactory();
        $randomGenerator = $randomFactory->getGenerator(new Strength(Strength::MEDIUM));
        $randomSecretKey = $randomGenerator->generateString(32);
        //
        // 用户密钥 + 公共密钥组成完整的密钥
        $fullSecretKey        = $randomSecretKey . getenv('PASSWORD_SECRET');
        // 使用密钥生成加密需要的受保护的密钥
        $passwordProtectedKey = KeyProtectedByPassword::createRandomPasswordProtectedKey($fullSecretKey);
        // 解锁受保护的密钥，获得可用于加密和解密的密钥
        /** @var Key $key */
        $enKey                = $passwordProtectedKey->unlockKey($fullSecretKey);
        // 加密密码
        $enPassword           = Crypto::encrypt($password, $enKey);
        // 实例化 User 实体
        $user = New User();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
        $user->setSecretKey($randomSecretKey);
        $user->setIsActive(UserConstant::NOT_ACTIVE);
        $user->setLastSignInTime(new DateTime());
        $user->setLastUpdateTime(new DateTime());
        // 为新用户创建一个默认分类：实例化 Category 实体
        $category = New Category();
        $category->setName('默认分类');
        $category->setOrderNumber(0);
        $category->setPasswordCount(1);
        $category->setLastUpdateTime(new DateTime());
        $category->setIsDefault(CategoryConstant::IS_DEFAULT);
        // 默认添加 36Password，实例化 Password 实体
        $password = new Application();
        $password->setName('36Password');
        // 工具类
        $password->setType(ApplicationConstant::APPLICATION_TYPE_TOOL);
        $password->setHttpAddress('https://36password.com');
        $password->setAccount($username);
        $password->setPassword($enPassword);
        $password->setPasswordSecret($passwordProtectedKey->saveToAsciiSafeString());
        // 目前只支持 web
        $password->setClient(ApplicationConstant::APPLICATION_CLIENT_WEB);
        $password->setPayEndDay(new DateTime('1970-01-01'));
        $password->setInsertTime(new DateTime());
        $password->setLastUpdateTime(new DateTime());
        // 保存数据
        // 开启事务
        $this->beginTransaction();

        try {
            // 保存用户
            $this->loadModel('User')->saveOne($user);
            // 用户 Id
            $userId = $user->getId();
            // 保存分类
            $category->setUserId($userId);
            $this->loadModel('Category')->saveOne($category);
            $categoryId = $category->getId();
            // 保存密码
            $password->setUserId($userId);
            $password->setCategoryId($categoryId);
            $this->loadModel('Application')->saveOne($password);
            // 提交事务
            $this->commitTransaction();
        } catch (Exception $e) {
            // 回滚事务
            $this->rollbackTransaction();

            throw new DBException($e);
        }
        // 用户注册成功消息
        $message = [
            'userId' => $userId,
            'email'  => $email
        ];

        try {
            $this->mq->connection(QueueConstant::NewUser['virtualHost']);
            $this->mq->send(json_encode($message), QueueConstant::NewUser['exchange']);
        } catch (Exception $e) {

        }
        // 输出
        $data = $this->loadService('User')->getUserInfo($user);;

        return $this->respond($response, $data);
    }
}