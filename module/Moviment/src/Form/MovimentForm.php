<?php
namespace Moviment\Form;

use Zend\Form\Form;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilter;
use Zend\Session\Container;
//use Moviment\Validator\MovimentExistsValidator;
use Compte\Entity\Compte;
use Traductor\Controller\Plugin\IcuDateTimeTranslate;

/**
 * This form is used to collect moviment's codi, nom, explicació, codiAlternatiu, tius
 */
class MovimentForm extends Form
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager 
     */
    private $entityManager = null;
    
    /**
     * Current moviment.
     * @var Moviment\Entity\Moviment 
     */
    private $moviment = null;
    
    /**
     * Constructor.     
     */
    public function __construct($entityManager = null, $moviment = null)
    {
        // Define form name
        parent::__construct('moviment-form');
     
        // Set POST method for this form
        $this->setAttribute('method', 'post');
        
        // Save parameters for internal use.
        $this->entityManager = $entityManager;
        $this->moviment = $moviment;
        
        $this->addElements();
        //$this->addInputFilter();          
    }
    
    /**
     * This method adds elements to form (input fields and submit button).
     */
    protected function addElements() 
    {
		$sessionContainer = new Container('UserDatos');
		$idioma = $sessionContainer->userPrefs['idioma'];
		$a_lang = \explode('-', $idioma);
		$lang = $a_lang[0];
		$oDateFormatter = new \IntlDateFormatter('',\IntlDateFormatter::SHORT,\IntlDateFormatter::NONE);
		$formato_ICU = $oDateFormatter->getPattern();
		$formato_jQuery =  IcuDateTimeTranslate::icu2jquery($formato_ICU);
        // Add "codiB" Valor per buscar 
        $this->add([
            'type'  => 'hidden',
            'name' => 'codiB',
        ]);
        // Add "id" field
        $this->add([
            'type'  => 'hidden',
            'name' => 'id',
        ]);
        // Add "data" field
		$this->add([
            'name' => 'data',
            'type' => 'Zf3\Bootstrapdatepicker\Form\Element\Datepicker',
            'attributes'=>[
                'class'=>'form-control',
            ],
            'options'=>[
				'label'   => "data",
                'settings'=>[
                    'id'=>"data",
                    'datepicker'=>[
                        //"format"=> "dd/mm/yy",
                        "format"=> $formato_jQuery,
						"assumeNearbyYear" => true,
                        //"startDate"=> "d",
                        "autoclose"=> true,
                        "language"=> $lang,
                    ],
                    "icon"=>"true",
                    "icon-class"=>"glyphicon glyphicon-th"
                ]
            ]
        ]);

		
        // Add "Concepte" field
        $this->add([
            'type'  => 'text',
            'name' => 'concepte',
            'options' => [
                'label' => 'Concepte',
            ],
        ]);
		
        // Add "Import" field
        $this->add([
            'type'  => 'number',
            'name' => 'import',
			'attributes' => [         // Array of attributes
				'step'  => 'any',     
				'lang'  => $idioma,
			],
            'options' => [
                'label' => 'Import',
            ],
        ]);
        
        // Add "responsable" field
        $this->add([
            'type'  => 'text',
            'name' => 'responsable',
            'options' => [
                'label' => 'Responsable',
            ],
        ]);
        // Add "codiH" field
        $this->add([
            'type'  => 'select',
            'name' => 'codiH',
            'options' => [
                'label' => "CODI H",
				'value_options' => $this->getOptionsForCodi(),
            ],
        ]);

		$this->add([
			'type' => 'DoctrineModule\Form\Element\ObjectSelect',
			'name' => 'codiD',
			'options' => [
                'label' => "CODI D",
				'object_manager'      => $this->entityManager,
				'target_class'        => 'Compte\Entity\Compte',
				'property'            => 'nom',
			],
		]);
        
        // Add the Submit button
        $this->add([
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => [                
                'value' => _("afegir")
            ],
        ]);
    }
    /**
	 * Este método crea un array de opciones para el select de codigo.
	 */
	function getOptionsForCodi()
	{
		//$dbAdapter = $this->adapter;
        $sql = 'SELECT c FROM Compte\Entity\Compte c where c.status=1 ORDER BY c.codi ASC';
		$q = $this->entityManager->createQuery($sql);
		$result = $q->getResult();

        $selectData = array();

        foreach ($result as $res) {
            $selectData[$res->getCodi()] = $res->getNom();
        }
        return $selectData;
	}
	
    /**
     * This method creates input filter (used for form filtering/validation).
     */
    private function addInputFilter() 
    {
        // Create main input filter
        $inputFilter = new InputFilter();        
        $this->setInputFilter($inputFilter);
                
        // Add input for "codi" field
        $inputFilter->add([
                'name'     => 'codi',
                'required' => true,
                'filters'  => [
                    ['name' => 'StringTrim'],                    
                ],                
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'min' => 1,
                            'max' => 8
                        ],
                    ],
                    [
                        'name' => MovimentExistsValidator::class,
                        'options' => [
                            'entityManager' => $this->entityManager,
                            'moviment' => $this->moviment
                        ],
                    ],                    
                ],
            ]);     
        
        // Add input for "concepte" field
        $inputFilter->add([
                'name'     => 'concepte',
                'required' => true,
                'filters'  => [                    
                    ['name' => 'StringTrim'],
                ],                
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'min' => 1,
                            'max' => 512
                        ],
                    ],
                ],
            ]);
    }           
}