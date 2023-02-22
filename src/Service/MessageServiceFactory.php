<?php
/**
 * @author Eric Richer <eric.richer@vistoconsulting.com
 *
 */

namespace LmcMail\Service;

use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use LmcMail\Options\MailOptions;
use Psr\Container\ContainerInterface;

class MessageServiceFactory implements \Laminas\ServiceManager\Factory\FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $renderer = $container->get('lmc_mail_view_renderer');
//        $transport = $container->get('lmc_mail_transport_service');
        /** @var MailOptions $mailOptions */
        $mailOptions = $container->get(MailOptions::class);
        return new MessageService($renderer, $mailOptions->getTransport(), $mailOptions->getFrom());
    }
}
