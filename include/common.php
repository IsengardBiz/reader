<?php
/**
 * Common file of the module included on all pages of the module
 *
 * @copyright	Copyright Madfish (Simon Wilkinson) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		Madfish (Simon Wilkinson) <simon@isengard.biz>
 * @package		reader
 * @version		$Id$
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

if (!defined("READER_DIRNAME")) define("READER_DIRNAME", $modversion["dirname"] = basename(dirname(dirname(__FILE__))));
if (!defined("READER_URL")) define("READER_URL", ICMS_URL."/modules/".READER_DIRNAME."/");
if (!defined("READER_ROOT_PATH")) define("READER_ROOT_PATH", ICMS_ROOT_PATH."/modules/".READER_DIRNAME."/");
if (!defined("READER_IMAGES_URL")) define("READER_IMAGES_URL", READER_URL."images/");
if (!defined("READER_ADMIN_URL")) define("READER_ADMIN_URL", READER_URL."admin/");

// Include the common language file of the module
icms_loadLanguageFile("reader", "common");