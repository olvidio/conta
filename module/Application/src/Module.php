<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\MvcEvent;
use Zend\Session\SessionManager;
use Zend\Session\Container;

class Module
{
    const VERSION = '3.0.1';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
	 
    /**
     * This method is called once the MVC bootstrapping is complete. 
     */
    public function onBootstrap(MvcEvent $event)
    {
        $application = $event->getApplication();
        $serviceManager = $application->getServiceManager();
        
        // The following line instantiates the SessionManager and automatically
        // makes the SessionManager the 'default' one to avoid passing the 
        // session manager as a dependency to other models.
        $sessionManager = $serviceManager->get(SessionManager::class);

		$sessionContainer = new Container('UserDatos');
		$idioma = $sessionContainer->userPrefs['idioma'];
		$idioma_php = str_replace('-', '_', $idioma);
		\Locale::setDefault($idioma_php);
		//\setlocale(LC_NUMERIC,"es_ES.UTF8");
		//echo \Locale::getDefault();
		
    }

}
