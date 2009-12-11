<?php
/**
 * events/index.php
 * Shows the event details, guest list, and RSVP form
 *
 * @package niftyrsvp
 * @version 0.9 beta
 * @author Bryce Mickler <bryce@brycemickler.com>
 * @copyright 2009
 * @license http://www.freebsd.org/copyright/freebsd-license.html Free BSD License
 */
define('IN_NIFTY', true);
define('IN_EVENTS', true);
require_once("./../init.php");

/**
 * Page initialization and session
 */
$thisPageName = basename(__FILE__);
require_once(FILE_PATH . '/lang/' . CURRENT_LANGUAGE . '.php');
require_once(FILE_PATH . '/lang/' . CURRENT_LANGUAGE . '/events/' . $thisPageName);

/**
 * Page specific logic
 */
$eventMgr = new eventMgr($mdb2);
$val = new validator();

//  Grab all expected request variables and validate them.
if(isset($_POST['submit']))
{
	$expected_post = array(
		'e_id' =>			array('type' => 'integer', 'min' => 1, 'max' => 16777215),
		'name' =>			array('type' => 'string', 'min_length' => 3, 'max_length' => 30),
		'email' =>			array('type' => 'email'),
		'attending' =>		array('type' => 'string', 'min_length' => 2, 'max_length' => 3),
	);

	require_once("./../extract_vars.php");

	$args = array(
		'e_id' => $e_id,
		'name' => $name,
		'email' => $email,
		'attending' => $attending);

	try
	{
		if($eventMgr->registerAttendee($args))
		{
			$e_url = $eventMgr->getUrlById($args['e_id']);
			if(strlen($e_url) > 3)
			{
				header("Location: " . WEB_PATH . "/events/?id=$e_url");
			}
		}
	} catch ( Exception $e) {
		die($e->__toString());
	}
}
else
{
	$expected_get = array(
		'id' =>			array('type' => 'string', 'min_length' => 3, 'max_length' => 255)
	);

	require_once("./../extract_vars.php");

	$details = $eventMgr->getDetails(urlencode(strtolower(trim($id))));
	$responders = $eventMgr->getResponders(urlencode(strtolower(trim($details['id']))));
}

/**
 * Language
 */
$eventSmarty->assign('EVENT_NAME',$details['e_name']);
$eventSmarty->assign('EVENT_DATE_TIME',$details['e_date_time']);
$eventSmarty->assign('EVENT_LOCATION',$details['e_location']);
$eventSmarty->assign('EVENT_NOTES',$details['e_notes']);
$eventSmarty->assign('EVENT_ID',$details['id']);
$eventSmarty->assign('EVENT_ATTENDEES',$responders['attending']);
$eventSmarty->assign('EVENT_NON_ATTENDEES',$responders['not_attending']);

if($details['e_event_viewed'] == 'no')
{
	$eventSmarty->assign('EVENT_CREATED', 'yes');

	//  we only want the creator of the event to view the 'success' message
	$eventMgr->eventViewed($details['id']);
}

/**
 * Page display
 */
$eventSmarty->assign('HTML_TITLE',HTML_TITLE);
$eventSmarty->assign('CSS_PATH', CURRENT_TEMPLATE_PATH . 'css/');
$eventSmarty->assign('IMG_PATH',CURRENT_TEMPLATE_PATH . 'images/');
$eventSmarty->assign('WEB_PATH', WEB_PATH);

require_once(FILE_PATH . '/events/footer.php');
$footer = $eventSmarty->fetch('footer.tpl');
$eventSmarty->assign('FOOTER', $footer);

$eventSmarty->display(current(explode('.',basename(__FILE__))) . '.tpl');
?>