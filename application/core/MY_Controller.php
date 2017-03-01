<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public function __construct() {
		parent::__construct();
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
		$this->template->load_config('template-backend');
		$this->template->add_js(array(
				"assets/backend/js/jquery.dcjqaccordion.2.7.js",
				'assets/backend/js/jquery.scrollTo.min.js',
				'assets/backend/js/jquery.nicescroll.js',
				'assets/backend/js/jquery.sparkline.js',
				'assets/backend/js/common-scripts.js',
				'assets/backend/js/gritter/js/jquery.gritter.js',
				'assets/backend/js/gritter-conf.js',
				'assets/backend/js/sparkline-chart.js',
				'assets/backend/js/zabuto_calendar.js'
		));
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */