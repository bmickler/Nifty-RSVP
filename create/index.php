<?php
/**
 * create/index.php
 * Renders the event-creation form
 *
 * @package niftyrsvp
 * @version 0.9 beta
 * @author Bryce Mickler <bryce@brycemickler.com>
 * @copyright 2009
 * @license http://www.freebsd.org/copyright/freebsd-license.html Free BSD License
 */
define('IN_NIFTY', true);
define('IN_CREATE', true);
require_once("./../init.php");

/**
 * Page initialization and session
 */
$thisPageName = basename(__FILE__);
require_once(FILE_PATH . '/lang/' . CURRENT_LANGUAGE . '.php');
require_once(FILE_PATH . '/lang/' . CURRENT_LANGUAGE . '/create/' . $thisPageName);

/**
 * Page specific logic
 */
if(isset($_POST['submit']))
{
	//  Grab all expected request variables and validate them.
	$expected_post = array(
		'e_name' =>			array('type' => 'string', 'min_length' => MIN_LENGTH_EVENT_NAME, 'max_length' => MAX_LENGTH_EVENT_NAME),
		'e_date_time' =>	array('type' => 'string', 'min_length' => MIN_LENGTH_EVENT_DATETIME, 'max_length' => MAX_LENGTH_EVENT_DATETIME),
		'e_location' =>		array('type' => 'string', 'min_length' => MIN_LENGTH_EVENT_LOCATION, 'max_length' => MAX_LENGTH_EVENT_LOCATION),
		'e_notes' =>		array('type' => 'string', 'min_length' => MIN_LENGTH_EVENT_NOTES, 'max_length' => MAX_LENGTH_EVENT_NOTES)
	);

	$val = new validator();

	require("./../extract_vars.php");

	$args = array(
		'e_name' => $e_name,
		'e_date_time' => $e_date_time,
		'e_location' => $e_location,
		'e_notes' => $e_notes
	);

	$eventMgr = new eventMgr($mdb2);

	try
	{
		if($e_url = $eventMgr->createEvent($args))
		{
			//  Grab event details and send user to the event page
			header("location:" . WEB_PATH . "events/?id=$e_url");
		}
	} catch ( sqlException  $e) {
		header("location:" . ERROR_PAGE . "?e=1");
	} catch ( Exception $e) {
		header("location:" . ERROR_PAGE);
	}
}

/**
 * Language
 */

/**
 * Page display
 */
$createSmarty->assign('HTML_TITLE',HTML_TITLE);
$createSmarty->assign('CSS_PATH', CURRENT_TEMPLATE_PATH . 'css/');
$createSmarty->assign('IMG_PATH',CURRENT_TEMPLATE_PATH . 'images/');
$createSmarty->assign('WEB_PATH', WEB_PATH);

require_once(FILE_PATH . '/create/footer.php');
$footer = $createSmarty->fetch('footer.tpl');
$createSmarty->assign('FOOTER', $footer);

$createSmarty->display(current(explode('.',basename(__FILE__))) . '.tpl');
?>