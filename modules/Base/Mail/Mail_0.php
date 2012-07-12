<?php
/**
 * Mail class.
 * 
 * This class provides mail sending functionality.
 * 
 * @author Paul Bukowski <pbukowski@telaxus.com>
 * @copyright Copyright &copy; 2008, Telaxus LLC
 * @license MIT
 * @version 1.0
 * @package epesi-base
 * @subpackage mail
 */
defined("_VALID_ACCESS") || die('Direct access forbidden');

class Base_Mail extends Module implements Base_AdminInterface {

	public function body() {
	}

	/**
	 * For internal use only.
	 */
	public function admin() {
		if($this->is_back()) {
			$this->parent->reset();
			return;
		}
		
		$form = & $this->init_module('Libs/QuickForm');
		//defaults
		$defaults = array();
		$defaults['mail_method'] = Variable::get('mail_method');
		$defaults['mail_user'] = Variable::get('mail_user');
		$defaults['mail_from_addr'] = Variable::get('mail_from_addr');
		$defaults['mail_from_name'] = Variable::get('mail_from_name');
		$defaults['mail_host'] = Variable::get('mail_host');
		$defaults['mail_auth'] = Variable::get('mail_auth');
		$defaults['mail_password'] = Variable::get('mail_password');
				
		$form->setDefaults($defaults);
	
		//form
		$form->addElement('header',null, __('Mail settings'));
		$form->addElement('select','mail_method', __('Choose method'), array('smtp'=>__('remote smtp server'), 'mail'=>__('local php.ini settings')), 'onChange="'.$form->get_submit_form_js(false).'"');
		
		$form->addElement('text','mail_from_addr', __('Administrator e-mail address'));
		$form->addRule('mail_from_addr', __('Invalid e-mail address'), 'email');
		$form->addRule('mail_from_addr', __('Field required'), 'required');	
		
		$form->addElement('text','mail_from_name', __('Send e-mails from name'));
	
		$method = $form->getElement('mail_method')->getSelected();
		if($method[0]=='smtp') {
			
			$form->addElement('text','mail_host', __('SMTP host address'));
			$form->addRule('mail_host', __('Field required'),'required');
			
			$form->addElement('checkbox','mail_auth', __('SMTP authorization'),'','onChange="'.$form->get_submit_form_js(false).'"');
			
			$auth = $form->getElement('mail_auth')->getValue();
			if($auth) {
				$form->addElement('text','mail_user', __('Login'));					
				$form->addElement('password','mail_password', __('Password'));
			}
		}
		
		Base_ActionBarCommon::add('back', __('Back'), $this->create_back_href());
		Base_ActionBarCommon::add('save', __('Save'), $form->get_submit_form_href());
		
		if($form->getSubmitValue('submited') && $form->validate() && $form->process(array(&$this,'submit_admin'))) {
			$this->parent->reset();
		} else {
			$form->display();					
		}
		
	}
	
	/**
	 * For internal use only.
	 */
	public function submit_admin($data) {
		$method = $data['mail_method'];
		Variable::set('mail_method', $method);
		Variable::set('mail_from_addr', $data['mail_from_addr']);
		Variable::set('mail_from_name', $data['mail_from_name']);
		if($method=='smtp') {
			Variable::set('mail_host', $data['mail_host']);
			
			$auth = isset($data['mail_auth']) && $data['mail_auth'];
			Variable::set('mail_auth', $auth);
			if($auth) {
				Variable::set('mail_user', $data['mail_user']);
				Variable::set('mail_password', $data['mail_password']);
			}
		}
		return true;
	}
}
?>
