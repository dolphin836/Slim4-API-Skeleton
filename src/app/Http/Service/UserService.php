<?php

namespace Dolphin\Ting\Http\Service;

use Dolphin\Ting\Http\Model\UserModel;
use Psr\Container\ContainerInterface as Container;

class UserService extends Service
{
    private $userModel;

    public function __construct (Container $container)
    {
        parent::__construct($container);

        $this->userModel = new UserModel($container);
    }
}