<?php
/**
 * class.controllerException.php
 *
 * @package niftyrsvp
 * @author Bryce Mickler <bryce@brycemickler.com>
 * @copyright 2009
 * @license http://www.freebsd.org/copyright/freebsd-license.html Free BSD License
 */
/**
 * Class for controller/business-layer exceptions
 *
 * @package niftyrsvp
 * @version 0.9 beta
 */
class controllerException extends niftyException
{
	/**
	 * Prior exception
	 *
	 * @var object PHP::Exception
	 */
	protected $priorException;

	/**
	 * Constructor
	 * Calls the parent constructor and sets the prior exception
	 *
	 * @param string $message
	 * @param mixed $code
	 * @param Exception $previous
	 */
	public function __construct($message, $code = 0, Exception $previous = null)
	{
		$this->priorException = $previous;
		parent::__construct($message, $code);
	}

	/**
	 * Getter for the priorException property
	 *
	 * @return object
	 */
	public function getPrior()
	{
		return $this->priorException;
	}
}
?>