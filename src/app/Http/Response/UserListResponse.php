<?php
// 用户列表
namespace Dolphin\Ting\Http\Response;

use JsonSerializable;

class UserListResponse implements JsonSerializable
{
    /**
     * @var integer
     */
    private $total;

    /**
     * @var UserResponse[]
     */
    private $user;

    public function jsonSerialize ()
    {
        return [
            'total' => $this->getTotal(),
             'user' => $this->getUser()
        ];
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @param int $total
     */
    public function setTotal(int $total): void
    {
        $this->total = $total;
    }

    /**
     * @return UserResponse[]
     */
    public function getUser(): array
    {
        return $this->user;
    }

    /**
     * @param UserResponse[] $user
     */
    public function setUser(array $user): void
    {
        $this->user = $user;
    }
}