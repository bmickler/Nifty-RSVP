<?php
/**
 * class.logger.php
 *
 * @package niftyrsvp
 * @author Bryce Mickler <bryce@brycemickler.com>
 * @copyright 2009
 * @license http://www.freebsd.org/copyright/freebsd-license.html Free BSD License
 */
/**
 * Provides error logging functionality
 *
 * @package niftyrsvp
 * @version 0.9 beta
 */
class logger
{
	/**
	 * Path to the log file
	 *
	 * @var string
	 */
	private $log_file;

	/**
	 * Handle for the file pointer
	 *
	 * @var string
	 */
	private $fp = null;

	/**
	 * Constructor
	 * Sets up the log file
	 *
	 */
	public function __construct()
	{
		$this->log_file = ERROR_LOG_FILE;
	}

	/**
	 * Creates and controls the logging of a message
	 *
	 * @param Exception $e
	 */
	public function log(Exception $e)
	{
		$config = $this->getConfig();

		$message = '[DATE]' . date('r') . '[/DATE]';
		$message .= '[MSG]' . $e->getMessage() . '[/MSG]';
		$message .= '[FILE]' . $e->getFile() . '[/FILE]';
		$message .= '[LINE]' . $e->getLine() . '[/LINE]';
		$message .= '[CODE]' . $e->getCode() . '[/CODE]';
		$message .= '[TRACE]' . preg_replace("/[\n\r\t]/",'',$e->getTraceAsString()) . '[/TRACE]';

		$config_string = '';
		foreach($config as $key => $val) {
			$config_string .= trim($key) . ': ' . trim($val) . '|';
		}
		$config_string = rtrim($config_string,'|');
		$message .= '[CFG]' . $config_string . "[/CFG]\r\n";

		$this->lwrite($message);
	}

	/**
	 * Writes a message to a log file
	 *
	 * @param string $message
	 */
	private function lwrite($message)
	{
		// if file pointer doesn't exist, then open log file
		if (!$this->fp) $this->lopen();
		// define script name
		//$script_name = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
		// define current time

		// write current time, script name and message to the log file
		fwrite($this->fp, "$message");
	}

	/**
	 * Opens the log file for writing
	 *
	 */
	private function lopen()
	{
		// define log file path and name
		//$lfile = $this->log_file;
		// define the current date (it will be appended to the log file name)
		//$today = date('Y-m-d');
		// open log file for writing only; place the file pointer at the end of the file
		// if the file does not exist, attempt to create it
		$this->fp = fopen($this->log_file, 'a') or exit("Can't open $lfile!");
	}

	/**
	 * Grabs the application configuration
	 * Grabs the application configuration for inclusion in the error message
	 *
	 * @return array
	 */
	private function getConfig()
	{
		$config = array();
		$config['version_blueprintcss'] = 	NIFTY_CONFIG_VERSION_BLUEPRINTCSS;
		$config['version_mdb2'] = 			NIFTY_CONFIG_VERSION_MDB2;
		$config['version_nifty'] = 			NIFTY_CONFIG_VERSION_NIFTY;
		$config['version_pear'] = 			NIFTY_CONFIG_VERSION_PEAR;
		$config['version_smarty'] = 		NIFTY_CONFIG_VERSION_SMARTY;
		return $config;
	}
}
?>