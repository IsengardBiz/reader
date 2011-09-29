<?php
/**
* Feed page
*
* @copyright	Copyright Madfish (Simon Wilkinson) 2011
* @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
* @since		1.0
* @author		Madfish (Simon Wilkinson) <simon@isengard.biz>
* @package		reader
* @version		$Id$
*/

include_once "header.php";

$xoopsOption["template_main"] = "reader_feed.html";
include_once ICMS_ROOT_PATH . "/header.php";

$reader_feed_handler = icms_getModuleHandler("feed", basename(dirname(__FILE__)), "reader");

/** Use a naming convention that indicates the source of the content of the variable */
$clean_feed_id = isset($_GET["feed_id"]) ? (int)$_GET["feed_id"] : 0 ;
$feedObj = $reader_feed_handler->get($clean_feed_id);

if($feedObj && !$feedObj->isNew()) {
	
	/////////////////////////////////////////
	////////// Display single feed //////////
	/////////////////////////////////////////
	
	/* Based on code from http://simplepie.org/wiki/setup/sample_page */
	
	// Make sure SimplePie is included. You may need to change this to match the location of simplepie.inc.
	require_once(ICMS_ROOT_PATH . '/libraries/simplepie/simplepie.inc');
	
	$readerModule = icms_getModuleInfo(basename(dirname(dirname(__FILE__))));

	// Set configuration options
	$feed = new SimplePie();
	$feed->set_item_limit($readerModule['default_items']);
	//$feed->enable_cache(TRUE);
	//$feed->set_cache_duration(1800);
	//$feed->set_cache_location(ICMS_ROOT_PATH . '/cache/reader');
	//$feed->encode_instead_of_strip(true);
	//$feed->strip_comments(TRUE);

	// Set which feed to process.
	$feed->set_feed_url($feedObj->getVar('identifier', 'e'));

	// Run SimplePie.
	$feed->init();

	// This makes sure that the content is sent to the browser as text/html and the UTF-8 character set (since we didn't change it).
	$feed->handle_content_type();
	
	/* end code from Simplepie */
	
	// Handle errors here
	if ($feed->error()) {
		
		echo $feed->error();
		exit;
		
	} else {
	
		// Populate the feed
		$feedArray = $feedObj->toArray();
		$feedArray['title'] = $feed->get_title();
		$feedArray['description'] = $feed->get_description();
		$feedArray['items'] = array();
		$items = $feed->get_items();
		foreach ($items as $item) {
			$itemArray = array();
			$itemArray['title'] = $item->get_title();
			$itemArray['date'] = $item->get_date();
			$itemArray['description'] = $item->get_description();
			$itemArray['authors'] = $item->get_authors();
			$itemArray['link'] = $item->get_link();
			$itemArray['enclosure'] = $item->get_enclosures();
			
			$feedArray['items'][] = $itemArray;
		}

		$icmsTpl->assign("reader_feed", $feedArray);

		//$icms_metagen = new icms_ipf_Metagen($feedObj->getVar("identifier"), $feedObj->getVar("meta_keywords", "n"), $feedObj->getVar("meta_description", "n"));
		//$icms_metagen->createMetaTags();
	}
	
} else {
	
	/////////////////////////////////////////
	////////// Display feed index ///////////
	/////////////////////////////////////////
	
	$icmsTpl->assign("reader_title", _MD_READER_ALL_FEEDS);

	$objectTable = new icms_ipf_view_Table($reader_feed_handler, FALSE, array());
	$objectTable->isForUserSide();
	$objectTable->addColumn(new icms_ipf_view_Column("identifier"));
	$icmsTpl->assign("reader_feed_table", $objectTable->fetch());
}

$icmsTpl->assign("reader_module_home", '<a href="' . ICMS_URL . "/modules/" . icms::$module->getVar("dirname") . '/">' . icms::$module->getVar("name") . "</a>");

include_once "footer.php";