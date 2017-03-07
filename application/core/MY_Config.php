<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Config extends CI_Config {

	public function __construct() {
		parent::__construct();
	}

	public function is_loaded($file) {
		$loaded = FALSE;
		foreach ($this->_config_paths as $path)	{
			foreach (array($file, ENVIRONMENT.DIRECTORY_SEPARATOR.$file) as $location) {
				$file_path = $path.'config/'.$location.'.php';
				if (in_array($file_path, $this->is_loaded, TRUE)) {
					$loaded = TRUE;
					break;
				}
			}
		}
		return $loaded;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */