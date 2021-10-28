<?php

namespace Dolphin\Ting\Http\Request;

use Dolphin\Ting\Http\Exception\CommonException;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserIdRequest extends CommonRequest
{
    /**
     * @var integer
     */
    private $userId;

    /**
     * UserIdRequest constructor.
     * @param  Request $request
     * @throws CommonException
     */
    public function __construct (Request $request)
    {
        parent::__construct($request);

        $body = $request->getParsedBody();

        $this->isNotNullRequestBodyParam('user_id', 'numeric');

        $this->setUserId((int) $body['user_id']);
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
}