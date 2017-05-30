<?php
namespace Compte\Validator;

use Zend\Validator\AbstractValidator;
use Compte\Entity\Compte;
/**
 * This validator class is designed for checking if there is an existing compte 
 * with such an codi.
 */
class CompteExistsValidator extends AbstractValidator 
{
    /**
     * Available validator options.
     * @var array
     */
    protected $options = array(
        'entityManager' => null,
        'compte' => null
    );
    
    // Validation failure message IDs.
    const NOT_SCALAR  = 'notScalar';
    const COMPTE_EXISTS = 'compteExists';
        
    /**
     * Validation failure messages.
     * @var array
     */
    protected $messageTemplates = array(
        self::NOT_SCALAR  => "The codi must be a scalar value",
        self::COMPTE_EXISTS  => "Another compte already exists"        
    );
    
    /**
     * Constructor.     
     */
    public function __construct($options = null) 
    {
        // Set filter options (if provided).
        if(is_array($options)) {            
            if(isset($options['entityManager']))
                $this->options['entityManager'] = $options['entityManager'];
            if(isset($options['compte']))
                $this->options['compte'] = $options['compte'];
        }
        
        // Call the parent class constructor
        parent::__construct($options);
    }
        
    /**
     * Check if compte exists.
     */
    public function isValid($value) 
    {
        if(!is_scalar($value)) {
            $this->error(self::NOT_SCALAR);
            return false; 
        }
        
        // Get Doctrine entity manager.
        $entityManager = $this->options['entityManager'];
        
        $compte = $entityManager->getRepository(Compte::class)
                ->findOneByCodi($value);
        
        if($this->options['compte']==null) {
            $isValid = ($compte==null);
        } else {
            if($this->options['compte']->getCodi()!=$value && $compte!=null) 
                $isValid = false;
            else 
                $isValid = true;
        }
        
        // If there were an error, set error message.
        if(!$isValid) {            
            $this->error(self::COMPTE_EXISTS);            
        }
        
        // Return validation result.
        return $isValid;
    }
}

