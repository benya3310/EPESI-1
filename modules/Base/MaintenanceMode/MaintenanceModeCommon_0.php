<?php
/**
 * MaintenanceMode class.
 * 
 * This class provides admin interface with maintenance mode toggle.
 * 
 * @author Paul Bukowski <pbukowski@telaxus.com>
 * @copyright Copyright &copy; 2006, Telaxus LLC
 * @version 0.9
 * @package tcms-base-extra
 */
defined("_VALID_ACCESS") || die('Direct access forbidden');

/**
 * This class provides admin interface with maintenance mode toggle.
 * @package tcms-base-extra
 * @subpackage maintenance-mode
 */
class Base_MaintenanceModeCommon {
	public static function set_mode($x) {
		if(is_bool($x))
			$_SESSION['maintenance_mode']=$x;
	}
	
	public static function get_mode() {
		return $_SESSION['maintenance_mode'];
	}
}
?>
