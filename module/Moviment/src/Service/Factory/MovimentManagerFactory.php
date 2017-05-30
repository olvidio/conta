<?php
namespace Moviment\Service\Factory;

use Interop\Container\ContainerInterface;
use Moviment\Service\MovimentManager;

/**
 * This is the factory class for CompteManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class MovimentManagerFactory
{
    /**
     * This method creates the CompteManager service and returns its instance. 
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {        
        $entityManager = $container->get('doctrine.entitymanager.orm_conta');
		//Aqui l'agafo com a Service, no com a Plugin
        $traductorPlugin = $container->get(\Traductor\Controller\Plugin\TraductorPlugin::class);
                        
        return new MovimentManager($entityManager, $traductorPlugin);
    }
}
