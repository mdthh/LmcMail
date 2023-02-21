<?php
/**
 * @author Eric Richer <eric.richer@vistoconsulting.com
 *
 */

namespace LmcMail\Service;

use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Psr\Container\ContainerInterface;

class MessageServiceFactory implements \Laminas\ServiceManager\Factory\FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $renderer = $container->get('lmc_email_view_renderer');
        $transport = $container->get('lmc_email_transport_service');

        if (!$container->has('config')) {
            throw new ServiceNotCreatedException('config file is missing');
        }

        $config = $container->get('config');
        if (!isset($config['lmc_mail'])) {
            throw new ServiceNotCreatedException('lmc_mail config is missing');
        }
        return new MessageService($renderer, $transport, $config['lmc_mail']);
    }
}
