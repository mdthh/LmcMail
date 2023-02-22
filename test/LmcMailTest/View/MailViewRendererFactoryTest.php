<?php

namespace View;

use Laminas\Mvc\Service\ViewHelperManagerFactory;
use Laminas\ServiceManager\ServiceManager;
use Laminas\View\HelperPluginManager;
use Laminas\View\Renderer\PhpRenderer;
use Laminas\View\Resolver\AggregateResolver;
use LmcMail\Module;
use LmcMailTest\Util\ServiceManagerFactory;
use PHPUnit\Framework\TestCase;

class MailViewRendererFactoryTest extends TestCase
{
    protected ServiceManager $serviceManager;
    protected Module $module;

    public function setUp(): void
    {
        $this->module = new Module();
        $this->serviceManager = ServiceManagerFactory::getServiceManager();
    }

    public function testCreateRenderer()
    {
        $renderer = $this->serviceManager->get('lmc_mail_view_renderer');
        $this->assertInstanceOf(PhpRenderer::class, $renderer);
    }
}
