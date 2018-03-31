<?php

namespace Kuai6\Console\Command;

use ZF\Console\Route;
use Zend\Console\Adapter\AdapterInterface as Console;

/**
 * Interface CommandInterface
 * @package Kuai6\Console\Command
 */
interface CommandInterface
{
    /**
     * @param Route $route
     * @param Console $console
     * @return mixed
     */
    public function __invoke(Route $route, Console $console);
}