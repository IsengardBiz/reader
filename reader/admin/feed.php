<?php
/**
 * Admin page to manage feeds
 *
 * List, add, edit and delete feed objects
 *
 * @copyright	Copyright Madfish (Simon Wilkinson) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		Madfish (Simon Wilkinson) <simon@isengard.biz>
 * @package		reader
 * @version		$Id$
 */

/**
 * Edit a Feed
 *
 * @param int $feed_id Feedid to be edited
*/
function editfeed($feed_id = 0) {
	global $reader_feed_handler, $icmsModule, $icmsAdminTpl;

	$feedObj = $reader_feed_handler->get($feed_id);

	if (!$feedObj->isNew()){
		$icmsModule->displayAdminMenu(0, _AM_READER_FEEDS . " > " . _CO_ICMS_EDITING);
		$sform = $feedObj->getForm(_AM_READER_FEED_EDIT, "addfeed");
		$sform->assign($icmsAdminTpl);
	} else {
		$icmsModule->displayAdminMenu(0, _AM_READER_FEEDS . " > " . _CO_ICMS_CREATINGNEW);
		$sform = $feedObj->getForm(_AM_READER_FEED_CREATE, "addfeed");
		$sform->assign($icmsAdminTpl);

	}
	$icmsAdminTpl->display("db:reader_admin_feed.html");
}

include_once "admin_header.php";

$reader_feed_handler = icms_getModuleHandler("feed", basename(dirname(dirname(__FILE__))), "reader");

$clean_op = "";
/** Create a whitelist of valid values, be sure to use appropriate types for each value
 * Be sure to include a value for no parameter, if you have a default condition
 */
$valid_op = array ("mod", "changedField", "addfeed", "del", "view", "changeStatus", "changeWeight", "");

if (isset($_GET["op"])) $clean_op = htmlentities($_GET["op"]);
if (isset($_POST["op"])) $clean_op = htmlentities($_POST["op"]);

/** Again, use a naming convention that indicates the source of the content of the variable */
$clean_feed_id = isset($_GET["feed_id"]) ? (int)$_GET["feed_id"] : 0 ;

/**
 * in_array() is a native PHP function that will determine if the value of the
 * first argument is found in the array listed in the second argument. Strings
 * are case sensitive and the 3rd argument determines whether type matching is
 * required
*/
if (in_array($clean_op, $valid_op, TRUE)) {
	switch ($clean_op) {
		case "mod":
		case "changedField":
			icms_cp_header();
			editfeed($clean_feed_id);
			break;

		case "addfeed":
			$controller = new icms_ipf_Controller($reader_feed_handler);
			$controller->storeFromDefaultForm(_AM_READER_FEED_CREATED, _AM_READER_FEED_MODIFIED);
			break;

		case "del":
			$controller = new icms_ipf_Controller($reader_feed_handler);
			$controller->handleObjectDeletion();
			break;

		case "view" :
			$feedObj = $reader_feed_handler->get($clean_feed_id);
			icms_cp_header();
			$feedObj->displaySingleObject();
			break;
		
		case "changeStatus":
			$status = $ret = '';
			$status = $reader_feed_handler->changeOnlineStatus($clean_feed_id, 'online_status');
			$ret = '/modules/' . basename(dirname(dirname(__FILE__))) . '/admin/feed.php';
			if ($status == 0) {
				redirect_header(ICMS_URL . $ret, 2, _AM_READER_FEED_OFFLINE);
			} else {
				redirect_header(ICMS_URL . $ret, 2, _AM_READER_FEED_ONLINE);
			}
			break;
			
		case "changeWeight":
			foreach ($_POST['mod_reader_Feed_objects'] as $key => $value) {
				$changed = false;
				$feedObj = $reader_feed_handler->get($value);

				if ($feedObj->getVar('weight', 'e') != $_POST['weight'][$key]) {
					$feedObj->setVar('weight', intval($_POST['weight'][$key]));
					$changed = true;
				}
				if ($changed) {
					$reader_feed_handler->insert($feedObj);
				}
			}
			$ret = '/modules/' . basename(dirname(dirname(__FILE__))) . '/admin/feed.php';
			redirect_header(ICMS_URL . $ret, 2, _AM_READER_FEED_WEIGHTS_UPDATED);
			break;

		default:
			icms_cp_header();
			$icmsModule->displayAdminMenu(0, _AM_READER_FEEDS);
			$objectTable = new icms_ipf_view_Table($reader_feed_handler);
			$objectTable->addColumn(new icms_ipf_view_Column("online_status"));
			$objectTable->addColumn(new icms_ipf_view_Column("title"));
			$objectTable->addColumn(new icms_ipf_view_Column("description"));
			$objectTable->addColumn(new icms_ipf_view_Column("item_limit"));
			$objectTable->addColumn(new icms_ipf_view_Column('weight', 'center', true,
			'getWeightControl'));
			$objectTable->addIntroButton("addfeed", "feed.php?op=mod", _AM_READER_FEED_CREATE);
			$objectTable->addActionButton('changeWeight', false, _SUBMIT);
			$icmsAdminTpl->assign("reader_feed_table", $objectTable->fetch());
			$icmsAdminTpl->display("db:reader_admin_feed.html");
			break;
	}
	icms_cp_footer();
}
/**
 * If you want to have a specific action taken because the user input was invalid,
 * place it at this point. Otherwise, a blank page will be displayed
 */