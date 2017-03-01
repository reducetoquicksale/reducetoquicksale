<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function Dashboard() {
		parent::InitBackendSite();
		validateUserLogin(URL::BACKEND . "/login");	
	}

	public function index() {
		validateUserAccess($this, true);
		
		$data['title'] = 'Dashboard';
		$this->template->load('', $data);
	}
}