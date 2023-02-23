<?php

ini_set('error_reporting', E_ALL);

if (!file_exists(__DIR__ . '/../vendor/autoload.php')) {
    throw new RuntimeException('vendor/autoload.php could not be found. Did you install via composer?');
}
$loader = require __DIR__ . '/../vendor/autoload.php';
$loader->add('LmcMailTest\\', __DIR__);

$config = require __DIR__ . '/TestConfiguration.php';
\LmcMailTest\Util\ServiceManagerFactory::setApplicationConfig($config);
unset($loader, $config);

