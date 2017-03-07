<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function Dashboard() {	
		parent::InitBackendSite();
	}

	public function index() {
		//validateUserAccess($this, true);
		//$this->template->load('dashboard', null);
		
		$data['title'] = 'Dashboard';
		$this->template->load('', $data);
	}
}