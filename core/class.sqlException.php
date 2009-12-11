<?php
/**
 * class.sqlException.php
 *
 * @package niftyrsvp
 * @author Bryce Mickler <bryce@brycemickler.com>
 * @copyright 2009
 * @license http://www.freebsd.org/copyright/freebsd-license.html Free BSD License
 */
/**
 * Handles SQL-related exceptions
 *
 * @package niftyrsvp
 * @version 0.9 beta
 */
class sqlException extends niftyException
{
	/**
	 * Holds any prior exception objects
	 *
	 * @var Exception
	 */
	protected $priorException;

	/**
	 * Sets up the sqlException object
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
	 * Grabs any previous exception objects
	 *
	 * @return Exception
	 */
	public function getPrior()
	{
		return $this->priorException;
	}
}
?>