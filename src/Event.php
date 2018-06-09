<?php

namespace Kuai6\Console;

/**
 * Class Event
 * @package Kuai6\Console
 */
class Event extends \Zend\EventManager\Event
{
    public const OPTION_APPLICATION     = 'Application';
    public const OPTION_SERVICE_MANAGER = 'ServiceManager';
    public const OPTION_EVENT_MANAGER   = 'EventManager';

    public const EVENT_BOOTSTRAP    = 'bootstrap';
}
