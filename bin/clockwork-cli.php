<?php
require_once(dirname(__DIR__) . '/vendor/autoload.php');

use Clockwork\Cli\Application;

$application = new Application($argc > 1 ? array_slice($argv, 1) : array(getcwd()));

$application->run();
