<?php
namespace Compte\Form;

use Zend\Form\Form;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilter;
use Compte\Validator\CompteExistsValidator;

/**
 * This form is used to collect compte's codi, nom, explicació, codiAlternatiu, tius
 * The form can work in two scenarios - 'create' and 'update'. In 'create' scenario,
 * compte ..., in 'update' scenario ...
 */
class CompteForm extends Form
{
    /**
     * Scenario ('create' or 'update').
     * @var string 
     */
    private $scenario;
    
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager 
     */
    private $entityManager = null;
    
    /**
     * Current compte.
     * @var Compte\Entity\Compte 
     */
    private $compte = null;
    
    /**
     * Constructor.     
     */
    public function __construct($scenario = 'create', $entityManager = null, $compte = null)
    {
        // Define form name
        parent::__construct('compte-form');
     
        // Set POST method for this form
        $this->setAttribute('method', 'post');
        
        // Save parameters for internal use.
        $this->scenario = $scenario;
        $this->entityManager = $entityManager;
        $this->compte = $compte;
        
        $this->addElements();
        $this->addInputFilter();          
    }
    
    /**
     * This method adds elements to form (input fields and submit button).
     */
    protected function addElements() 
    {
        // Add "codi" field
        $this->add([            
            'type'  => 'text',
            'name' => 'codi',
            'options' => [
                'label' => "CODI",
            ],
        ]);
        // Add "Nom" field
        $this->add([            
            'type'  => 'text',
            'name' => 'nom',            
            'options' => [
                'label' => 'Nom',
            ],
        ]);
		
        // Add "Explicació" field
        $this->add([            
            'type'  => 'text',
            'name' => 'explicacio',            
            'options' => [
                'label' => 'Explicació',
            ],
        ]);
        
        // Add "Codi Alternatiu" field
        $this->add([            
            'type'  => 'text',
            'name' => 'codiAlternatiu',            
            'options' => [
                'label' => 'Codi Alternatiu',
            ],
        ]);
        
        // Add "Tipus" field
        $this->add([            
            'type'  => 'select',
            'name' => 'tipus',            
            'options' => [
                'label' => 'Tipus',
                'value_options' => [
                    1 => 'Actiu',
                    2 => 'Passiu',                    
                ]
            ],
        ]);
		
        
        // Add "status" field
        $this->add([            
            'type'  => 'select',
            'name' => 'status',
            'options' => [
                'label' => 'Status',
                'value_options' => [
                    1 => 'Actiu',
                    2 => 'Retirat',                    
                ]
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
                        'name' => CompteExistsValidator::class,
                        'options' => [
                            'entityManager' => $this->entityManager,
                            'compte' => $this->compte
                        ],
                    ],                    
                ],
            ]);     
        
        // Add input for "nom" field
        $inputFilter->add([
                'name'     => 'nom',
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
        
        // Add input for "status" field
        $inputFilter->add([
                'name'     => 'status',
                'required' => true,
                'filters'  => [                    
                    ['name' => 'ToInt'],
                ],                
                'validators' => [
                    ['name'=>'InArray', 'options'=>['haystack'=>[1, 2]]]
                ],
            ]);        
    }           
}