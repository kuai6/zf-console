<?php

namespace Kuai6\Console\Service;

use Interop\Container\ContainerInterface;
use Zend\EventManager\EventManager;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class EventManagerFactory
 * @package Kuai6\Console\Service
 */
class EventManagerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $name
     * @param array|null $options
     * @return object|EventManager
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $name, array $options = null)
    {
        $shared = $container->has('SharedEventManager') ? $container->get('SharedEventManager') : null;
        return new EventManager($shared);
    }
}
