<?php

namespace LmcMail\Options;

use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Psr\Container\ContainerInterface;

class MailOptionsFactory implements \Laminas\ServiceManager\Factory\FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $config = $container->get('config');
        if (!isset($config['lmc_mail'])) {
            throw new ServiceNotCreatedException('lmc_mail config is missing in the config file');
        }
        return new MailOptions($config['lmc_mail']);
    }
}
