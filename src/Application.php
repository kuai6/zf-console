<?php

namespace Kuai6\Console;

use Interop\Container\ContainerInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\ServiceManager\ServiceManager;
use ZF\Console\Application as BaseApplication;

/**
 * Class Application
 * @package Kuai6\Console
 */
class Application extends BaseApplication
{
    /**
     * @var EventManagerInterface
     */
    private $eventManager;

    /**
     * @var ContainerInterface
     */
    private $serviceManager;

    /**
     * Set the event manager instance
     *
     * @param  EventManagerInterface $eventManager
     * @return Application
     */
    public function setEventManager(EventManagerInterface $eventManager): self
    {
        $eventManager->setIdentifiers([
            __CLASS__,
            get_class($this),
        ]);
        $this->eventManager = $eventManager;
        return $this;
    }

    /**
     * Retrieve the event manager
     *
     * Lazy-loads an EventManager instance if none registered.
     *
     * @return EventManagerInterface
     */
    public function getEventManager(): ?EventManagerInterface
    {
        return $this->eventManager;
    }

    /**
     * @return ContainerInterface
     */
    public function getServiceManager(): ContainerInterface
    {
        return $this->serviceManager;
    }

    /**
     * @param ContainerInterface $serviceManager
     */
    public function setServiceManager(ContainerInterface $serviceManager): void
    {
        $this->serviceManager = $serviceManager;
    }

    /**
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

        /** @var Application $application */
        $application = $serviceManager->get('Application');
        $application->setEventManager($serviceManager->get('EventManager'));
        $application->setServiceManager($serviceManager);

        return $application;
    }

    /**
     * @param array $listeners
     * @return $this
     */
    public function bootstrap(array $listeners = [])
    {
        foreach ($listeners as $listener) {
            $this->getServiceManager()->get($listener)->attach($this->eventManager);
        }

        // Setup MVC Event
        $event  = new Event();
        $event->setName(Event::EVENT_BOOTSTRAP);
        $event->setTarget($this);
        $event->setParam(Event::OPTION_APPLICATION, $this);
        $event->setParam(Event::OPTION_SERVICE_MANAGER, $this->getServiceManager());
        $event->setParam(Event::OPTION_EVENT_MANAGER, $this->getEventManager());

        // Trigger bootstrap events
        $this->eventManager->triggerEvent($event);

        return $this;
    }
}
