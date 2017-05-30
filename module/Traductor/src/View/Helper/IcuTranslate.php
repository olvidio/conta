<?php
namespace Traductor\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Traductor\Controller\Plugin\IcuDateTimeTranslate;

/**
 * DateTimePatternTranslator converts a ICU date time format to equivalent in another pattern.
 *
 * For example, to converter the ICU format 'yyyy-MM-dd HH:mm:ss' to equivalent in PHP DateTime class pattern:
 * ~~~php
 * $phpDateTimeFormat = DateTimePatternTranslator::t('yyyy-MM-dd HH:mm:ss', 'php') // returns 'Y-m-d H:i:s'
 * ~~~
 *
 * For example, to converter the ICU format 'yyyy-MM-dd' to equivalent in jquery pattern:
 * ~~~php
 * $jqueryDateFormat = DateTimePatternTranslator::t('yyyy-MM-dd', 'jquery') // returns 'yy-mm-dd '
 * ~~~
 *
 */
class IcuTranslate extends AbstractHelper
{

    public function icu2php($pattern)
	{
		return IcuDateTimeTranslate::icu2php($pattern);
	}
    public function icu2jquery($pattern)
	{
		return IcuDateTimeTranslate::icu2jquery($pattern);
	}
}