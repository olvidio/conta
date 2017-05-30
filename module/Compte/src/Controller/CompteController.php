<?php
namespace Compte\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\Result;
use Compte\Entity\Compte;
use Compte\Form\CompteForm;

/**
 * This controller is responsible for compte management (adding, editing, 
 * viewing comptes and changing compte's password).
 */
class CompteController extends AbstractActionController 
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;
    
    /**
     * Compte manager.
     * @var Compte\Service\CompteManager 
     */
    private $compteManager;
    
    /**
     * Constructor. 
     */
    public function __construct($entityManager, $compteManager)
    {
        $this->entityManager = $entityManager;
        $this->compteManager = $compteManager;
    }
    
    /**
     * This is the default "index" action of the controller. It displays the 
     * list of comptes.
     */
    public function indexAction() 
    {
        $comptes = $this->entityManager->getRepository(Compte::class)
                ->findBy([], ['id'=>'ASC']);
		
		// Exemple per traduir en el controller:
		//$translatedString = $this->dtranslate()->xtranslate("Nom");
		//echo $translatedString;
		return new ViewModel([
            'comptes' => $comptes
        ]);
    } 
    
    /**
     * This action displays a page allowing to add a new compte.
     */
    public function addAction()
    {
        // Create compte form
        $form = new CompteForm('create', $this->entityManager);
        
        // Check if compte has submitted the form
        if ($this->getRequest()->isPost()) {
            
            // Fill in the form with POST data
            $data = $this->params()->fromPost();            
            
            $form->setData($data);
            
            // Validate form
            if($form->isValid()) {
                
                // Get filtered and validated data
                $data = $form->getData();
                
                // Add compte.
                $compte = $this->compteManager->addCompte($data);
                
                // Redirect to "view" page
                return $this->redirect()->toRoute('comptes', 
                        ['action'=>'view', 'id'=>$compte->getId()]);                
            }               
        } 
        
        return new ViewModel([
                'form' => $form
            ]);
    }
    
    /**
     * The "view" action displays a page allowing to view compte's details.
     */
    public function viewAction() 
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id<1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        // Find a compte with such ID.
        $comptes = $this->entityManager->getRepository(Compte::class)
                ->findById($id);
        
        if ($comptes == null OR count($comptes) < 1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
                
        return new ViewModel([
            'compte' => $comptes[0]
        ]);
    }
    
    /**
     * The "edit" action displays a page allowing to edit compte.
     */
    public function editAction() 
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id<1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        $comptes = $this->entityManager->getRepository(Compte::class)
                ->findById($id);
        
        if ($comptes == null OR count($comptes) < 1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

		$compte = $comptes[0];
        
        // Create compte form
        $form = new CompteForm('update', $this->entityManager, $compte);
        
        // Check if compte has submitted the form
        if ($this->getRequest()->isPost()) {
            
            // Fill in the form with POST data
            $data = $this->params()->fromPost();            
            
            $form->setData($data);
            
            // Validate form
            if($form->isValid()) {
                
                // Get filtered and validated data
                $data = $form->getData();
                
                // Update the compte.
                $this->compteManager->updateCompte($compte, $data);
                
                // Redirect to "view" page
                return $this->redirect()->toRoute('comptes', 
                        ['action'=>'view', 'id'=>$compte->getId()]);                
            }               
        } else {
            $form->setData(array(
                    'codi'=>$compte->getCodi(),
                    'nom'=>$compte->getNom(),
                    'explicacio'=>$compte->getExplicacio(),
                    'codiAlternatiu'=>$compte->getCodiAlternatiu(),
                    'tipus'=>$compte->getTipus(),
                    'status'=>$compte->getStatus(),                    
                ));
        }
        
        return new ViewModel(array(
            'compte' => $compte,
            'form' => $form
        ));
    }
	
    /**
     * The "delete" action removes "Compte" from database
     */
    public function deleteAction() 
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id<1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        // Find a compte with such ID.
        $comptes = $this->entityManager->getRepository(Compte::class)
                ->findById($id);
        
        if ($comptes == null OR count($comptes) < 1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

		$compte = $comptes[0];
        
		// Delete the compte.
		$this->compteManager->deleteCompte($compte);
		
        // Redirect to Index
		return $this->redirect()->toRoute('comptes', ['action'=>'index']);
    }
    
    
    
    /**
     * This action displays an informational message page. 
     * For example "Your password has been resetted" and so on.
     */
    public function messageAction() 
    {
        // Get message ID from route.
        $id = (string)$this->params()->fromRoute('id');
        
        // Validate input argument.
        if($id!='invalid-email' && $id!='sent' && $id!='set' && $id!='failed') {
			$translatedString = $this->dtranslate()->xtranslate("id missatge invàlid");
            throw new \Exception($translatedString);
        }
        
        return new ViewModel([
            'id' => $id
        ]);
    }
    
}


