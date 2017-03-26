<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Init extends MY_Controller {

	public function Init() {
		parent::__construct();
		$this->InitFrontend();
		$this->load->model('m_user');
	}

	public function homepage(){
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */