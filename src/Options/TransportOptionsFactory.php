<?php
/**
 * @author Eric Richer <eric.richer@vistoconsulting.com
 *
 */

namespace LmcMail\Options;

use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Psr\Container\ContainerInterface;

class TransportOptionsFactory implements \Laminas\ServiceManager\Factory\FactoryInterface
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
        return new TransportOptions($config['lmc_mail']);
    }
}
