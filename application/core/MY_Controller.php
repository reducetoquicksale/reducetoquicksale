<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public function __construct() {
		parent::__construct();	
		//$this->session->set_userdata(ProjectENUM::USER_SESSION_NAME, "");

		if(!validateUserAccess($this)) {
			$oUser = getLoggedUser();
			if($oUser->ref_type == UserType::ANNONYMOUS && base_url(uri_string()) != backendUrl("login")) {
				redirect(backendUrl("login"), "refresh");
			} elseif($oUser->ref_type != UserType::ANNONYMOUS && base_url(uri_string()) == backendUrl("login")) {
				redirect(backendUrl("dashboard"), "refresh");
			} else {
				show_error("Access Denied.");
			}
		}

		$this->return_url = return_url();
		$this->query_string = (object) explode("&", get_current_page_query_string());
		$this->previous_page_query_string = (object) explode("&", get_previous_page_query_string());

	}

	public function InitBackendLogin() { 
		self::__construct();
		$this->template->load_config('template-backend');
		$this->template->add_js(array(
				"assets/backend/js/jquery.backstretch.min.js"
		));
	}

	public function InitBackendSite() { 
		self::__construct();
		/*
		$this->template->load_config('template-backend');
		*/
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */