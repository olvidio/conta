<?php

namespace Moviment\Service;

use Moviment\Entity\Moviment;
/**
 * This service is responsible for adding/editing comptes
 */
class MovimentManager
{
    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;  
	
    private $traductorPlugin;  
    
    /**
     * Constructs the service.
     */
    public function __construct($entityManager, $traductorPlugin) 
    {
        $this->entityManager = $entityManager;
        $this->traductorPlugin = $traductorPlugin;
    }
    
    /**
     * This method adds a new moviment.
     */
    public function addMoviment($data) 
    {
        // Do not allow several comptes with the same codi address.
        if($this->checkMovimentExists($data['id'])) {
            $msg = $this->traductorPlugin->translate("El Moviment amb id " . $data['id'] . " ja existeix");
            throw new \Exception($msg);
        }
        
        // Create new Moviment entity.
        $moviment = new Moviment();
        $moviment->setData($data['data']);
        $moviment->setImport($data['import']);
        $moviment->setConcepte($data['concepte']);
        $moviment->setResponsable($data['responsable']);
		
		$codiD = $data['codiD'];
        $oCompteD = $this->entityManager->getRepository(\Compte\Entity\Compte::class)
                ->findOneByCodi($codiD);
        $moviment->setCodiD($oCompteD);
		
		$codiH = $data['codiH'];
        $oCompteH = $this->entityManager->getRepository(\Compte\Entity\Compte::class)
                ->findOneByCodi($codiH);
        $moviment->setCodiH($oCompteH);
        
		$now = new \DateTime('now');
        $moviment->setDateCreated($now);
                
        // Add the entity to the entity manager.
        $this->entityManager->persist($moviment);
        
        // Apply changes to database.
        $this->entityManager->flush();
        
        return $moviment;
    }
    
    /**
     * This method updates data of an existing moviment.
     */
    public function updateMoviment($moviment, $data) 
    {
		
        // Do not allow to change moviment email if another moviment with such codi already exits.
        if($moviment->getId()!=$data['id'] && $this->checkMovimentExists($data['id'])) {
            $msg = $this->traductorPlugin->translate("Ja existeix un Moviment amb id " . $data['id']);
            throw new \Exception($msg);
        }
        
        $moviment->setData($data['data']);
		
        $moviment->setImport($data['import']);
        $moviment->setConcepte($data['concepte']);
        $moviment->setResponsable($data['responsable']);

		$codiD = $data['codiD'];
        $oCompteD = $this->entityManager->getRepository(\Compte\Entity\Compte::class)
                ->findOneByCodi($codiD);
        $moviment->setCodiD($oCompteD);
		
		$codiH = $data['codiH'];
        $oCompteH = $this->entityManager->getRepository(\Compte\Entity\Compte::class)
                ->findOneByCodi($codiH);
        $moviment->setCodiH($oCompteH);
        
        // Apply changes to database.
        $this->entityManager->flush();

        return true;
    }
    
    /**
     * This method delete an existing moviment.
     */
    public function deleteMoviment($moviment) 
    {
        $this->entityManager->remove($moviment);
		
        // Apply changes to database.
        $this->entityManager->flush();

        return true;
    }
    
    /**
     * Checks whether an active moviment with given Codi already exists in the database.     
     */
    public function checkMovimentExists($id) {
        
        $moviment = $this->entityManager->getRepository(Moviment::class)
                ->findOneById($id);
        
        return $moviment !== null;
    }
    
}