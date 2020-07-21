<?php
// 激活
namespace Dolphin\Ting\Http\Controller\User;

use DateTime;
use DI\DependencyException;
use DI\NotFoundException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Dolphin\Ting\Http\Constant\CacheConstant;
use Dolphin\Ting\Http\Constant\EntityConstant;
use Dolphin\Ting\Http\Constant\UserConstant;
use Dolphin\Ting\Http\Controller\Controller;
use Dolphin\Ting\Http\Entity\User;
use Dolphin\Ting\Http\Exception\CommonException;
use Dolphin\Ting\Http\Exception\DBException;
use Dolphin\Ting\Http\Exception\UserException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Exception;

class ConfirmController extends Controller
{
    /**
     * @param  Request  $request
     * @param  Response $response
     * @param  array    $args
     *
     * @throws ORMInvalidArgumentException
     * @throws CommonException
     * @throws DependencyException
     * @throws NotFoundException
     * @throws Exception
     *
     * @return Response
     */
    public function __invoke (Request $request, Response $response, $args) : Response
    {
        $queryParams = $request->getQueryParams();

        if (empty($queryParams['userId']) || empty($queryParams['code'])) {
            throw new CommonException('UNKNOWN_ERROR');
        }
        // UserId
        $userId = (int) $queryParams['userId'];
        /** @var User $user */
        $user   = $this->loadModel('User')->getOne(EntityConstant::User, ['id' => $userId]);
        // 不存在
        if (empty($user)) {
            throw new UserException('USERNAME_NON_EXIST');
        }
        // 重复激活
        if ($user->getIsActive() !== UserConstant::NOT_ACTIVE) {
            throw new UserException('USERNAME_REPEAT_ACTIVE');
        }
        // 激活码
        $code      = (string) $queryParams['code'];
        // 查询激活码缓存
        $cacheKey  = CacheConstant::CACHE_KEY_NEW_USER_MAIL . $userId;
        $cacheCode = $this->cache->get($cacheKey);

        if (empty($cacheCode) || $code !== $cacheCode) {
            throw new UserException('USERNAME_ACTIVE_FAIL');
        }
        // 激活用户
        $user->setIsActive(UserConstant::IS_ACTIVE);
        $user->setLastUpdateTime(new DateTime());
        // 保存数据
        // 开启事务
        $this->beginTransaction();

        try {
            // 保存用户
            $this->loadModel('User')->saveOne($user);
            // 删除缓存
             $this->cache->del($cacheKey);
            // 提交事务
            $this->commitTransaction();
        } catch (Exception $e) {
            // 回滚事务
            $this->rollbackTransaction();

            throw new DBException($e);
        }

        return $this->respond($response, []);
    }
}