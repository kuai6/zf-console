<?php

namespace Kuai6\Console;

use Zend\Console\Console;
use Zend\ServiceManager\ServiceManager;
use ZF\Console\Application as BaseApplication;
use ZF\Console\Dispatcher;

/**
 * Class Application
 * @package Kuai6\Console
 */
class Application extends BaseApplication
{

    /**
     * @param string $name
     * @param string $version
     * @param array $configuration
     * @return Application
     */
    public static function init(string $name, string $version, array $configuration = []) :Application
    {
        $smConfig = isset($configuration['service_manager']) ? $configuration['service_manager'] : [];
        $smConfig = new Service\ServiceManagerConfig($smConfig);
        $serviceManager = new ServiceManager();
        $smConfig->configureServiceManager($serviceManager);
        $serviceManager->setService('ApplicationConfig', $configuration);
        // Load modules
        $serviceManager->get('ModuleManager')->loadModules();

        $dispatcher = new Dispatcher($serviceManager);

        $config = $serviceManager->get('config');
        $routes = array_key_exists('routes', $config) ? $config['routes']: [];

        return new Application(
            $name,
            $version,
            $routes,
            Console::getInstance(),
            $dispatcher
        );
    }
}
