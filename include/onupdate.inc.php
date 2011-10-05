<?php
/**
 * File containing onUpdate and onInstall functions for the module
 *
 * This file is included by the core in order to trigger onInstall or onUpdate functions when needed.
 * Of course, onUpdate function will be triggered when the module is updated, and onInstall when
 * the module is originally installed. The name of this file needs to be defined in the
 * icms_version.php
 *
 * <code>
 * $modversion['onInstall'] = "include/onupdate.inc.php";
 * $modversion['onUpdate'] = "include/onupdate.inc.php";
 * </code>
 *
 * @copyright	Copyright Madfish (Simon Wilkinson) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		Madfish (Simon Wilkinson) <simon@isengard.biz>
 * @package		reader
 * @version		$Id$
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

// this needs to be the latest db version
define('READER_DB_VERSION', 1);

/**
 * it is possible to define custom functions which will be call when the module is updating at the
 * correct time in update incrementation. Simpy define a function named <direname_db_upgrade_db_version>
 */
/*
function reader_db_upgrade_1() {
}
function reader_db_upgrade_2() {
}
*/

function icms_module_update_reader($module) {
    return TRUE;
}

function icms_module_install_reader($module) {	
	return TRUE;
}