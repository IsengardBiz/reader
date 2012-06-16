<?php
/**
 * Classes responsible for managing Reader feed objects
 *
 * @copyright	Copyright Madfish (Simon Wilkinson) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		Madfish (Simon Wilkinson) <simon@isengard.biz>
 * @package		reader
 * @version		$Id$
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

class mod_reader_FeedHandler extends icms_ipf_Handler {
	/**
	 * Constructor
	 *
	 * @param icms_db_legacy_Database $db database connection object
	 */
	public function __construct(&$db) {
		parent::__construct($db, "feed", "feed_id", "title", "description", "reader");

	}
	
	/**
	 * Toggles a feed on or offline
	 *
	 * @param int $feed_id
	 * @param str $field
	 * @return int $visibility
	 */
	public function changeOnlineStatus($feed_id, $field) {
		
		$visibility = $feedObj = '';
		
		$feedObj = $this->get($feed_id);
		if ($feedObj->getVar($field, 'e') == true) {
			$feedObj->setVar($field, 0);
			$visibility = 0;
		} else {
			$feedObj->setVar($field, 1);
			$visibility = 1;
		}
		$this->insert($feedObj, true);
		
		return $visibility;
	}
	
	/**
	 * Checks that a feed exists before saving it in the database and populates the title/description fields
	 * 
	 * @param object $obj
	 * @return bool 
	 */

	protected function beforeSave(& $obj)
	{
		$readerModule = icms_getModuleInfo("reader");
		
		// Make sure SimplePie is included.
		require_once(ICMS_ROOT_PATH . '/libraries/simplepie/simplepie.inc');

		// We'll process this feed with all of the default options.
		$feed = new SimplePie();

		// Set which feed to process.
		$feed->set_feed_url($obj->getVar('identifier', 'e'));
		
		// Set timeout
		$feed->set_timeout(icms_getConfig('timeout', $readerModule->getVar("dirname")));
		
		// Force feed to cope with publishers who do stupid things to feeds
		$feed->force_feed(TRUE);

		// Run SimplePie.
		$feed->init();

		// This makes sure that the content is sent to the browser as text/html and the UTF-8 character set (since we didn't change it).
		$feed->handle_content_type();
		
		// Handle errors here
		if ($feed->error())
		{
			$obj->setErrors($feed->error());
			return FALSE;
		}
		else
		{
			// The feed title can be set automatically by leaving the field blank. However, some 
			// publishers prepend titles with useless marketing crap. Therefore the admin can 
			// choose to enter or edit the feed title manually.
			$title = trim($obj->getVar('title', 'e'));
			if (empty($title))
			{
				$obj->setVar('title', $feed->get_title());
			}
			$obj->setVar('description', $feed->get_description());
			return TRUE;
		}
	}

}