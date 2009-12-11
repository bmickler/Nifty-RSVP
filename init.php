<?php
/**
 * init.php
 * Application initialization.
 * Contains settings that the user rarely would need to change.  Works in conjunction
 * with config.php
 *
 * @package niftyrsvp
 * @version 0.9 beta
 * @author Bryce Mickler <bryce@brycemickler.com>
 * @copyright 2009
 * @license http://www.freebsd.org/copyright/freebsd-license.html Free BSD License
 */
error_reporting(0);
$scriptStartTime = microtime(true);

//  Security feature.  This file cannot be called directly
if(!defined('IN_NIFTY')){die("Hacking attempt");}

require_once('config.php');


//  Application versions
define('NIFTY_CONFIG_VERSION_BLUEPRINTCSS','0.9');
define('NIFTY_CONFIG_VERSION_MDB2','2.5.0b2');
define('NIFTY_CONFIG_VERSION_NIFTY','0.9 beta');
define('NIFTY_CONFIG_VERSION_PEAR','1.9.0');
define('NIFTY_CONFIG_VERSION_SMARTY','2.6.26');

//  Application paths
define('PATH_TO_LIBS', FILE_PATH . 'libs');
define('CURRENT_LANG_DIR', FILE_PATH . '/lang/' . CURRENT_LANGUAGE . '/');
define('CURRENT_TEMPLATE_PATH', WEB_PATH . 'templates/' . CURRENT_TEMPLATE . '/');
define('ERROR_PAGE', WEB_PATH . 'error.php');
define('ERROR_LOG_FILE', FILE_PATH . '/logs/error.log');  // insecure, anyone can view logs

require_once(PATH_TO_LIBS . '/smarty/smarty/Smarty.class.php');
require_once(PATH_TO_LIBS . '/pear/PEAR.php');
require_once(PATH_TO_LIBS . '/pear/PEAR5.php');
require_once(PATH_TO_LIBS . '/pear/MDB2.php');


//  Database table definitions
define('TABLE_ATTENDEES', $table_prefix . 'attendees');
define('TABLE_EVENTS', $table_prefix . 'events');


//  PEAR::MDB2 Connection
$mdb2 = MDB2::singleton($mdb2_dsn, $mdb2_options);
if (PEAR::isError($mdb2)){die($mdb2->getMessage());}
$mdb2->setFetchMode(MDB2_FETCHMODE_ASSOC);
$mdb2->setOption('quote_identifiers', true);
$mdb2->loadModule('Extended');

//  Smarty templating engine
if(defined('IN_FRONTEND'))
{
	$smarty = new Smarty();
	$smarty->template_dir = (FILE_PATH . 'templates/' . CURRENT_TEMPLATE . '/');
	$smarty->compile_dir = (PATH_TO_LIBS . '/smarty/templates_c/');
	$smarty->config_dir = (PATH_TO_LIBS . '/smarty/configs/');
	$smarty->cache_dir = (PATH_TO_LIBS . '/smarty/cache/');
	$smarty->caching = 0;
	$smarty->cache_lifetime = 5;  // seconds; 3600= 1 hr, 86400=24 hours
	$smarty->use_sub_dirs = true;
	$smarty->clear_all_cache();
}

if(defined('IN_CREATE'))
{
	$createSmarty = new Smarty();
	$createSmarty->template_dir = (FILE_PATH . '/templates/' . CURRENT_TEMPLATE . '/create/');
	$createSmarty->compile_dir = (PATH_TO_LIBS . '/smarty/templates_c/create/');
	$createSmarty->config_dir = (PATH_TO_LIBS . '/smarty/configs/create/');
	$createSmarty->cache_dir = (PATH_TO_LIBS . '/smarty/cache/create/');
	$createSmarty->caching = 0;
	$createSmarty->cache_lifetime = 5;  // seconds; 3600= 1 hr, 86400=24 hours
	$createSmarty->use_sub_dirs = true;
	$createSmarty->clear_all_cache();
}

if(defined('IN_EVENTS'))
{
	$eventSmarty = new Smarty();
	$eventSmarty->template_dir = (FILE_PATH . '/templates/' . CURRENT_TEMPLATE . '/events/');
	$eventSmarty->compile_dir = (PATH_TO_LIBS . '/smarty/templates_c/events/');
	$eventSmarty->config_dir = (PATH_TO_LIBS . '/smarty/configs/events/');
	$eventSmarty->cache_dir = (PATH_TO_LIBS . '/smarty/cache/events/');
	$eventSmarty->caching = 0;
	$eventSmarty->cache_lifetime = 5;  // seconds; 3600= 1 hr, 86400=24 hours
	$eventSmarty->use_sub_dirs = true;
	$eventSmarty->clear_all_cache();
}

//  Session stuff
session_name(SESSION_NAME);
session_start();


//  Other important functions
function getTemplate($thisPageName)
{
    $pageNameArray = explode('.',$thisPageName);
    return $pageNameArray[0] . '.tpl';
}

function __autoload($classname)
{
    $path = FILE_PATH . '/core/';
    $classPath = $path . 'class.' . $classname . '.php';
    require_once($classPath);
}
?>