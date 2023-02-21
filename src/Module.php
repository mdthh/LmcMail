<?php
/**
 * @author Eric Richer <eric.richer@vistoconsulting.com>
 * @license BSD-3 Clause
 */
namespace LmcMail;

use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\ModuleManager\Feature\ServiceProviderInterface;
use LmcMail\Options\TransportOptions;
use LmcMail\Options\TransportOptionsFactory;
use LmcMail\Service\MessageService;
use LmcMail\Service\MessageServiceFactory;
use LmcMail\Service\TransportServiceFactory;
use LmcMail\View\MailViewRendererFactory;

class Module implements ConfigProviderInterface, ServiceProviderInterface
{

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig(): array
    {
        return [
            'factories' => [
                TransportOptions::class => TransportOptionsFactory::class,
                'lmc_mail_transport_service' => TransportServiceFactory::class,
                'lmc_mail_view_renderer' => MailViewRendererFactory::class,
                MessageService::class => MessageServiceFactory::class,
            ],
        ];
    }
}
