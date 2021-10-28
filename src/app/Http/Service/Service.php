<?php

namespace Dolphin\Ting\Http\Service;

use Psr\Container\ContainerInterface as Container;

class Service
{
    /**
     * @var Container
     */
    protected $container;

    function __construct(Container $container)
    {
        $this->container = $container;
    }
}