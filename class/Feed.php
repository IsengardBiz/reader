<?php
/**
 * Class representing Reader feed objects
 *
 * @copyright	Copyright Madfish (Simon Wilkinson) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		Madfish (Simon Wilkinson) <simon@isengard.biz>
 * @package		reader
 * @version		$Id$
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

class mod_reader_Feed extends icms_ipf_seo_Object {
	/**
	 * Constructor
	 *
	 * @param mod_reader_Feed $handler Object handler
	 */
	public function __construct(&$handler) {
		icms_ipf_object::__construct($handler);

		$this->quickInitVar("feed_id", XOBJ_DTYPE_INT, TRUE);
		$this->quickInitVar("identifier", XOBJ_DTYPE_TXTBOX, TRUE);
		$this->quickInitVar("title", XOBJ_DTYPE_TXTBOX, FALSE);
		$this->quickInitVar("description", XOBJ_DTYPE_TXTAREA, FALSE);
		$this->quickInitVar("item_limit", XOBJ_DTYPE_INT, TRUE, FALSE, FALSE, 10);
		$this->quickInitVar("online_status", XOBJ_DTYPE_INT, TRUE, FALSE, FALSE, TRUE);
		$this->quickInitVar('weight', XOBJ_DTYPE_INT, TRUE, FALSE, FALSE, 0);
		$this->initCommonVar("counter");
		
		// Hide fields that should not be tinkered with
		$this->doHideFieldFromForm("description");
		$this->doHideFieldFromForm("last_update");
		$this->doHideFieldFromForm("counter");
		
		$this->setControl('online_status', 'yesno');
	}

	/**
	 * Overriding the icms_ipf_Object::getVar method to assign a custom method on some
	 * specific fields to handle the value before returning it
	 *
	 * @param str $key key of the field
	 * @param str $format format that is requested
	 * @return mixed value of the field that is requested
	 */
	public function getVar($key, $format = "s") {
		if ($format == "s" && in_array($key, array('online_status'))) {
			return call_user_func(array ($this,	$key));
		}
		return parent::getVar($key, $format);
	}
	
	/**
	 * Converts the online status of an object to a human readable icon with link toggle
	 *
	 * @return string 
	 */
	public function online_status() {
		
		$status = $button = '';
		
		$status = $this->getVar('online_status', 'e');
		$button = '<a href="' . ICMS_URL . '/modules/' . basename(dirname(dirname(__FILE__)))
				. '/admin/feed.php?feed_id=' . $this->getVar('feed_id')
				. '&amp;op=changeStatus">';
		if ($status == false) {
			$button .= '<img src="' . ICMS_IMAGES_SET_URL . '/actions/button_cancel.png"' 
				. _CO_READER_FEED_OFFLINE . '" title="' . _CO_READER_FEED_SWITCH_ONLINE . '" /></a>';
			
		} else {
			
			$button .= '<img src="' . ICMS_IMAGES_SET_URL . '/actions/button_ok.png"'
				. _CO_READER_FEED_ONLINE . '" title="' . _CO_READER_FEED_SWITCH_ONLINE . '" /></a>';
		}
		return $button;
	}
	
	public function getWeightControl() {
		$control = new icms_form_elements_Text('','weight[]',5,7,$this->getVar( 'weight', 'e'));
		$control->setExtra('style="text-align:center;"');
		
		return $control->render();
	}
}