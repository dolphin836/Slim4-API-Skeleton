<?php

namespace Dolphin\Ting\Http\Controller;

use Psr\Container\ContainerInterface as Container;

class Controller
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }
}