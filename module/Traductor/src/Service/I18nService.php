<?php
namespace Traductor\Service;

use Zend\ServiceManager\AbstractPluginManager;
	
/**
 * 
 * 
 */
class I18nService extends AbstractPluginManager
{
    /**
     * translatorManager
     * @var Zend\View\Helper\Url
     */
    private $translatorManager;
    
    /**
     * Constructs the service.
     */
    public function __construct($translatorManager) 
    {
        //$this->authService = $authService;
        //$this->urlHelper = $urlHelper;
        $this->translatorManager = $translatorManager;
    }
	
    function translate($str) 
	{ 
		return $this->translatorManager->translate($str);
	}
}