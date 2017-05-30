<?php
namespace Traductor\Controller\Plugin;

use NumberFormatter;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

/**
 * This is the main controller class of the User Demo application. It contains
 * site-wide actions such as Home or About.
 */
class IntlNumberPlugin extends AbstractPlugin
{
    /**
     * 
     * @var 
     */
    private $numberFormatter;
	

	public function getNumberFormatter()
	{
		/*
		if (!$this->numberFormatter) {
			$this->numberFormatter = new \NumberFormatter(
					$this->getLocaleCode(),
					\NumberFormatter::DECIMAL);
		}
		 * 
		 */
		if (!$this->numberFormatter) {
			$this->numberFormatter = new \NumberFormatter(
					'es-ES',
					\NumberFormatter::DECIMAL);
		}
		return $this->numberFormatter;
	}

	public function formatNumber($number) {
		return $this->getNumberFormatter()->format($number);
	}

	public function parserNumber($string) {
		$result = $this->getNumberFormatter()->parse($string);
		return ($result)? $result : self::ERROR_UNABLE_TO_PARSE;
	}
}