<?php
/**
 * @author Eric Richer <eric.richer@vistoconsulting.com
 *
 */

namespace LmcMail\View;

use Laminas\View\Renderer\PhpRenderer;
use Psr\Container\ContainerInterface;

class MailViewRendererFactory implements \Laminas\ServiceManager\Factory\FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $renderer = new PhpRenderer();
        $helperManager = $container->get('ViewHelperManager');
        $resolver = $container->get('ViewResolver');
        $renderer->setHelperPluginManager($helperManager);
        $renderer->setResolver($resolver);
        return $renderer;
    }
}
