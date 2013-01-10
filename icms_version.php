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
	"version"					=> "1.06",
	"description"				=> _MI_READER_MD_DESC,
	"author"					=> "Madfish (Simon Wilkinson)",
	"credits"					=> "Feeds are handled using the Simplepie Library. Other contributors: Will",
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
	"status_version"			=> "1.06",
	"status"					=> "Beta",
	"date"						=> "10/1/2013",
	"author_word"				=> "For ImpressCMS 1.3.4 and higher. Please use V1.05 for ImpressCMS 1.3.1 to 1.3.3.",

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
$modversion['blocks'][1] = array(
	'file' => 'feed_recent.php',
	'name' => _MI_READER_FEEDRECENT,
	'description' => _MI_READER_FEEDRECENT_DSC,
	'show_func' => 'reader_feed_recent_show',
	'edit_func' => 'reader_feed_recent_edit',
	'options' => '5',
	'template' => 'reader_feed_recent.html');

$modversion['blocks'][] = array(
	'file' => 'feed_recent_posts.php',
	'name' => _MI_READER_FEED_RECENT_POSTS,
	'description' => _MI_READER_FEED_RECENT_POSTS_DSC,
	'show_func' => 'reader_feed_recent_posts_show',
	'edit_func' => 'reader_feed_recent_posts_edit',
	'options' => '0|5',
	'template' => 'reader_feed_recent_posts.html');

/** Preferences information */

$modversion['config'][1] = array(
	'name' => 'show_breadcrumb',
	'title' => '_MI_READER_SHOW_BREADCRUMB',
	'description' => '_MI_READER_SHOW_BREADCRUMB_DSC',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => '1');

$modversion['config'][] = array(
	'name' => 'show_feed_logos',
	'title' => '_MI_READER_SHOW_FEED_LOGOS',
	'description' => '_MI_READER_SHOW_FEED_LOGOS_DSC',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' => '0');

$modversion['config'][] = array(
	'name' => 'logo_position',
	'title' => '_MI_READER_LOGO_POSITION',
	'description' => '_MI_READER_LOGO_POSITION_DSC',
	'formtype' => 'select',
	'valuetype' => 'int',
	'options' => array('_MI_READER_LEFT' => 0, '_MI_READER_RIGHT' => 1),
	'default' => '1');

$modversion['config'][] = array(
	'name' => 'number_of_feeds_per_page',
	'title' => '_MI_READER_NUMBER_FEEDS_PER_PAGE',
	'description' => '_MI_READER_NUMBER_FEEDS_PER_PAGE_DSC',
	'formtype' => 'textbox',
	'valuetype' => 'int',
	'default' =>  '5');

$modversion['config'][] = array(
	'name' => 'timeout',
	'title' => '_MI_READER_TIMEOUT',
	'description' => '_MI_READER_TIMEOUT_DSC',
	'formtype' => 'textbox',
	'valuetype' => 'int',
	'default' =>  '20');

$modversion['config'][] = array(
	'name' => 'enable_cache',
	'title' => '_MI_READER_ENABLE_CACHE',
	'description' => '_MI_READER_ENABLE_CACHE_DSC',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' =>  '1');

$modversion['config'][] = array(
	'name' => 'cache_duration',
	'title' => '_MI_READER_CACHE_DURATION',
	'description' => '_MI_READER_CACHE_DURATION_DSC',
	'formtype' => 'textbox',
	'valuetype' => 'int',
	'default' =>  '86400');

$modversion['config'][] = array(
	'name' => 'image_width',
	'title' => '_MI_READER_LOGO_WIDTH',
	'description' => '_MI_READER_LOGO_WIDTH_DSC',
	'formtype' => 'textbox',
	'valuetype' => 'int',
	'default' =>  '100');

$modversion['config'][] = array(
	'name' => 'date_format',
	'title' => '_MI_READER_DATE_FORMAT',
	'description' => '_MI_READER_DATE_FORMAT_DSC',
	'formtype' => 'textbox',
	'valuetype' => 'text',
	'default' =>  'j/n/Y');

$modversion['config'][] = array(
	'name' => 'display_feed_description',
	'title' => '_MI_READER_DISPLAY_FEED_DESCRIPTION',
	'description' => '_MI_READER_DISPLAY_FEED_DESCRIPTION_DSC',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' =>  '1');

$modversion['config'][] = array(
	'name' => 'display_select_box',
	'title' => '_MI_READER_DISPLAY_SELECT_BOX',
	'description' => '_MI_READER_DISPLAY_SELECT_BOX_DSC',
	'formtype' => 'yesno',
	'valuetype' => 'int',
	'default' =>  '1');