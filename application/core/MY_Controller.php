<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if(strtolower($this->uri->segment(1)) == URL::BACKEND) {
			$this->template->load_config('template-backend');
		} else {
			$this->template->load_config('template');
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */