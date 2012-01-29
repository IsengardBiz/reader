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

// Include the Simplepie library
require_once(ICMS_ROOT_PATH . '/libraries/simplepie/simplepie.inc');

$reader_feed_handler = icms_getModuleHandler("feed", basename(dirname(__FILE__)), "reader");

/** Use a naming convention that indicates the source of the content of the variable */
$clean_feed_id = isset($_GET["feed_id"]) ? (int)$_GET["feed_id"] : 0 ;
$clean_start = isset($_GET["start"]) ? (int)$_GET["start"] : 0 ;

$feedObj = $reader_feed_handler->get($clean_feed_id);

// Check if feed is marked online
if ($feedObj->getVar('online_status', 'e') == 0) {
	unset($feedObj);
	$feedObj = $reader_feed_handler->get(0);
}

if($feedObj && !$feedObj->isNew()) {
	
	/////////////////////////////////////////
	////////// Display single feed //////////
	/////////////////////////////////////////
	
	// Display feed navigation select box
	if (icms::$module->config["display_select_box"])
	{
		// Create select box options
		$criteria = icms_buildCriteria(array("online_status" => "1"));
		$feed_select_options = array(0 => _CO_READER_SELECT_FEED) + $reader_feed_handler->getList($criteria);

		// Build feed select box
		$form = '<div><form name="feed_selection_form" action="feed.php" method="get">';
		$form .= '<select name="feed_id" id="feed_id" onchange="this.form.submit()">';
		foreach ($feed_select_options as $key => $value)
		{
			$form .= '<option value="' . $key . '">' . $value . '</option>';
		}
		$form .= '</select></form></div>';
		
		// Assign select box to template
		$icmsTpl->assign('reader_feed_select_box', $form);
	}
	
	// Configure feed
	$feed = new SimplePie();
	$feed->set_timeout(icms::$module->config['timeout']);
	$feed->set_autodiscovery_level(SIMPLEPIE_LOCATOR_ALL);
	$feed->set_autodiscovery_cache_duration(1209600);
	$feed->enable_cache(icms::$module->config['enable_cache']);
	$feed->set_cache_duration(icms::$module->config['cache_duration']);
	$feed->set_cache_location(ICMS_ROOT_PATH . '/cache');
	// Add images to the default list of html tags to strip
	$feed->strip_htmltags(array('img'));
	// You can review the default list via the *property* $feed->strip_htmltags
	$feed->strip_comments(TRUE);

	// Set which feed to process.
	$feed->set_feed_url($feedObj->getVar('identifier', 'e'));
	
	// Force feed to cope with publishers who do stupid things to feeds
	$feed->force_feed(TRUE);

	// Run SimplePie.
	$feed->init();

	// Makes sure that the content is sent to the browser as text/html and the UTF-8 character set (since we didn't change it).
	$feed->handle_content_type();
	
	// Handle errors here
	if ($feed->error()) {
		echo $feed->error();
		
	} else {
	
		// Populate the feed
		$feedArray = $feedObj->toArray();
		$feedArray['title'] = $feed->get_title();
		$feedArray['description'] = $feed->get_description();
		if (icms::$module->config['show_feed_logos'])
		{
			$feedArray['image_url'] = urldecode($feed->get_image_url());
		}
		$feedArray['image_title'] = $feed->get_image_title();
		$feedArray['permalink'] = urldecode($feed->get_permalink());
		$feedArray['image_width'] = icms::$module->config['image_width'];
		$feedArray['subscribe_feed'] = urldecode($feed->subscribe_feed());
		$feedArray['items'] = array();
		$items = $feed->get_items(0, $feedObj->getVar('item_limit', 'e'));
		foreach ($items as $item) {
			$itemArray = array();
			$itemArray['title'] = $item->get_title();
			$itemArray['date'] = $item->get_date(icms::$module->config['date_format']);
			$itemArray['description'] = $item->get_description();
			$itemArray['authors'] = $item->get_authors();
			$itemArray['link'] = urldecode($item->get_link());
			$enclosure = $item->get_enclosure();
			if (!empty($enclosure))
			{
				$itemArray['enclosure_link'] = urldecode($enclosure->get_link());
				$itemArray['enclosure_type'] = $enclosure->get_real_type();
				$itemArray['enclosure_size'] = $enclosure->get_size();
				if (!empty($itemArray['enclosure_type']))
				{
					// Expand the list to add other icons later on. Most enclosures will be 
					// either audio or video, so not too many will be needed.
					switch ($itemArray['enclosure_type'])
					{
						case 'audio/mpeg':
							$itemArray['enclosure_image'] = READER_IMAGES_URL . 'audio.png';
							break;
						
						default:
							$itemArray['enclosure_image'] = READER_IMAGES_URL . 'download.png';
						
					}
				}
			}
			
			$feedArray['items'][] = $itemArray;
			unset($enclosure);
		}

		$icmsTpl->assign("reader_feed", $feedArray);
		$icmsTpl->assign("reader_show_breadcrumb", icms::$module->config['show_breadcrumb']);
		$icmsTpl->assign('reader_category_path', ' ' . $feedArray['title']);

		//$icms_metagen = new icms_ipf_Metagen($feedObj->getVar("identifier"), $feedObj->getVar("meta_keywords", "n"), $feedObj->getVar("meta_description", "n"));
		//$icms_metagen->createMetaTags();
	}
	
} else {
	
	/////////////////////////////////////////
	////////// Display feed index ///////////
	/////////////////////////////////////////
	
	$icmsTpl->assign("reader_title", _MD_READER_ALL_FEEDS);
	
	// Retrieve a list of feeds + count the total number of feeds
	$criteria = icms_buildCriteria(array('online_status' => '1'));
	$feedCount = $reader_feed_handler->getCount($criteria);
	$criteria->setStart($clean_start);
	$criteria->setLimit(icms::$module->config['number_of_feeds_per_page']);
	$criteria->setSort('weight');
	$criteria->setOrder('ASC');
	$feed_array = $reader_feed_handler->getObjects($criteria, FALSE, FALSE);
	
	// Display feed navigation select box *if* the number of feeds exceeds the pagination limit
	if (icms::$module->config["display_select_box"] && $feedCount > icms::$module->config['number_of_feeds_per_page'])
	{
		// Create select box options
		$criteria = icms_buildCriteria(array("online_status" => "1"));
		$feed_select_options = array(0 => _CO_READER_SELECT_FEED) + $reader_feed_handler->getList($criteria);

		// Build feed select box
		$form = '<div><form name="feed_selection_form" action="feed.php" method="get">';
		$form .= '<select name="feed_id" id="feed_id" onchange="this.form.submit()">';
		foreach ($feed_select_options as $key => $value)
		{
			$form .= '<option value="' . $key . '">' . $value . '</option>';
		}
		$form .= '</select></form></div>';
		
		// Assign select box to template
		$icmsTpl->assign('reader_feed_select_box', $form);
	}
	
	// Configure feeds
	foreach ($feed_array as & $myfeed)
	{
		$feed = new SimplePie();
		$feed->set_timeout(icms::$module->config['timeout']);
		$feed->enable_cache(icms::$module->config['enable_cache']);
		$feed->set_cache_duration(icms::$module->config['cache_duration']);
		$feed->set_cache_location(ICMS_ROOT_PATH . '/cache');
		$feed->strip_comments(TRUE);

		// Set which feed to process.
		$feed->set_feed_url($myfeed['identifier']);
		
		// Force feed to cope with publishers who do stupid things to feeds
		$feed->force_feed(TRUE);

		// Run SimplePie.
		$feed->init();

		// Makes sure that the content is sent to the browser as text/html and the UTF-8 character set (since we didn't change it).
		$feed->handle_content_type();
		
		if ($feed->error())
		{
			// Remove feed from display
			unset($feed);
		}
		else
		{
			// Populate feed
			$myfeed['title'] = $feed->get_title();
			$author = $feed->get_author();
			if (is_object($author))
			{
				$myfeed['author'] = $author->get_name();
			}
			$myfeed['description'] = $feed->get_description();
			$item = $feed->get_item(0);
			if(!empty($item))
			{
				$myfeed['date'] = $item->get_date(icms::$module->config['date_format']);
			}
			if (icms::$module->config['show_feed_logos'])
			{
				$myfeed['image_url'] = urldecode($feed->get_image_url());
			}
			$myfeed['image_title'] = $feed->get_image_title();
			$myfeed['image_width'] = icms::$module->config['image_width'];
			unset($feed, $author, $item);		
		}
	}
	
	$icmsTpl->assign('reader_feeds', $feed_array);
	$icmsTpl->assign("reader_show_breadcrumb", icms::$module->config['show_breadcrumb']);
	
	// Pagination controls
	$feed_count = $reader_feed_handler->getCount($criteria);
	$pagenav = new icms_view_PageNav($feed_count, icms::$module->config['number_of_feeds_per_page'],
		$clean_start, 'start');
	$icmsTpl->assign('reader_navbar', $pagenav->renderNav());
}

	// Set feed logo position
	if (icms::$module->config['logo_position'] == 0)
	{
		$icmsTpl->assign('reader_logo_position', 'reader_float_left');
	}
	else
	{
		$icmsTpl->assign('reader_logo_position', 'reader_float_right');
}

$icmsTpl->assign("reader_module_home", '<a href="' . ICMS_URL . "/modules/" . icms::$module->getVar("dirname") . '/">' . icms::$module->getVar("name") . "</a>");

include_once "footer.php";