<?php
// 用户信息
namespace Dolphin\Ting\Http\Entity;

use DateTime;

/** @Entity @Table(name="user") */
class User
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /** @Column(type="string", length=64) */
    private $username;

    /** @Column(type="string", length=255) */
    private $password;

    /** @Column(type="datetime") */
    private $last_sign_in_time;

    /**
     * @return mixed
     */
    public function getId ()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId ($id) : void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUsername ()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername ($username) : void
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getPassword ()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword ($password) : void
    {
        $this->password = $password;
    }

    /**
     * @return DateTime
     */
    public function getLastSignInTime ()
    {
        return $this->last_sign_in_time;
    }

    /**
     * @param DateTime $last_sign_in_time
     */
    public function setLastSignInTime ($last_sign_in_time) : void
    {
        $this->last_sign_in_time = $last_sign_in_time;
    }
}