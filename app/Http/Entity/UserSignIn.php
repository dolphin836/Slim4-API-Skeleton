<?php
// 用户登录记录
namespace Dolphin\Ting\Http\Entity;

/** @Entity @Table(name="user_sign_in") */
class UserSignIn
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /** @Column(type="integer") */
    private $user_id;

    /** @Column(type="string", length=255) */
    private $ip_address;

    /** @Column(type="string") */
    private $sign_in_time;

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getUserId() : int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return string
     */
    public function getIpAddress() : string
    {
        return $this->ip_address;
    }

    /**
     * @param mixed $ip_address
     */
    public function setIpAddress($ip_address): void
    {
        $this->ip_address = $ip_address;
    }

    /**
     * @return string
     */
    public function getSignInTime() : string
    {
        return $this->sign_in_time;
    }

    /**
     * @param string $sign_in_time
     */
    public function setSignInTime($sign_in_time): void
    {
        $this->sign_in_time = $sign_in_time;
    }
}