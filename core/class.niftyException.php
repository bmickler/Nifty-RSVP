<?php
/**
 * class.niftyException.php
 *
 * @package niftyrsvp
 * @author Bryce Mickler <bryce@brycemickler.com>
 * @copyright 2009
 * @license http://www.freebsd.org/copyright/freebsd-license.html Free BSD License
 */
/**
 * Parent class for exceptions
 * A child class of Exception, this class is the parent class of all exceptions
 * defined in this project.  This class is responsible for logging problems via
 * the logger class.
 *
 * @package niftyrsvp
 * @version 0.9 beta
 */
class niftyException extends Exception
{
	/**
	 * Prior exception object
	 *
	 * @var Exception
	 */
	protected $priorException;

	/**
	 * Logger object
	 *
	 * @var Logger
	 */
	private $logger;

	/**
	 * Sets up the niftyException object
	 *
	 * @param string $message
	 * @param mixed $code
	 * @param Exception $previous
	 */
	public function __construct($message, $code = 0, Exception $previous = null)
	{
		$this->priorException = $previous;
		parent::__construct($message, $code);

		$this->logger = new logger();

		$this->logger->log($this);
	}

	/**
	 * Gets the previous exception object
	 *
	 * @return Exception
	 */
	public function getPrior()
	{
		return $this->priorException;
	}
}
?>