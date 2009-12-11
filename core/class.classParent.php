<?php
/**
 * class.classParent.php
 *
 * @package niftyrsvp
 * @author Bryce Mickler <bryce@brycemickler.com>
 * @copyright 2009
 * @license http://www.freebsd.org/copyright/freebsd-license.html Free BSD License
 */
/**
 * Parent class for NiftyRSVP classes
 * Contains lots of basic functionality required by most classes in this project.
 *
 * @package niftyrsvp
 * @version 0.9 beta
 */
class classParent
{
	/**
	 * Handle for the PEAR::DB database connection string.
	 *
	 * @var array
	 */
    protected $mdb2;

    /**
     * Configuration bulletin board
     *
     * @var array
     */
    public $config;

    public function __construct($mdb2)
    {
        $this->db = $mdb2;
    }

    /**
     * Run-of-the-mill getter method
     *
     * @param mixed $val
     * @return mixed
     */
    public function getVal($val){
        return $this->$val;
    }

    /**
     * Run-of-the-mill setter method
     *
     * @param mixed $key
     * @param mixed $val
     */
    public function setVal($key,$val){
        $this->$key = $val;
    }

    /**
     * Returns the current time stamp
     *
     * @return string
     * @author Bryce Mickler
     * @version 1.0
     * @since 1.0
     */
    public function now()
    {
        $micro_array = explode(' ', microtime());
        $now = $micro_array[1];
        return $now;
    }

    /**
     * returns the date and time in the form:  February 26, 2007 09:25:28 PM
     *
     * @return string
     */
    public function dateTime()
    {
        return date('F d\, Y h:i:s A');
    }

    public function date()
    {
        return date("F j, Y");
    }
}
?>