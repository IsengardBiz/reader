<?php
/**
 * English language constants related to module information
 *
 * @copyright	Copyright Madfish (Simon Wilkinson) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		Madfish (Simon Wilkinson) <simon@isengard.biz>
 * @package		reader
 * @version		$Id$
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

define("_MI_READER_MD_NAME", "Reader");
define("_MI_READER_MD_DESC", "ImpressCMS Simple Reader");
define("_MI_READER_FEEDS", "Feeds");
define("_MI_READER_TEMPLATES", "Templates");
define("_MI_READER_MANUAL", "Manual");

// Blocks
define("_MI_READER_FEEDRECENT", "Newsfeeds");
define("_MI_READER_FEEDRECENT_DSC", "Displays a list of newsfeeds, sorted by weight.");
define("_MI_READER_FEED_RECENT_POSTS", "Recent posts");
define("_MI_READER_FEED_RECENT_POSTS_DSC", "Displays recent posts in a specific newsfeed");

// Preferences
define("_MI_READER_SHOW_BREADCRUMB", "Show breadcrumb?");
define("_MI_READER_SHOW_BREADCRUMB_DSC", "Display the horizontal navigation breadcrumb?");
define("_MI_READER_SHOW_FEED_LOGOS", "Show feed logos?");
define("_MI_READER_SHOW_FEED_LOGOS_DSC", "Toggle feed logos on or off");
define("_MI_READER_LOGO_POSITION", "Logo position");
define("_MI_READER_LOGO_POSITION_DSC", "Display feed logos on the left or right side of the page.");
define("_MI_READER_NUMBER_FEEDS_PER_PAGE", "Number of feeds to display on a page");
define("_MI_READER_NUMBER_FEEDS_PER_PAGE_DSC", "Controls how many feeds are displayed on the module 
	index page. Pagination controls will be inserted when this limit is exceeded.");
define("_MI_READER_TIMEOUT", "Feed timeout (seconds)");
define("_MI_READER_TIMEOUT_DSC", "The length of time Reader will wait for a feed to respond before 
	giving up.");
define("_MI_READER_ENABLE_CACHE", "Enable cache?");
define("_MI_READER_ENABLE_CACHE_DSC", "Caching accelerates page load time by storing the results for 
	a period specified below. Strongly recommend to enable, otherwise you will see considerably 
	slower load times while the feed is retrieved and parsed.");
define("_MI_READER_CACHE_DURATION", "Cache duration (seconds)");
define("_MI_READER_CACHE_DURATION_DSC", "The time (in seconds) that cached feeds will be stored 
	locally before being refreshed.");
define("_MI_READER_LOGO_WIDTH", "Feed logo width (pixels)");
define("_MI_READER_LOGO_WIDTH_DSC", "The width at which feed logos will be displayed. Aspect ratio 
	will be maintained in modern (sane) browsers. Adjust to suit your site layout.");
define("_MI_READER_DATE_FORMAT", "Date format");
define("_MI_READER_DATE_FORMAT_DSC", "Specify the format as per the
	<a href='http://php.net/manual/en/function.date.php'>date() function</a> in the PHP Manual.");
define("_MI_READER_DISPLAY_FEED_DESCRIPTION", "Display feed description?");
define("_MI_READER_DISPLAY_FEED_DESCRIPTION_DSC", "Sometimes publishers provide useless or spam-laden 
	feed descriptions. If the marketing department appears to be out of control, you can turn them off
	here.");
define("_MI_READER_DISPLAY_SELECT_BOX", "Display navigation select box?");
define("_MI_READER_DISPLAY_SELECT_BOX_DSC", "In single feed view, you can choose to display a 
	select box that will allow visitors to jump between feeds.");

// Preference options
define("_MI_READER_LEFT", "Left");
define("_MI_READER_RIGHT", "Right");