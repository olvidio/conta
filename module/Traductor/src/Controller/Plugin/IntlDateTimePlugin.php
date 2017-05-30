<?php
namespace Traductor\Controller\Plugin; 

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

// Plugin class

class IntlDateTimePlugin extends AbstractPlugin
{
    /**
     * Constructor. 
     */
    public function __construct()
    {
    }
	
	public function createFromICU($formato_ICU, $fecha)
    {
		$formato_PHP = IcuDateTimeTranslate::icu2php($formato_ICU);
        return \DateTime::createFromFormat($formato_PHP, $fecha);
    }
    public function createFromJQuery($formato_JQuery, $fecha)
    {
		$formato_PHP = IcuDateTimeTranslate::icu2jquery($formato_JQuery);
        return \DateTime::createFromFormat($formato_PHP, $fecha);
    }
}