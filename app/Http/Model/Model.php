<?php

namespace Dolphin\Ting\Http\Model;

use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface as Container;

class Model
{
    /** @var EntityManager */
    protected $entityManager;

    function __construct(Container $container)
    {
        $this->entityManager = $container->get('EntityManager');
    }
}