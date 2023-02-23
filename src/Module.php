<?php
/**
 * @author Eric Richer <eric.richer@vistoconsulting.com>
 * @license BSD-3 Clause
 */
namespace LmcMail;

use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\ModuleManager\Feature\ServiceProviderInterface;
use LmcMail\Options\MailOptions;
use LmcMail\Options\MailOptionsFactory;
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
            'aliases' => [
                // These aliases are used by the MailViewRendererFactory
                // by default, they resolve to the Laminas MVC View Helper manager and Resolver
                'lmc_mail_view_helper_manager' => 'ViewHelperManager',
                'lmc_mail_view_resolver' => 'ViewResolver',
            ],
            'factories' => [
                'lmc_mail_view_renderer' => MailViewRendererFactory::class,
                MessageService::class => MessageServiceFactory::class,
                MailOptions::class => MailOptionsFactory::class,
            ],
        ];
    }
}
