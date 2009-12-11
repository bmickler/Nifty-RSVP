<?php
/**
 * config.php
 * Application configuration file
 * Contains settings that are specific to the to the installation.
 *
 * @package niftyrsvp
 * @version 0.9 beta
 * @author Bryce Mickler <bryce@brycemickler.com>
 * @copyright 2009
 * @license http://www.freebsd.org/copyright/freebsd-license.html Free BSD License
 */
if(!defined('IN_NIFTY')){die("Hacking attempt");}//  Security feature.  This file cannot be called directly

define('WEB_PATH','http://aag0k8ubm63051/nifty-rsvp/');
define('FILE_PATH','c:\http\www\nifty-rsvp\\');
define('DOMAIN_NAME','aag0k8ubm63051');

//define('WEB_PATH','http://bluenote/niftyrsvp/');
//define('FILE_PATH','/var/www/niftyrsvp/');
//define('DOMAIN_NAME','bluenote');

define('HTML_TITLE','Nifty RSVP');
define('SITE_TITLE','Nifty RSVP');
define('CURRENT_TEMPLATE','simple');
define('CURRENT_LANGUAGE', 'english');
define('SESSION_TIMEOUT',11120); //max age (in seconds) before session expires & logs out user
define('SESSION_CLEANUP_TIME',SESSION_TIMEOUT + 30); // scrub the DB for sessions older than this
define('SESSION_NAME','niftyrsvp');
define('BAD_CHARACTERS', "/[\#\$\%\*\(\)\?\<\>]/");

// don't change these unless you make the necessary changes in the database as well
define('MIN_LENGTH_EVENT_NAME', 3);
define('MAX_LENGTH_EVENT_NAME', 255);
define('MIN_LENGTH_EVENT_DATETIME', 3);
define('MAX_LENGTH_EVENT_DATETIME', 255);
define('MIN_LENGTH_EVENT_LOCATION', 3);
define('MAX_LENGTH_EVENT_LOCATION', 255);
define('MIN_LENGTH_EVENT_NOTES', 0);
define('MAX_LENGTH_EVENT_NOTES', 4000);  //  max is 65,535 characters for Mysql TEXT type


$table_prefix = 'nifty_';	//  database table prefixes

/**
 * Database connection settings.  Please reference the PEAR MDB2 online documentation
 * for more information on changing these settings.
 */
$mdb2_dsn = array(
    'phptype'  => 'mysql',
    'username' => 'dev_niftyrsvp',
    'password' => 'dev_niftyrsvp',
    'hostspec' => 'localhost',
    'port'     => '3306',
    'database' => 'dev_niftyrsvp'
);

$mdb2_options = array(
    'debug'       => 2,
    'portability' => 'MDB2_PORTABILITY_ALL',
);
?>