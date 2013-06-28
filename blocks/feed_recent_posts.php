<?php

/**
 * Shows a list of the latest posts in a selected newsfeed (or all feeds).
 *
 * @copyright	http://smartfactory.ca The SmartFactory
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		marcan aka Marc-André Lanciault <marcan@smartfactory.ca>
 * Modified for use in the Reader module by Madfish
 * @version		$Id$
 */

if (!defined("ICMS_ROOT_PATH")) die("ICMS root path not defined");

function reader_feed_recent_posts_show($options)
{	
	$readerModule = icms_getModuleInfo("reader");
	include_once(ICMS_ROOT_PATH . '/modules/' . $readerModule->getVar("dirname") . '/include/common.php');
	require_once(ICMS_ROOT_PATH . '/libraries/simplepie/autoloader.php');
	$block = $feedObjArray = $feedUrls = array();
	$reader_feed_handler = icms_getModuleHandler("feed", $readerModule->getVar("dirname"), "reader");
	
	// Handle multifeeds ($options[0] = 0)
	if ($options[0] == 0)
	{
		$criteria = icms_buildCriteria(array("online_status" => "1"));
		$feedObjArray = $reader_feed_handler->getObjects($criteria);
	}
	else
	{
		$criteria = icms_buildCriteria(array("feed_id" => $options[0], "online_status" => "1"));
		$feedObjArray = $reader_feed_handler->getObjects($criteria);
	}
	
	foreach ($feedObjArray as $feedObj)
	{
		// Check the feed(s) are marked online
		if (!empty($feedObj) && $feedObj->getVar('online_status') == TRUE)
		{
			$feedUrls[] = $feedObj->getVar('identifier', 'e');
		}
	}			
			
	// Retrieve the feed (including multifeeds)
	$feed = new SimplePie();
	$feed->set_timeout(icms_getConfig('timeout', $readerModule->getVar("dirname")));
	$feed->enable_cache(icms_getConfig('enable_cache', $readerModule->getVar("dirname")));
	$feed->set_cache_duration(icms_getConfig('cache_duration', $readerModule->getVar("dirname")));
	$feed->set_cache_location(ICMS_ROOT_PATH . '/cache');
	$feed->set_feed_url($feedUrls);

	// Run SimplePie.
	$feed->init();
		
	// Makes sure that the content is sent to the browser as text/html and the UTF-8 character set (since we didn't change it).
	$feed->handle_content_type();

	// Retrieve the last X posts
	$items = $feed->get_items(0, $options[1]);
	
	// Block Data 
    $blockFeeds = array(0 => _MB_READER_ALL_FEEDS) + $reader_feed_handler->getList($criteria); //$options[0]; 
    $block['feed'] = $blockFeeds[$options[0]];
	
	// Assign to array
	foreach ($items as $item)
	{
		$itemArray = array();
		$itemArray['title'] = $item->get_title();
		$itemArray['link'] = $item->get_link();
		$itemArray['date'] = $item->get_date(icms_getConfig('date_format', $readerModule->getVar("dirname")));
		$itemArray['description'] = $item->get_description(); // Mr Theme
		$block['reader_recent_posts'][] = $itemArray;
	}
	
	return $block;
}

function reader_feed_recent_posts_edit($options) {
	$readerModule = icms_getModuleInfo("reader");
	include_once(ICMS_ROOT_PATH . "/modules/" . $readerModule->getVar("dirname") . "/include/common.php");
	$reader_feed_handler = icms_getModuleHandler("feed", $readerModule->getVar("dirname"), "reader");
	
	// Prepare an array of newsfeeds
	$criteria = icms_buildCriteria(array("online_status" => "1"));
	$criteria->setSort("weight");
	$criteria->setOrder("ASC");
	$newsfeed_array = array(0 => _MB_READER_ALL_FEEDS) + $reader_feed_handler->getList($criteria);
	
	// Select the newsfeed to display
	$form = '<table><tr>';
	$form .= '<tr><td>' . _MB_READER_SELECT_FEED . '</td>';	
	// Parameters XoopsFormSelect: ($caption, $name, $value = null, $size = 1, $multiple = false)
	$form_feed_select = new icms_form_elements_Select('', 'options[0]', $options[0], '3', false);
	$form_feed_select->addOptionArray($newsfeed_array);
	$form .= '<td>' . $form_feed_select->render() . '</td></tr>';

	// Select number of posts to display in this block
	$form .= '<tr><td>' . _MB_READER_NUMBER_OF_POSTS . '</td>';
	$form .= '<td>' . '<input type="text" name="options[1]" value="' . $options[1] . '"/></td>';
	$form .= '</tr></table>';
	return $form;
}