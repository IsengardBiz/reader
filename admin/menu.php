<?php
/**
 * Configuring the amdin side menu for the module
 *
 * @copyright	Copyright Madfish (Simon Wilkinson) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		Madfish (Simon Wilkinson) <simon@isengard.biz>
 * @package		reader
 * @version		$Id$
 */

global $icmsConfig;

$adminmenu[] = array(
	"title" => _MI_READER_FEEDS,
	"link" => "admin/feed.php");

$module = icms::handler("icms_module")->getByDirname(basename(dirname(dirname(__FILE__))));

$headermenu[] = array(
	"title" => _CO_ICMS_GOTOMODULE,
	"link" => ICMS_URL . "/modules/reader/");
$headermenu[] = array(
	"title" => _PREFERENCES,
	"link" => "../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=" . $module->getVar("mid"));

$headermenu[] = array(
	"title" => _MI_READER_TEMPLATES,
	"link" => '../../system/admin.php?fct=tplsets&op=listtpl&tplset='
		. $icmsConfig['template_set'] . '&moddir=' . basename(dirname(dirname(__FILE__))));
	
$headermenu[] = array(
	"title" => _CO_ICMS_UPDATE_MODULE,
	"link" => ICMS_URL . "/modules/system/admin.php?fct=modulesadmin&amp;op=update&amp;module=" . basename(dirname(dirname(__FILE__))));
$headermenu[] = array(
	"title" => _MODABOUT_ABOUT,
	"link" => ICMS_URL . "/modules/reader/admin/about.php");

unset($module_handler);