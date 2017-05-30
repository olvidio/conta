<?php
namespace Compte\Service;

use Compte\Entity\Compte;

/**
 * This service is responsible for adding/editing comptes
 */
class CompteManager
{
    /**
     * Doctrine entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;  
    
    /**
     * Constructs the service.
     */
    public function __construct($entityManager) 
    {
        $this->entityManager = $entityManager;
    }
    
    /**
     * This method adds a new compte.
     */
    public function addCompte($data) 
    {
        // Do not allow several comptes with the same codi address.
        if($this->checkCompteExists($data['codi'])) {
            throw new \Exception("Compte with codi " . $data['$codi'] . " already exists");
        }
        
        // Create new Compte entity.
        $compte = new Compte();
        $compte->setCodi($data['codi']);
        $compte->setNom($data['nom']);
        $compte->setExplicacio($data['explicacio']);
        $compte->setCodiAlternatiu($data['codiAlternatiu']);
        $compte->setTipus($data['tipus']);
        $compte->setStatus($data['status']);
        
		$now = new \DateTime('now');
        $compte->setDateCreated($now);
                
        // Add the entity to the entity manager.
        $this->entityManager->persist($compte);
        
        // Apply changes to database.
        $this->entityManager->flush();
        
        return $compte;
    }
    
    /**
     * This method updates data of an existing compte.
     */
    public function updateCompte($compte, $data) 
    {
        // Do not allow to change compte email if another compte with such codi already exits.
        if($compte->getCodi()!=$data['codi'] && $this->checkCompteExists($data['codi'])) {
            throw new \Exception("Another compte with codi " . $data['codi'] . " already exists");
        }
        
        $compte->setCodi($data['codi']);
        $compte->setNom($data['nom']);
        $compte->setExplicacio($data['explicacio']);
        $compte->setCodiAlternatiu($data['codiAlternatiu']);
        $compte->setTipus($data['tipus']);
        $compte->setStatus($data['status']);
        
        // Apply changes to database.
        $this->entityManager->flush();

        return true;
    }
    
    /**
     * This method delete an existing compte.
     */
    public function deleteCompte($compte) 
    {
        $this->entityManager->remove($compte);
		
        // Apply changes to database.
        $this->entityManager->flush();

        return true;
    }
    
    /**
     * Checks whether an active compte with given Codi already exists in the database.     
     */
    public function checkCompteExists($codi) {
        
        $compte = $this->entityManager->getRepository(Compte::class)
                ->findOneByCodi($codi);
        
        return $compte !== null;
    }
    
}