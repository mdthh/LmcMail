<?php

namespace LmcMailTest\Util;

use Laminas\ModuleManager\ModuleManager;
use Laminas\Mvc\Service\ServiceManagerConfig;
use Laminas\ServiceManager\ServiceManager;

abstract class ServiceManagerFactory
{
    private static array $config = [];

    public static function setApplicationConfig(array $config): void
    {
        static::$config = $config;
    }

    public static function getApplicationConfig(): array
    {
        return static::$config;
    }

    public static function getServiceManager(array $config=null): ServiceManager
    {
        $config = $config ?: static::getApplicationConfig();
        $serviceManagerConfig = new ServiceManagerConfig(
            $config['service_manager'] ?? []
        );
        $serviceManager = new ServiceManager();
        $serviceManagerConfig->configureServiceManager($serviceManager);
        $serviceManager->setService('ApplicationConfig', $config);
        $serviceManager->setAllowOverride(true);

        /** @var ModuleManager $moduleManager */
        $moduleManager = $serviceManager->get('ModuleManager');
        $moduleManager->loadModules();

        return $serviceManager;
    }
}
