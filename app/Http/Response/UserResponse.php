<?php
// 用户信息
namespace Dolphin\Ting\Http\Response;

use JsonSerializable;

class UserResponse implements JsonSerializable
{
    /**
     * @var integer
     */
    private $userId;

    /**
     * @var string
     */
    private $username;

    public function jsonSerialize ()
    {
        return [
             'user_id' => $this->getUserId(),
            'username' => $this->getUsername()
        ];
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }
}