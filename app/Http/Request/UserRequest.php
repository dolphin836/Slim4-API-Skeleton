<?php

namespace Dolphin\Ting\Http\Request;

use Dolphin\Ting\Http\Exception\CommonException;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserRequest extends CommonRequest
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * UserIdRequest constructor.
     * @param  Request $request
     * @throws CommonException
     */
    public function __construct (Request $request)
    {
        parent::__construct($request);

        $body = $request->getParsedBody();

        $this->isNotNullRequestBodyParam('username', 'string');
        $this->isNotNullRequestBodyParam('password', 'string');

        $this->setUsername($body['username']);
        $this->setPassword($body['password']);
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

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}