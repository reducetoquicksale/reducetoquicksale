<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function InitBackend() { 
		self::__construct();
		$this->template->load_config('template-backend');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */