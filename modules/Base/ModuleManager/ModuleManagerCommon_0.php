<?php
/**
 * 
 * @author Paul Bukowski <pbukowski@telaxus.com>
 * @copyright Copyright &copy; 2006, Telaxus LLC
 * @version 0.9
 * @package tcms-base-extra
 */
defined("_VALID_ACCESS") || die('Direct access forbidden');

/**
 * @package tcms-base-extra
 * @subpackage ModuleManager
 */
class Base_ModuleManagerCommon extends Base_AdminModuleCommon{
	public static function admin_caption() {
		return 'Manage modules';
	}
}
?>
