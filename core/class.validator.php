<?php
/**
 * class.validator.php
 *
 * @package niftyrsvp
 * @author Bryce Mickler <bryce@brycemickler.com>
 * @copyright 2009
 * @license http://www.freebsd.org/copyright/freebsd-license.html Free BSD License
 */
/**
 * Provides lots of different validation methods
 * Validates email addresses, integers, strings, URLs, USA phone numbers, USA
 * zip codes (postal codes), emptiness of a string, regex for certain characters
 * (bad characters), and captchas.
 *
 * @package niftyrsvp
 * @version 0.9 beta
 */
class validator
{

    /**
     * Toggle debugging for this class only.  To enable debugging, both the debugging
     * constant located in the config file and each page's $page_debug variable
     * must be set to TRUE.  Be sure to set these to FALSE when going live!!
     *
     * @var bool
     */
    private $page_debug;

    public function __construct() {}
    public function __destruct() {}

    /**
     * Validates email addresses
     * Validating email addresses is hard, there's a million regular expression
     * formulas out there, this will probably change over time.
     *
     * @param string $email
     * @return bool
     * @todo Create ability to validate internal/intranet email addresses such as
     * those in the form 'bob@localhost'
     */
    public function validateEmail($email)
    {
        return (eregi("^[a-z0-9._-]+@+[a-z0-9._-]+.+[a-z]{2,3}$", $email)) ? true : false;
    }

    /**
     * Validates integers
     *
     * @param integer $value Hopefully this is an integer
     * @param integer $min Minimum allowed integer value
     * @param integer $max Maximum allowed integer value
     * @return bool
     */
    public function validateInteger($value, $min, $max)
    {
    	return($this->isInteger($value)) ? true : false;
    }

    /**
     * Validates strings
     *
     * @param string $string Hopefully this is a string
     * @param integer $min_len Minimum allowed string length
     * @param integer $max_len Maximum allowed string length
     * @return bool
     */
    public function validateString($string, $min_len, $max_len)
    {
        return((strlen($string) >= $min_len) && (strlen($string) <= $max_len)) ? true : false;
    }

    /**
     * Validates URLs
     *
     * @param string $url
     * @return bool
     */
    public function validateUrl($url)
    {
        // $old_regex = "^((ht|f)tp://)((([a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,3}))|(([0-9]{1,3}.){3}([0-9]{1,3})))((/|?)[a-z0-9~#%&'_+=:?.-]*)*)$";
        $regex = "^(http|ftp)://(www\.)?.+\.(com|net|org)$";
        return eregi($regex,$url);
    }

    /**
     * Validates USA phone numbers
     *
     * @param string $phone Phone number string to validate
     * @param string $countryCode Country code
     * @return bool
     * @todo Ability to validate phone numbers from other countries.  ISO country
     * code recognition
     */
    public function validateUSAPhone($phone,$countryCode=1)
    {
        $phone = ereg_replace( "[^0-9]", "", $phone );//  strip out non-numerics

        switch ($countryCode)
        {
            case 1: // USA
                if((strlen($phone) >= 10) && (strlen($phone) <= 14))
                {
                    $regex = '^[(]?[2-9]{1}[0-9]{2}[) -.]{0,2}' . '[0-9]{3}[- .]?' . '[0-9]{4}[ ]?' . '((x|ext|#)[.]?[ ]?[0-9]{1,5})?$';
                }
                else
                {
                    return false;
                }
                break;
        }

        return (eregi($regex, $phone)) ? true : false;
    }

    /**
     * Validates US zip codes
     *
     * @param string $state State code
     * @param mixed $zip5 Zip code
     * @return bool
     */
    function validateStateZip5($state, $zip5)
    {
        $state = strtoupper(trim(substr($state,0,2)));

        $allstates = array (
         "AK" => array ("9950099929"),
         "AL" => array ("3500036999"),
         "AR" => array ("7160072999", "7550275505"),
         "AZ" => array ("8500086599"),
         "CA" => array ("9000096199"),
         "CO" => array ("8000081699"),
         "CT" => array ("0600006999"),
         "DC" => array ("2000020099", "2020020599"),
         "DE" => array ("1970019999"),
         "FL" => array ("3200033999", "3410034999"),
         "GA" => array ("3000031999"),
         "HI" => array ("9670096798", "9680096899"),
         "IA" => array ("5000052999"),
         "ID" => array ("8320083899"),
         "IL" => array ("6000062999"),
         "IN" => array ("4600047999"),
         "KS" => array ("6600067999"),
         "KY" => array ("4000042799", "4527545275"),
         "LA" => array ("7000071499", "7174971749"),
         "MA" => array ("0100002799"),
         "MD" => array ("2033120331", "2060021999"),
         "ME" => array ("0380103801", "0380403804", "0390004999"),
         "MI" => array ("4800049999"),
         "MN" => array ("5500056799"),
         "MO" => array ("6300065899"),
         "MS" => array ("3860039799"),
         "MT" => array ("5900059999"),
         "NC" => array ("2700028999"),
         "ND" => array ("5800058899"),
         "NE" => array ("6800069399"),
         "NH" => array ("0300003803", "0380903899"),
         "NJ" => array ("0700008999"),
         "NM" => array ("8700088499"),
         "NV" => array ("8900089899"),
         "NY" => array ("0040000599", "0639006390", "0900014999"),
         "OH" => array ("4300045999"),
         "OK" => array ("7300073199", "7340074999"),
         "OR" => array ("9700097999"),
         "PA" => array ("1500019699"),
         "RI" => array ("0280002999", "0637906379"),
         "SC" => array ("2900029999"),
         "SD" => array ("5700057799"),
         "TN" => array ("3700038599", "7239572395"),
         "TX" => array ("7330073399", "7394973949", "7500079999", "8850188599"),
         "UT" => array ("8400084799"),
         "VA" => array ("2010520199", "2030120301", "2037020370", "2200024699"),
         "VT" => array ("0500005999"),
         "WA" => array ("9800099499"),
         "WI" => array ("4993649936", "5300054999"),
         "WV" => array ("2470026899"),
         "WY" => array ("8200083199"));

        if (isset($allstates[$state]))
        {
            foreach($allstates[$state] as $ziprange)
            {
                if (($zip5 >= substr($ziprange, 0, 5)) && ($zip5 <= substr($ziprange,5)))
                {
                    return true;
                }
            }
        }
        return false;
    }

	/**
	 * check whether input is an empty string
	 *
	 * @param string $value
	 * @return bool
	 */
    public function isEmpty($value)
    {
        return (!isset($value) || trim($value) == '') ? true : false;
    }

    /**
     * check wheter input is a string
     *
     * @param mixed $value
     * @return bool
     */
    public function isString($value)
    {
        return (is_string($value)) ? true : false;
    }

    /**
     * check whether input is a number
     *
     * @param mixed $value
     * @return bool
     */
    public function isNumber($value)
    {
        return (is_numeric($value)) ? true : false;
    }

    /**
     * check whether input is an integer
     *
     * @param mixed $value
     * @return bool
     */
    public function isInteger($value)
    {
        return (intval($value) == $value) ? true : false;
    }

    /**
     * check whether input is alphabetic
     *
     * @param mixed $value
     * @return bool
     */
    public function isAlpha($value)
    {
        return (preg_match('/^[a-zA-Z]+$/', $value)) ? true : false;
    }

    /**
     * Checks a string for the pressence of BAD_CHARACTERS
     *
     * @param string $string
     * @return bool
     */
    public function badCharacters($string)
    {
        $match = preg_match(BAD_CHARACTERS,$string);
        return($match > 0) ? true : false;
    }
}
?>