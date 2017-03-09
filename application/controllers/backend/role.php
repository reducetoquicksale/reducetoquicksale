<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role extends MY_Controller {

	public function Role() {
		parent::InitBackendSite();
		validateUserLogin(URL::BACKEND . "/login");	
		
		$this->load->library('form');
		
		$this->form->config(array(
			'template_path' => 'backend/form_template'
		));
	}

	public function add() {
		validateUserAccess($this, true);
		
		$field = new stdClass();
		$field->type = Form::TEXT;
		$field->name = "role_name";
		$field->label = "Role Name";
		$field->validation = "required";
		$this->form->addElement($field);
		
		$field = new stdClass();
		$field->type = Form::SUBMIT;
		$field->name = "save";
		$field->label = "Add Role";
		$this->form->addElement($field);
		
		
		if(isset($_POST['save'])){
			if($this->form->validateForm()){
				echo 'done';
				exit();
			}
		}
		
		$data['title'] = 'Add Role';
		$data['module'] = 'user_role';
		$this->template->load('role/add_role', $data);
	}

	public function manage() {
		validateUserAccess($this, true);
		$this->load->model("m_user");
		$this->load->library("grid");
		
		$this->grid->addColumn(new gridColumn("Action Name", "action_name"));
		$this->grid->addColumn(new gridColumn("Controller", "controller"));
		$this->grid->addColumn(new gridColumn("Method", "function"));
		$this->grid->setData($this->m_user->pagedList());
		$this->grid->setID_field("action_id");

		$data['title'] = 'Manage Roles';
		$data['module'] = 'user';
		$this->template->load("action/pagedList", $data);
	}

	public function view() {
		validateUserAccess($this, true);
		
		$data['title'] = 'Role Detail';
		$data['module'] = 'user';
		$this->template->load('user/view_user', $data);
	}
}