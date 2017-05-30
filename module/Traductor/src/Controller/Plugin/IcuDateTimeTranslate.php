<?php
namespace Traductor\Controller\Plugin; 

// Plugin class
class IcuDateTimeTranslate 
{
	private static $_translations = [
        // translation from ICU to PHP DateTime pattern
		// (http://userguide.icu-project.org/formatparse/datetime)
        // (http://www.php.net/manual/en/datetime.createfromformat.php)
        'php' => [
            'yy' => 'y',
            'yyyy' => 'Y',
            'y' => 'Y',
            'Y' => 'Y',
            'M' => 'm',
            'MM' => 'm',
            'MMM' => 'M',
            'MMMM' => 'F',
            'L' => 'm',
            'LL' => 'm',
            'LLL' => 'M',
            'LLLL' => 'F',
            'd' => 'j',
            'dd' => 'd',
            'h' => 'g',
            'hh' => 'h',
            'H' => 'G',
            'HH' => 'H',
            'mm' => 'i',
            'ss' => 's',
        ],

        // translation from ICU to jQuery date pattern
		// Dani (https://bootstrap-datepicker.readthedocs.io/en/stable/options.html#format)
        'jquery' => [
            'yyyy' => 'yyyy',
            'yy' => 'yy',
            'MMMM' => 'MM',
            'MMM' => 'M',
            'MM' => 'mm',
            'M' => 'm',
            'dd' => 'dd',
            'd' => 'd',
        ],
    ];

    /**
     * @var boolean whether 'mbstring' PHP extension available. This static property introduced for
     * the better overall performance of the class functionality.
     */
    private static $_mbstringAvailable;

    /**
     * Translates UCI pattern to equivalent pattern on php.
     *
     * @param string $pattern the pattern to be translated.
     */
    public static function icu2php($pattern)
    {
		return self::translate($pattern,'php');
	}
    /**
     * Translates UCI pattern to equivalent pattern on jquery.
     *
     * @param string $pattern the pattern to be translated.
     */
    public static function icu2jquery($pattern)
    {
		return self::translate($pattern,'jquery');
	}
    /**
     * Translates UCI pattern to another equivalent pattern.
     *
     * @param string $pattern the pattern to be translated.
     * @param string $to to which pattern should be translated.
     * available:
     * - php: to PHP DateTimeFormat pattern (http://www.php.net/manual/en/datetime.createfromformat.php)
     * - jquery: to JQuery pattern (http://api.jqueryui.com/datepicker).
     */
    public static function translate($pattern, $to = 'php')
    {
        if (self::$_mbstringAvailable === null) {
            self::$_mbstringAvailable = extension_loaded('mbstring');
        }
        if (!isset(self::$_translations[$to])) {
            throw new \Exception("Translation for '{$to}' is not supported.");
        }

        $translation = self::$_translations[$to];
        $newFormat = '';
        $tokens = self::tokenize($pattern);
        foreach ($tokens as $token) {
            if (isset($translation[$token])) {
                $newFormat .= $translation[$token];
            } else {
                $newFormat .= $token;
            }
        }

        return $newFormat;
    }

    /*
     * @param string $pattern the pattern that the date string is following
     */
    public static function tokenize($pattern)
    {
		$encoding = 'UTF-8';
        if (!($n = self::$_mbstringAvailable ? mb_strlen($pattern, $encoding) : strlen($pattern))) {
            return array();
        }
        $tokens = array();
        $c0 = self::$_mbstringAvailable ? mb_substr($pattern, 0, 1, $encoding) : substr($pattern, 0, 1);
        for ($start = 0, $i = 1; $i < $n; ++$i) {
            $c = self::$_mbstringAvailable ? mb_substr($pattern, $i, 1, $encoding) : substr($pattern, $i, 1);
            if ($c !== $c0) {
                $tokens[] = self::$_mbstringAvailable ? mb_substr($pattern, $start, $i - $start, $encoding) : substr($pattern, $start, $i - $start);
                $c0 = $c;
                $start = $i;
            }
        }
        $tokens[] = self::$_mbstringAvailable ? mb_substr($pattern, $start, $n - $start, $encoding) : substr($pattern, $start, $n - $start);
        return $tokens;
    }
}