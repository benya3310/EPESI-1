<?php
/** 
 * @author Kuba Slawinski <kslawinski@telaxus.com> 
 * @copyright Copyright &copy; 2006, Telaxus LLC 
 * @version 0.9 
 * @package tcms-utils 
 */
defined("_VALID_ACCESS") || die('Direct access forbidden');

class Utils_Tree extends Module {
	private static $_counter = 0;
	private $_id;
	private $menu_string;
	private $_sub = 0;
	private $_selected;
	private $_structure;
	
	public function construct() {
		$this->_id = Utils_Tree::$_counter;
		Utils_Tree::$_counter++;
		load_js("modules/Utils/Tree/js/tree.js");
	}
	
	function getDirsRecursive($p_dirpath, $pattern = '0') { 
		$r_ret = array("/"=>"/");
		$stack = array();
		array_push($stack, "");
		while(count($stack) > 0) {
			//print_r($stack); print "<br>";
			$curr = array_pop($stack);
			//print "curr: ".$p_dirpath.$curr."<br>";
			if( $handle = opendir($p_dirpath."/".$curr) ) { 
				while(false !== ($file = readdir($handle))) { 
					if($file != "." && $file != "..") { 
						if ( is_dir($p_dirpath."/".$curr."/".$file) ){
							if($pattern != '0') {
								if(preg_match($pattern, $file)) {
									//array_push($r_ret, $curr."/".$file."/"); 
									$r_ret[$file] = $curr."/".$file."/";
									array_push($stack, $curr."/".$file); 
								}
							} else  {
								//array_push($r_ret, $curr."/".$file."/"); 
								$r_ret[$file] = $curr."/".$file."/";
								array_push($stack, $curr."/".$file); 
							}
						} 
					} 
				} 
				closedir($handle);
			}
		}
		return $r_ret;
	}
	public function set_structure($s) {
		$this->_structure = $s;
	}
	
	private function sort_r( & $t ) {
		ksort( $t );
		foreach( $t as $k => $v ) {
			if(is_array($v['sub']))
				$ret .= $this->print_structure_r($v['sub'], $level + 1);
		}
	}
	
	public function sort( $arg ) {
		if(isset($dir))
			print $this->_structure = $dir;
		
		ksort($this->_structure);
		foreach( $t as $k => $v ) {
			if(is_array($v['sub']))
				$ret .= $this->print_structure_r($v['sub'], $level + 1);
		}
	}
	
	public function print_structure_r($t = array(), $level = 0) {
		if(count($t) > 0) {
			$ret = '<div class=utils_tree_submenu id=tree_'.$this->_id.'_'.$this->_sub.'>';
			$this->_sub++;
			foreach( $t as $k => $v ) {
				$ret .= '<table><tr>';
				if(count($v['sub']) > 0) {
					$ret .= '<td id=utils_tree_opener_'.$this->_id.'_'.($this->_sub).' class=utils_tree_opener_active_open onclick="tree_node_visibility_toggle(\''.$this->_id.'_'.($this->_sub).'\')"><img src=modules/Utils/Tree/theme/opener_active_open.gif></td>';
				} else {
					$ret .= '<td class=utils_tree_opener_inactive><img src=modules/Utils/Tree/theme/opener_inactive.gif></td>';
				}
				if($v['selected'] == 1) {
					$ret .= "<td class=utils_tree_node_selected>".$v['name']."</td></tr></table>";
				} else {
					$ret .= "<td class=utils_tree_node>".$v['name']."</td></tr></table>";
				}
				if(is_array($v['sub'])) {
					$ret .= $this->print_structure_r($v['sub'], $level + 1);
				}
			}
			$ret .= "</div>";
			return $ret;
		}
		return '';
	}
		
	public function print_structure($t = array(), $level = 0) {
		$ret = '<div class=utils_tree_root>';
		foreach( $t as $k => $v ) {
			$ret .= '<table class=utils_tree_node cellspacing=0><tr>';
			if(count($v['sub']) > 0) {
				$ret .= '<td id=utils_tree_opener_'.$this->_id.'_'.($this->_sub).' class=utils_tree_opener_active_open onclick="tree_node_visibility_toggle(\''.$this->_id.'_'.($this->_sub).'\')"><img src=modules/Utils/Tree/theme/opener_active_open.gif></td>';
			} else {
				$ret .= '<td class=utils_tree_opener_inactive><img src=modules/Utils/Tree/theme/opener_inactive.gif></td>';
			}
			if($v['selected'] == 1) {
				$ret .= "<td class=utils_tree_node_selected>".$v['name']."</td></tr></table>";
			} else {
				$ret .= "<td class=utils_tree_node>".$v['name']."</td></tr></table>";
			}
			if(is_array($v['sub'])) {
				$ret .= $this->print_structure_r($v['sub'], $level + 1);
			}
		}
		$ret .= "</div>";
		return $ret;
	}
	public function toHtml() {
		$s = $this->print_structure($this->_structure);
		$h = '<span class=utils_tree_expand_all id=tree_expand_all_'.$this->_id.' onclick="tree_toggle_expand_all('.$this->_id.','.$this->_sub.')">Collapse All</span> ';
		
		$theme = & $this->init_module('Base/Theme');
		$theme->assign('tree', $h.'<br><div align=left>'.$s.'</div>');
		
		return $theme->toHtml();
	}
	

	public function body( $dir ) {
		if(isset($dir))
			print $this->_structure = $dir;
		
		$h = '<span class=tree_expand_all id=tree_expand_all_'.$this->_id.' onclick="tree_toggle_expand_all('.$this->_id.','.$this->_sub.')">Collapse All</span> ';
		
		$theme = & $this->init_module('Base/Theme');
		$theme->assign('tree', $h.'<br><div align=left>'.$s.'</div>');
		
		$theme->display();
	}
}