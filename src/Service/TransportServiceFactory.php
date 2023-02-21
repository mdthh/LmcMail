<?php
/**
 * @author Eric Richer <eric.richer@vistoconsulting.com
 *
 */

namespace LmcMail\Service;

use Laminas\Mail\Transport\Factory;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Psr\Container\ContainerInterface;

class TransportServiceFactory implements \Laminas\ServiceManager\Factory\FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        if (!$container->has('config')) {
            throw new ServiceNotCreatedException('config file is missing');
        }
        $config = $container->get('config');
        if (!isset($config['lmc_mail'])) {
            throw new ServiceNotCreatedException('lmc_mail config is missing in the config file');
        }
        return Factory::create($config['lmc_mail']);
    }
}
