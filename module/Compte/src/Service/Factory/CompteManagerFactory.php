<?php
namespace Compte\Service\Factory;

use Interop\Container\ContainerInterface;
use Compte\Service\CompteManager;

/**
 * This is the factory class for CompteManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class CompteManagerFactory
{
    /**
     * This method creates the CompteManager service and returns its instance. 
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {        
        $entityManager = $container->get('doctrine.entitymanager.orm_conta');
                        
        return new CompteManager($entityManager);
    }
}
