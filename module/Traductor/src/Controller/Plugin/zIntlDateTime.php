<?php
namespace Traductor\Controller\Plugin; 


// Plugin class

class IntlDateTime extends \DateTime
{
    
    /**
     * 
     */
    public function createFromICU($formato_ICU, $fecha)
    {
		$formato_PHP = IcuDateTimeTranslate::icu2php($formato_ICU);
        return parent::createFromFormat($formato_PHP, $fecha);
    }
    public function createFromJQuery($formato_JQuery, $fecha)
    {
		$formato_PHP = IcuDateTimeTranslate::icu2jquery($formato_JQuery);
        return parent::createFromFormat($formato_PHP, $fecha);
    }
}