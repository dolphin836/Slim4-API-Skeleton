<?php
// 用户信息
namespace Dolphin\Ting\Http\Entity;

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

    /** @Column(type="string") */
    private $last_sign_in_time;

    /**
     * @return int
     */
    public function getId () : int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId ($id) : void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsername () : string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername ($username) : void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword () : string
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
     * @return string
     */
    public function getLastSignInTime () : string
    {
        return $this->last_sign_in_time;
    }

    /**
     * @param string $last_sign_in_time
     */
    public function setLastSignInTime ($last_sign_in_time) : void
    {
        $this->last_sign_in_time = $last_sign_in_time;
    }
}