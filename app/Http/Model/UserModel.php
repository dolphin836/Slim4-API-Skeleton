<?php

namespace Dolphin\Ting\Http\Model;

use Dolphin\Ting\Http\Constant\EntityConstant;
use Dolphin\Ting\Http\Entity\User;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\NonUniqueResultException;

class UserModel extends Model
{
    /**
     * 查询所有用户记录
     *
     * @return User[]
     *
     * @author wanghaibing
     * @date   2020/9/14 14:38
     */
    public function getUserList ()
    {
        return $this->entityManager->createQueryBuilder()
                                   ->select('u')
                                   ->from(EntityConstant::User, 'u')
                                   ->orderBy('u.id', 'DESC')
                                   ->getQuery()
                                   ->getResult();
    }

    /**
     * 查询用户记录总数
     *
     * @return integer
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     *
     * @author wanghaibing
     * @date   2020/10/13 11:23
     */
    public function getUserTotal ()
    {
        return $this->entityManager->createQueryBuilder()
                                   ->select('count(u.id)')
                                   ->from(EntityConstant::User, 'u')
                                   ->getQuery()
                                   ->getSingleScalarResult();
    }

    /**
     * 根据 Id 查询用户记录
     *
     * @param  integer $userId
     *
     * @return User
     *
     * @author wanghaibing
     * @date   2020/9/14 14:46
     */
    public function getUserById ($userId)
    {
        /** @var User $user */
        $user = $this->entityManager->getRepository(EntityConstant::User)->findOneBy(['id' => $userId]);

        return $user;
    }

    /**
     * 根据用户名和密码查询用户记录
     *
     * @param  string $username
     * @param  string $password
     *
     * @return User
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     *
     * @author wanghaibing
     * @date   2020/10/13 12:15
     */
    public function getUserByUsernameAndPassword ($username, $password)
    {
        $param = [
            'username' => $username,
            'password' => $password
        ];

        return $this->entityManager->createQueryBuilder()
                                   ->select('u')
                                   ->from(EntityConstant::User, 'u')
                                   ->where('u.username = :username AND u.password = :password')
                                   ->setParameters($param)
                                   ->getQuery()
                                   ->getSingleResult();
    }
}