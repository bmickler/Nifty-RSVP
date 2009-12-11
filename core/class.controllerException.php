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
	protected $priorException;

	public function __construct($message, $code = 0, Exception $previous = null)
	{
		$this->priorException = $previous;
		parent::__construct($message, $code);
	}

	public function getPrior()
	{
		return $this->priorException;
	}
}
?>