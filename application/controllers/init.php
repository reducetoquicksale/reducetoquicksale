<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Init extends MY_Controller {

	public function Init() {
		$this->InitFrontend();
		//$this->load->model('m_user');
	}

	public function homepage(){
		$a = array(
				'template/html_head',
				'template/main_content_area',
				'[main]',
				'template/html_foot'
		);
		//$this->template->set_structure($a);
		$this->template->set_title('Dashboard');
		$this->template->load('homepage');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */