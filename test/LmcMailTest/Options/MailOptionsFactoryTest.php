<?php

namespace Options;

use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use LmcMail\Options\MailOptions;
use LmcMailTest\Util\ServiceManagerFactory;
use PHPUnit\Framework\TestCase;

class MailOptionsFactoryTest extends TestCase
{
    public function testCreateOptions()
    {
        $serviceManager = ServiceManagerFactory::getServiceManager();
        $mailOptions = $serviceManager->get(MailOptions::class);
        $this->assertInstanceOf(MailOptions::class, $mailOptions);
    }

    public function testCreateOptionsNotLmcConfig()
    {
        $config = require __DIR__ . '/../../TestConfigurationNoLmcMail.php';
        $serviceManager = ServiceManagerFactory::getServiceManager($config);
        $this->expectException(ServiceNotCreatedException::class);
        $mailOptions = $serviceManager->get(MailOptions::class);
    }
}
