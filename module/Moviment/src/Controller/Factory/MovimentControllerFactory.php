<?php
namespace Moviment\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Moviment\Controller\MovimentController;
use Moviment\Service\MovimentManager;

/**
 * This is the factory for MovimentController. Its purpose is to instantiate the
 * controller and inject dependencies into it.
 */
class MovimentControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_conta');
        $movimentManager = $container->get(MovimentManager::class);
				
        // Instantiate the controller and inject dependencies
        return new MovimentController($entityManager, $movimentManager);
    }
}