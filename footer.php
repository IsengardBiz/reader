<?php
/**
 * Footer page included at the end of each page on user side of the mdoule
 *
 * @copyright	Copyright Madfish (Simon Wilkinson) 2011
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @since		1.0
 * @author		Madfish (Simon Wilkinson) <simon@isengard.biz>
 * @package		reader
 * @version		$Id$
 */

defined("ICMS_ROOT_PATH") or die("ICMS root path not defined");

$icmsTpl->assign("reader_adminpage", "<a href='" . ICMS_URL . "/modules/" . icms::$module->getVar("dirname") . "/admin/index.php'>" ._MD_READER_ADMIN_PAGE . "</a>");
$icmsTpl->assign("reader_is_admin", icms_userIsAdmin(READER_DIRNAME));
$icmsTpl->assign('reader_url', READER_URL);
$icmsTpl->assign('reader_images_url', READER_IMAGES_URL);

$xoTheme->addStylesheet(READER_URL . 'module' . ((defined("_ADM_USE_RTL") && _ADM_USE_RTL) ? '_rtl' : '') . '.css');

include_once ICMS_ROOT_PATH . '/footer.php';