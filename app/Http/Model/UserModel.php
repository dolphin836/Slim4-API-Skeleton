<?php

namespace Dolphin\Ting\Http\Model;

use Dolphin\Ting\Http\Constant\EntityConstant;
use Dolphin\Ting\Http\Entity\User;

class UserModel extends Model
{
    /**
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
     * @param  integer $userId
     * @return User
     * @author wanghaibing
     * @date   2020/9/14 14:46
     */
    public function getUserById ($userId)
    {
        /** @var User $user */
        $user = $this->entityManager->getRepository(EntityConstant::User)->findOneBy(['id' => $userId]);

        return $user;
    }
}