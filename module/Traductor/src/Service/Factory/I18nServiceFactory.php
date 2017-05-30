<?php
namespace Traductor\Service\Factory;

use Traductor\Service\I18nService;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * This is the factory class for CompteManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class I18nServiceFactory implements FactoryInterface
{
    /**
     * This method creates the CompteManager service and returns its instance. 
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {        
        //$authService = $container->get(\Zend\Authentication\AuthenticationService::class);
        $translatorManager = $container->get(Translator::class);
		 
        //$viewHelperManager = $container->get('ViewHelperManager');
        //$urlHelper = $viewHelperManager->get('url');
        
        return new I18nService($translatorManager);
    }
}