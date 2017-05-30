<?php
namespace Traductor\Controller\Plugin; 

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

// Plugin class
class TraductorPlugin extends AbstractPlugin
{
	/**
    * translator .
    * @var Traductor\Controller\Plugin\translatorManager 
    */
    private $translatorManager;
    
    /**
     * Constructor. 
     */
    public function __construct(\Zend\Mvc\I18n\Translator $translatorManager)
    {
        $this->translatorManager = $translatorManager;
    }
	
    // This method checks whether user is allowed
    // to visit the page 
    public function translate($string)
    {
		return $this->translatorManager->translate($string);
    }

	
    public function icu2php($pattern)
	{
		return IcuDateTimeTranslate::icu2php($pattern);
	}
    public function icu2jquery($pattern)
	{
		return IcuDateTimeTranslate::icu2jquery($pattern);
	}
}