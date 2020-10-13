<?php
// 用户登录记录
namespace Dolphin\Ting\Http\Entity;

use DateTime;

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

    /** @Column(type="datetime") */
    private $sign_in_time;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getIpAddress()
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
     * @return DateTime
     */
    public function getSignInTime()
    {
        return $this->sign_in_time;
    }

    /**
     * @param DateTime $sign_in_time
     */
    public function setSignInTime($sign_in_time): void
    {
        $this->sign_in_time = $sign_in_time;
    }
}