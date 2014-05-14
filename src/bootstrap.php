<?php

if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once(__DIR__ . '/../vendor/autoload.php');
} elseif (file_exists(__DIR__ . '/../../../autoload.php')) {
    require_once(__DIR__ . '/../../../autoload.php');
} else {
    echo 'You need to install dependencies https://getcomposer.org/doc/00-intro.md#using-composer', PHP_EOL;
    exit(1);
}
