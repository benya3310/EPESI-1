<?php
/**
 * Utils_ImageInstall class.
 * 
 * @author Kuba Slawinski <kslawinski@telaxus.com>
 * @copyright Copyright &copy; 2006, Telaxus LLC
 * @version 0.9
 * @package tcms-utils
 */
defined("_VALID_ACCESS") || die('Direct access forbidden');

class Utils_ImageInstall extends ModuleInstall {
	public static function install() {
		return true;
	}
	
	public static function uninstall() {
		return true;
	}
}

?>
