<?php
/**
 * Shows a list of news feeds
 *
 * @copyright	http://smartfactory.ca The SmartFactory
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		marcan aka Marc-André Lanciault <marcan@smartfactory.ca>
 * Modified for use in the Reader module by Madfish
 * @version		$Id$
 */

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

function reader_feed_recent_show($options) {
	$readerModule = icms_getModuleInfo('reader');
	include_once(ICMS_ROOT_PATH . '/modules/' . $readerModule->getVar("dirname") . '/include/common.php');
	$reader_feed_handler = icms_getModuleHandler("feed", $readerModule->getVar("dirname"), "reader");
	$criteria = icms_buildCriteria(array('online_status' => '1'));
	$criteria->setStart(0);
	$criteria->setLimit($options[0]);
	$criteria->setSort('weight');
	$criteria->setOrder('ASC');
	$block['reader_feedlist'] = $reader_feed_handler->getObjects($criteria, false, false);
	$block['reader_base_url'] = ICMS_URL . '/modules/' . $readerModule->getVar("dirname") . '/feed.php?feed_id=';
	return $block;
}

function reader_feed_recent_edit($options) {
	$readerModule = icms_getModuleInfo('reader');
	include_once(ICMS_ROOT_PATH . '/modules/' . $readerModule->getVar("dirname") . '/include/common.php');
	$reader_feed_handler = icms_getModuleHandler("feed", $readerModule->getVar("dirname"), "reader");

	// select number of feeds to display in this block
	$form = '<table><tr>';
	$form .= '<tr><td>' . _MB_READER_NUMBER_OF_FEEDS . '</td>';
	$form .= '<td>' . '<input type="text" name="options[]" value="' . $options[0] . '"/></td>';
	$form .= '</tr></table>';
	return $form;
}