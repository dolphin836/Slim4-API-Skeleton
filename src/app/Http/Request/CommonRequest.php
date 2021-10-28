<?php

namespace Dolphin\Ting\Http\Request;

use Dolphin\Ting\Http\Exception\CommonException;
use Psr\Http\Message\ServerRequestInterface as Request;

class CommonRequest
{
    /**
     * @var array
     */
    private $body;

    /**
     * CommonRequest constructor.
     * @param Request $request
     */
    public function __construct (Request $request)
    {
        $this->body = $request->getParsedBody();
    }

    /**
     * @param  string $param
     * @param  string $paramType
     * @param  string $message
     *
     * @throws CommonException
     *
     * @author wanghaibing
     * @date   2020/9/15 11:04
     */
    public function isParamType ($param, $paramType = 'string', $message = '')
    {
        if (! call_user_func('is_' . $paramType, $this->body[$param])) {
            throw new CommonException('PARAMETER_TYPE_ERROR', [$param, $paramType], $message);
        }
    }

    /**
     * @param  string $param
     * @param  string $paramType
     * @param  string $message
     *
     * @throws CommonException
     *
     * @author wanghaibing
     * @date   2020/9/14 17:48
     */
    public function isNotNullRequestBodyParam ($param, $paramType = 'string', $message = '')
    {
        if (! isset($this->body[$param])) {
            throw new CommonException('PARAMETER_REQUIRED', [$param], $message);
        }

        $this->isParamType($param, $paramType, $message);
    }

    /**
     * @param  string $param
     * @param  string $paramType
     * @param  string $message
     *
     * @throws CommonException
     *
     * @author wanghaibing
     * @date   2020/9/15 11:04
     */
    public function isNotEmptyRequestBodyParam ($param, $paramType = 'string', $message = '')
    {
        $this->isNotNullRequestBodyParam($param, $paramType, $message);

        if (empty($this->body[$param])) {
            throw new CommonException('PARAMETER_IS_EMPTY', [$param], $message);
        }
    }

    /**
     * @param  string $param
     * @param  string $paramType
     * @param  string $message
     *
     * @throws CommonException
     *
     * @author wanghaibing
     * @date   2020/9/15 11:04
     */
    public function isRequestBodyParam ($param, $paramType = 'string', $message = '')
    {
        if (isset($this->body[$param])) {
            $this->isParamType($param, $paramType, $message);
        }
    }
}