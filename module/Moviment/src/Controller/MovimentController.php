<?php
namespace Moviment\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\Result;
use Moviment\Entity\Moviment;
use Moviment\Form\MovimentForm;

/**
 * This controller is responsible for moviment management (adding, editing, 
 * viewing moviments and changing moviment's password).
 */
class MovimentController extends AbstractActionController 
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;
    
    /**
     * Moviment manager.
     * @var Moviment\Service\MovimentManager 
     */
    private $movimentManager;
    
    /**
     * Constructor. 
     */
    public function __construct($entityManager, $movimentManager)
    {
        $this->entityManager = $entityManager;
        $this->movimentManager = $movimentManager;
    }
    
    /**
     * Això llista els moviments d'un compte
     * list of moviments.
     */
    public function llistaxcompteAction() 
    {
        // Get CodiB from route.
        $codiB = (string)$this->params()->fromRoute('codiB');
		
		if (empty($codiB)) {
			$codiB = 5722;
		}
		// Tots les caixes posibles
		$q = $this->entityManager->createQuery("select c from Compte\Entity\Compte c where c.codi BETWEEN 5700 AND 5800 ORDER BY c.codi");
		$caixes = $q->getResult();
		
		// Tots els moviments del compte 
		$q = $this->entityManager->createQuery("select mov from Moviment\Entity\Moviment mov where mov.codiH = $codiB OR mov.codiD = $codiB ORDER BY mov.data DESC");
		$moviments = $q->getResult();
		
		$moviments_nou = array();
		$saldo_orig = 0;
		$m = 0;
		foreach ($moviments as $mov) {
			$m++;
			$saldo_ant = ($m < 2 )? $saldo_orig : $saldo;
			$debe = $mov->getCodiD()->getCodi();
			$haver = $mov->getCodiH()->getCodi();
			if ($codiB == $debe) {
				$signe = '+';
				$cte = $mov->getCodiH()->getNom();
				$saldo = $saldo_ant + $mov->getImport();
			}
			if ($codiB == $haver) {
				$signe = '-';
				$cte = $mov->getCodiD()->getNom();
				$saldo = $saldo_ant - $mov->getImport();
			}
			//$a = new \NumberFormatter('',\NumberFormatter::DECIMAL);
			//$import = new \NumberFormatter('',\NumberFormatter::CURRENCY);
			//$dia = new \IntlDateFormatter('',\IntlDateFormatter::SHORT,\IntlDateFormatter::NONE);
			//$formato_ICU = $dia->getPattern();
			//$formato_PHP = $this->traductor()->icu2php($formato_ICU);
			//echo "formato controller: $formato_ICU, $formato_PHP<br>";
			//echo "trans: ".$this->traductor()->translate("Accions")."<br>";
			//echo "Plugin by name: ".$this->plugin('traductor')->translate("Accions")."<br>";
			//echo "222 Plugin by name: ".$this->plugin(\Traductor\Controller\Plugin\TraductorPlugin::class)->translate("Accions")."<br>";
			$moviments_nou[] = [
						'id' => $mov->getId(),
						'dia'    =>	$mov->getData(),
						'import' => $mov->getImport(),
						'concepte' => $mov->getConcepte(),
						'responsable' => $mov->getResponsable(),
						'signe' => $signe,
						'cte' => $cte,
						'saldo' => $saldo,
			];
			
		}
		return new ViewModel([
            'codiB' => $codiB,
            'moviments' => $moviments_nou,
			'caixes' => $caixes,
        ]);
    } 
    
    /**
     * This is the default "index" action of the controller. It displays the 
     * list of moviments.
     */
    public function indexAction() 
    {
        $moviments = $this->entityManager->getRepository(Moviment::class)
                ->findBy([], ['id'=>'ASC']);
		
		// Exemple per traduir en el controller:
		//$translatedString = $this->dtranslate()->xtranslate("Nom");
		//echo $translatedString;
		return new ViewModel([
            'moviments' => $moviments
        ]);
    } 
    
    /**
     * This action displays a page allowing to add a new moviment.
     */
    public function addAction()
    {
        // Get CodiB from route.
        $codiB = (string)$this->params()->fromRoute('codiB');

        // Create moviment form
        $form = new MovimentForm($this->entityManager);
        
        // Check if moviment has submitted the form
        if ($this->getRequest()->isPost()) {
            
            // Fill in the form with POST data
            $data = $this->params()->fromPost();            
            
            $form->setData($data);
            
            // Validate form
            if($form->isValid()) {
                
                // Get filtered and validated data
                $data = $form->getData();
                
					
                // Add moviment.
                $moviment = $this->movimentManager->addMoviment($data);
                
                // Redirect to "view" page
                return $this->redirect()->toRoute('llista', 
                        ['action'=>'llistaxcompte', 'codiB'=>$codiB]);                
            }               
        } 
        
        return new ViewModel([
			'form' => $form,
			'codiB' => $codiB
            ]);
    }
    
    /**
     * The "view" action displays a page allowing to view moviment's details.
     */
    public function viewAction()
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id<1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        
        // Find a moviment with such ID.
        $moviments = $this->entityManager->getRepository(Moviment::class)
                ->findById($id);
        
        if ($moviments == null OR count($moviments) < 1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
                
        return new ViewModel([
            'moviment' => $moviments[0],
			'codiB' => $codiB
        ]);
    }
    
    /**
     * The "edit" action displays a page allowing to edit moviment.
     */
    public function editAction() 
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id<1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $codiB = (int)$this->params()->fromRoute('codiB', -1);
        
        $moviments = $this->entityManager->getRepository(Moviment::class)
                ->findById($id);
        
        if ($moviments == null OR count($moviments) < 1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

		$moviment = $moviments[0];
        
        // Create moviment form
        $form = new MovimentForm($this->entityManager, $moviment);
        
        // Check if moviment has submitted the form
        if ($this->getRequest()->isPost()) {
            
            // Fill in the form with POST data
            $data = $this->params()->fromPost();            
            
            $form->setData($data);
            
            // Validate form
            if($form->isValid()) {
                
                // Get filtered and validated data
                $data = $form->getData();
				
				// Canviar el format de la data:
				$fecha = $data['data'];
				//$dia = new \IntlDateFormatter('',\IntlDateFormatter::SHORT,\IntlDateFormatter::NONE);
				//$formato_ICU = $dia->getPattern();
				$oDateFormatter = new \IntlDateFormatter('',\IntlDateFormatter::SHORT,\IntlDateFormatter::NONE);
				$formato_ICU = $oDateFormatter->getPattern();
				$data['data'] = $this->plugin('intlDateTime')->createFromICU($formato_ICU, $fecha);
                // Update the moviment.
                $this->movimentManager->updateMoviment($moviment, $data);
                
				// Redirect to Index
				return $this->redirect()->toRoute('llista', ['action'=>'llistaxcompte', 'codiB'=>$codiB]);
            }               
        } else {
			//$fecha = $moviment->getData()->format('d/m/Y');
			$oDateFormatter = new \IntlDateFormatter('',\IntlDateFormatter::SHORT,\IntlDateFormatter::NONE);
            $form->setData(array(
                    'id'=>$moviment->getId(),
                    'data'=>$oDateFormatter->format($moviment->getData()),
                    'concepte'=>$moviment->getConcepte(),
                    'import'=>$moviment->getImport(),
                    'responsable'=>$moviment->getResponsable(),
                    'codiD'=>$moviment->getCodiD()->getCodi(),
                    'codiH'=>$moviment->getCodiH()->getCodi(),
                ));
        }
        
        return new ViewModel(array(
            'moviment' => $moviment,
            'form' => $form,
			'codiB' => $codiB
        ));
    }
	
    /**
     * The "delete" action removes "Moviment" from database
     */
    public function deleteAction() 
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id<1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $codiB = (int)$this->params()->fromRoute('codiB', -1);
        
        // Find a moviment with such ID.
        $moviments = $this->entityManager->getRepository(Moviment::class)
                ->findById($id);
        
        if ($moviments == null OR count($moviments) < 1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

		$moviment = $moviments[0];
        
		// Delete the moviment.
		$this->movimentManager->deleteMoviment($moviment);
		
		// Redirect to Index
		return $this->redirect()->toRoute('llista', ['action'=>'llistaxcompte', 'codiB'=>$codiB]);
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