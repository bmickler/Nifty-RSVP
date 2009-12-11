<?php
/**
 * events/footer.php
 * Renders the bottom part of the visible HTML page including the </body> and
 * </html>
 *
 * @package niftyrsvp
 * @version 0.9 beta
 * @author Bryce Mickler <bryce@brycemickler.com>
 * @copyright 2009
 * @license http://www.freebsd.org/copyright/freebsd-license.html Free BSD License
 */
/**
 * Security feature.  This file cannot be called directly by a user and must be called
 * from a script within the admin/ directory
 */
if(!defined('IN_NIFTY')){die("Hacking attempt");}

require_once(FILE_PATH . '/lang/' . CURRENT_LANGUAGE . '/events/footer.php');
$eventSmarty->assign('IMAGE_PATH',CURRENT_TEMPLATE_PATH . 'images/');

/**
 * Language
 */
$eventSmarty->assign('L_URL_HOME', $lang['footer']['url_home']		);
$eventSmarty->assign('L_URL_CREATE', $lang['footer']['url_create']	);
$eventSmarty->assign('L_URL_HELP', $lang['footer']['url_help']		);
?>