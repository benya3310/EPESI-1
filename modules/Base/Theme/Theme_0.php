<?php
/**
 * Theme class.
 * 
 * Provides module templating.
 * 
 * @author Paul Bukowski <pbukowski@telaxus.com>
 * @copyright Copyright &copy; 2006, Telaxus LLC
 * @version 0.9
 * @package tcms-base-extra
 */
defined("_VALID_ACCESS") || die('Direct access forbidden');

/**
 * load Smarty library
 */
 define(SMARTY_DIR, 'modules/Base/Theme/smarty/');
 
require_once(SMARTY_DIR.'Smarty.class.php');

/**
 * Provides module templating.
 * @package tcms-base-extra
 * @subpackage theme
 */
class Base_Theme extends Module {
	private static $theme;
	private static $themes_dir = 'data/Base/Theme/templates/';
	private $smarty = null;
	private $lang;
	
	public function construct() {
		$this->smarty = new Smarty();
		
		if(!isset(self::$theme)) {
			self::$theme = Variable::get('default_theme');
			if(!is_dir(self::$themes_dir.self::$theme))
				self::$theme = 'default';
		}
				
		$this->smarty->template_dir = self::$themes_dir.self::$theme;
		$this->smarty->compile_dir = 'data/Base/Theme/compiled/';
		$this->smarty->compile_id = self::$theme;
		$this->smarty->config_dir = 'data/Base/Theme/config/';
		$this->smarty->cache_dir = 'data/Base/Theme/cache/';
	}
	
	public function body() {
	}

	public function toHtml($user_template) { // TODO: There have to be something more useful than ob_start()...
		ob_start();
		$this->display($user_template);
		$ret = ob_get_contents();
		ob_end_clean();
		return $ret;		
	}

	public function display($user_template) {
		$module_name = $this->parent->get_type();
		if(isset($user_template)) 
			$module_name .= '__'.$user_template;
		else
			$module_name .= '__default';
		
		$tpl = $module_name.'.tpl';
		
		if($this->smarty->template_exists($tpl)) {
			$this->smarty->assign('theme_dir',$this->smarty->template_dir);
			$this->smarty->display($tpl);
			$css = $this->smarty->template_dir.'/'.$module_name.'.css';
			if(file_exists($css))
		    		load_css($css);
			
			//trigger_error($this->smarty->template_dir.$templ_name, E_USER_ERROR);
		} else {
			$this->smarty->template_dir = self::$themes_dir.'default';
			$this->smarty->compile_id = 'default';
			
			if(!$this->smarty->template_exists($tpl)) {
				trigger_error('Template not found: '.$tpl,E_USER_ERROR);
			}

			$this->smarty->assign('theme_dir',$this->smarty->template_dir);
			$this->smarty->display($tpl);
			$css = $this->smarty->template_dir.'/'.$module_name.'.css';
			if(file_exists($css))
				load_css($css);
			
			$this->smarty->template_dir = self::$themes_dir.self::$theme;
			$this->smarty->compile_id = self::$theme;
		}
	}
	
	public function & get_smarty() {
		return $this->smarty;
	}
	
	public function parse_links($key, $val, $flat=true) {
		if ($flat && !is_array($val)) if (preg_match('/(<[Aa][^>]*>)(.*)<\/[Aa]>/',$val,$match)) {
			$this->smarty->assign($key.'__open', $match[1]);
			$this->smarty->assign($key.'__close', '</a>');
			return $val;
		}
		foreach ($val as $k=>$v) {
			if (!is_array($v)) {
				if (preg_match('/(<[Aa][^>]*>)(.*)(<\/[Aa]>)/',$v,$match)){
					$val[$k.'__open'] = $match[1];
					$val[$k.'__close'] = '</a>';
				}
			} else
				$val[$k] = $this->parse_links($k, $v, false);
		}
		return $val;
	}
	
	public function assign($name, $val) {
//		$val = $this->parse_links($name, $val);
		return $this->smarty->assign($name, $val);
	}
	
	public static function list_themes() {
		$themes = array();
		$inc = dir(self::$themes_dir);
		while (false != ($entry = $inc->read())) {
			if (is_dir(self::$themes_dir.$entry) && $entry!='.' && $entry!='..')
				$themes[$entry] = $entry;
		}
		asort($themes);
		return $themes;		
	}
}
?>
