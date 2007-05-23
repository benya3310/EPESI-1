<?php
/**
 * Backup class.
 * 
 * This class provides functions for administrating the backup files.
 * 
 * @author Paul Bukowski <pbukowski@telaxus.com>
 * @copyright Copyright &copy; 2006, Telaxus LLC
 * @version 0.9
 * @package tcms-base-extra
 */
defined("_VALID_ACCESS") || die('Direct access forbidden');

/**
 * This class provides functions for administrating the backup files.
 * @package tcms-base-extra
 * @subpackage backup
 */
class Base_BackupCommon {
	public static function admin_access() {
		return Base_AclCommon::i_am_sa();
	}
	

	public static function admin_caption() {
		return "Manage backups";
	}
}

?>