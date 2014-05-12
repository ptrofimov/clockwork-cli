<?php
require_once(dirname(__DIR__) . '/vendor/autoload.php');

use Clockwork\Cli\Application;

$application = new Application(array_slice($argv, 1));

$application->run();
