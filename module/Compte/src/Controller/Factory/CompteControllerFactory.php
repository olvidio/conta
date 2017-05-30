<?php
namespace Compte\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Compte\Controller\CompteController;
use Compte\Service\CompteManager;

/**
 * This is the factory for CompteController. Its purpose is to instantiate the
 * controller and inject dependencies into it.
 */
class CompteControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_conta');
        $compteManager = $container->get(CompteManager::class);
				
        // Instantiate the controller and inject dependencies
        return new CompteController($entityManager, $compteManager);
    }
}