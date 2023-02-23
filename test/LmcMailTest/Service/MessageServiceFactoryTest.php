<?php

namespace Service;

use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use LmcMail\Module;
use Laminas\ServiceManager\ServiceManager;
use LmcMail\Service\MessageService;
use LmcMailTest\Util\ServiceManagerFactory;

class MessageServiceFactoryTest extends \PHPUnit\Framework\TestCase
{
    protected ServiceManager|null $serviceManager;
    protected Module|null $module;

    public function setUp(): void
    {
        $this->module = new Module();
        $this->serviceManager = ServiceManagerFactory::getServiceManager();
    }

    public function tearDown(): void
    {
        $this->serviceManager = null;
        $this->module = null;
    }

    public function testCreateMessageService()
    {
        $service = $this->serviceManager->get(MessageService::class);
        $this->assertInstanceOf(MessageService::class, $service);
    }

    public function testNoLmcMailConfig()
    {
        // Need to get a different config file
        $config = require __DIR__ . '/../../TestConfigurationNoLmcMail.php';
        $serviceManager = ServiceManagerFactory::getServiceManager($config);
        $this->expectException(ServiceNotCreatedException::class);
        $service = $serviceManager->get(MessageService::class);
    }
}
