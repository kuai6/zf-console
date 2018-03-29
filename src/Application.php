<?php

namespace Kuai6\Console;

use Zend\ServiceManager\ServiceManager;
use ZF\Console\Application as BaseApplication;

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
    public static function init(array $configuration = []) :Application
    {
        $smConfig = isset($configuration['service_manager']) ? $configuration['service_manager'] : [];
        $smConfig = new Service\ServiceManagerConfig($smConfig);
        $serviceManager = new ServiceManager();
        $smConfig->configureServiceManager($serviceManager);
        $serviceManager->setService('ApplicationConfig', $configuration);
        // Load modules
        $serviceManager->get('ModuleManager')->loadModules();

        return $serviceManager->get('Application');
    }
}
