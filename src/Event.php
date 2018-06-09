<?php

namespace Kuai6\Console;

/**
 * Class Event
 * @package Kuai6\Console
 */
class Event extends \Zend\EventManager\Event
{
    public const OPTION_APPLICATION = 'application';

    public const EVENT_BOOTSTRAP    = 'bootstrap';
}
