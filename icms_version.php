<?php
/**
 * Reader version infomation
 *
 * This file holds the configuration information of this module
 *
 * @copyright	Copyright Madfish (Simon Wilkinson) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		Madfish (Simon Wilkinson) <simon@isengard.biz>
 * @package		reader
 * @version		$Id$
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

/**  General Information  */
$modversion = array(
	"name"						=> _MI_READER_MD_NAME,
	"version"					=> 1.0,
	"description"				=> _MI_READER_MD_DESC,
	"author"					=> "Madfish (Simon Wilkinson)",
	"credits"					=> "Feeds are handled using Simplepie",
	"help"						=> "",
	"license"					=> "GNU General Public License (GPL)",
	"official"					=> 0,
	"dirname"					=> basename(dirname(__FILE__)),
	"modname"					=> "reader",

/**  Images information  */
	"iconsmall"					=> "images/icon_small.png",
	"iconbig"					=> "images/icon_big.png",
	"image"						=> "images/icon_big.png", /* for backward compatibility */

/**  Development information */
	"status_version"			=> "1.0",
	"status"					=> "Beta",
	"date"						=> "Unreleased",
	"author_word"				=> "For ImpressCMS 1.3+ only.",
	"warning"					=> _CO_ICMS_WARNING_BETA,

/** Contributors */
	"developer_website_url"		=> "https://www.isengard.biz",
	"developer_website_name"	=> "Isengard.biz",
	"developer_email"			=> "simon@isengard.biz",

/** Administrative information */
	"hasAdmin"					=> 1,
	"adminindex"				=> "admin/index.php",
	"adminmenu"					=> "admin/menu.php",

/** Install and update informations */
	"onInstall"					=> "include/onupdate.inc.php",
	"onUpdate"					=> "include/onupdate.inc.php",

/** Search information */
	"hasSearch"					=> 0,

/** Menu information */
	"hasMain"					=> 1,

/** Comments information */
	"hasComments"				=> 0);

/** other possible types: testers, translators, documenters and other */
$modversion['people']['developers'][] = "Madfish (Simon Wilkinson)";

/** Manual */
$modversion['manual']['wiki'][] = "<a href='http://wiki.impresscms.org/index.php?title=Reader' target='_blank'>English</a>";

/** Database information */
$modversion['object_items'][1] = 'feed';

$modversion["tables"] = icms_getTablesArray($modversion['dirname'], $modversion['object_items']);

/** Templates information */
$modversion['templates'] = array(
	array("file" => "reader_admin_feed.html", "description" => "Feed admin index"),
	array("file" => "reader_feed.html", "description" => "Feed index"),
	array("file" => "reader_header.html", "description" => "Module header"),
	array("file" => "reader_footer.html", "description" => "Module footer"),
	array("file" => "reader_requirements.html", "description" => "Module requirements"));

/** Blocks information */
// Feed list
// Recent items (for one feed / combined)

/** Preferences information */
$modversion['config'][] = array(
	'name' => 'default_items',
	'title' => '_MI_READER_DEFAULT_ITEMS',
	'description' => '_MI_READER_DEFAULT_ITEMSDSC',
	'formtype' => 'textbox',
	'valuetype' => 'int',
	'default' =>  '10');