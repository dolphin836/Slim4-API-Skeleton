<?php

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
    private $email;

    /** @Column(type="string", length=255) */
    private $password;

    /** @Column(type="string", length=255) */
    private $secret_key;

    /** @Column(type="integer", name="is_active") */
    private $isActive;

    /** @Column(type="datetime") */
    private $last_sign_in_time;

    /** @Column(type="datetime") */
    private $last_update_time;

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
    public function getEmail ()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail ($email) : void
    {
        $this->email = $email;
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
     * @return mixed
     */
    public function getSecretKey ()
    {
        return $this->secret_key;
    }

    /**
     * @param mixed $secret_key
     */
    public function setSecretKey ($secret_key) : void
    {
        $this->secret_key = $secret_key;
    }

    /**
     * @return integer
     */
    public function getIsActive ()
    {
        return $this->isActive;
    }

    /**
     * @param integer $isActive
     */
    public function setIsActive ($isActive)
    {
        $this->isActive = $isActive;
    }

    /**
     * @return DateTime
     */
    public function getLastSignInTime ()
    {
        return $this->last_sign_in_time;
    }

    /**
     * @param mixed $last_sign_in_time
     */
    public function setLastSignInTime ($last_sign_in_time) : void
    {
        $this->last_sign_in_time = $last_sign_in_time;
    }

    /**
     * @return DateTime
     */
    public function getLastUpdateTime ()
    {
        return $this->last_update_time;
    }

    /**
     * @param mixed $last_update_time
     */
    public function setLastUpdateTime ($last_update_time) : void
    {
        $this->last_update_time = $last_update_time;
    }
}