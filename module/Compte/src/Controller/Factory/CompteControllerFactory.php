<?php
namespace Compte\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Compte\Controller\CompteController;
use Compte\Service\CompteManager;
use Compte\Entity\Compte;

/**
 * This is the factory for CompteController. Its purpose is to instantiate the
 * controller and inject dependencies into it.
 */
class CompteControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
		$persona = $container->get('Application')->getMvcEvent()->getRouteMatch()->getParam('persona', false);
		if ($persona == 'g') {
			$tablename = 'comptes';
		} else {
			$tablename = 'comptes_'.$persona;
		}
		
	/*	array(
     *     'sequenceName'   => 'name',
     *     'allocationSize' => 20,
     *     'initialValue'   => 1
     *     'quoted'         => 1
     * )
	 * 
	 */
		$definition = ['sequenceName' => $tablename.'_id_seq'];
		
        $entityManager = $container->get('doctrine.entitymanager.orm_conta');
        $this->entityManager = $entityManager;
        $this->entityManager->getClassMetadata(Compte::class)->setPrimaryTable(['name'=>$tablename]);
	    $this->entityManager->getClassMetadata(Compte::class)->setSequenceGeneratorDefinition($definition);
        $compteManager = $container->get(CompteManager::class);
				
        // Instantiate the controller and inject dependencies
        return new CompteController($entityManager, $compteManager);
    }
}