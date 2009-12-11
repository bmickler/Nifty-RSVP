<?php
/**
 * create/footer.php
 * Renders the bottom part of the visible HTML page including the </body> and
 * </html>
 *
 * @package niftyrsvp
 * @version 0.9 beta
 * @author Bryce Mickler <bryce@brycemickler.com>
 * @copyright 2009
 * @license http://www.freebsd.org/copyright/freebsd-license.html Free BSD License
 */
if(!defined('IN_NIFTY')){die("Hacking attempt");}//  Security feature.  This file cannot be called directly

require_once(FILE_PATH . '/lang/' . CURRENT_LANGUAGE . '/create/footer.php');
$createSmarty->assign('IMAGE_PATH',CURRENT_TEMPLATE_PATH . 'images/');

/**
 * Language
 */
$createSmarty->assign('L_URL_HOME', $lang['footer']['url_home']		);
$createSmarty->assign('L_URL_CREATE', $lang['footer']['url_create']	);
$createSmarty->assign('L_URL_HELP', $lang['footer']['url_help']		);
?>