<?php
/**
 * index.php
 * Initial page for the application
 *
 * @package niftyrsvp
 * @version 0.9 beta
 * @author Bryce Mickler <bryce@brycemickler.com>
 * @copyright 2009
 * @license http://www.freebsd.org/copyright/freebsd-license.html Free BSD License
 */
define('IN_NIFTY',true);
define('IN_FRONTEND', true);

require_once('init.php');

/**
 * Page initialization and session
 */
$thisPageName = basename(__FILE__);
require_once(FILE_PATH . '/lang/' . CURRENT_LANGUAGE . '.php');
require_once(FILE_PATH . '/lang/' . CURRENT_LANGUAGE . '/' . $thisPageName);

/**
 *
 */
$datetime = date("l F jS\, Y \- h:i:s A") . ' (EST)';
$smarty->assign('CURRENT_DATETIME',$datetime);
$smarty->assign('WEB_PATH',WEB_PATH);
$smarty->assign('LOGO_PATH',CURRENT_TEMPLATE_PATH . 'images/logo.gif');

/**
 * Language
 */
$smarty->assign('HTML_TITLE',HTML_TITLE);
$smarty->assign('CSS_PATH', CURRENT_TEMPLATE_PATH . 'css/');
$smarty->assign('IMG_PATH',CURRENT_TEMPLATE_PATH . 'images/');
$smarty->assign('HELP_URL',WEB_PATH . 'help.php?page=index');

/**
 * Page display
 */
require_once('footer.php');
$footer = $smarty->fetch('footer.tpl');
$smarty->assign('FOOTER', $footer);

$smarty->display(current(explode('.',basename(__FILE__))) . '.tpl');
?>