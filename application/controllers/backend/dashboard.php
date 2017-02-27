<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function Dashboard() {
		parent::InitBackend();
		validateUserLogin(URL::BACKEND . "/login");	
	}

	public function index() {
		validateUserAccess($this, true);
	}
}