<?php

namespace Kuai6\Console\Service;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Kuai6\Console\Application;
use Zend\Console\Console;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;


/**
 * Class ApplicationFactory
 * @package Kuai6\Console\Service
 */
class ApplicationFactory implements FactoryInterface
{

    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return object
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $dispatcher = $container->get('Dispatcher');
        $applicationConfig = $container->get('ApplicationConfig');

        $config = $container->get('config');
        $routes = array_key_exists('routes', $config) ? $config['routes']: [];

        return new Application(
            $applicationConfig['name'],
            $applicationConfig['version'],
            $routes,
            Console::getInstance(),
            $dispatcher
        );
    }
}