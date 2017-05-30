<?php
namespace Traductor\Controller\Plugin;

use Interop\Container\ContainerInterface;
use Zend\Mvc\I18n\Translator;

/**
 * This is the factory for TraductorPlugin. Its purpose is to instantiate the
 * Plugin and inject dependencies into it.
 */
class TraductorPluginFactory implements \Zend\ServiceManager\Factory\FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $translatorManager = $container->get(Translator::class);
        
        // Instantiate the controller and inject dependencies
        return new TraductorPlugin($translatorManager);
    }

}