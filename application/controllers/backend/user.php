<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller {

	public function User() {
		parent::InitBackendSite();
		validateUserLogin(URL::BACKEND . "/login");	
	}

	public function index() {
		validateUserAccess($this, true);
		
		$data['title'] = 'Dashboard';
		$this->template->load('', $data);
	}

	public function add() {
		validateUserAccess($this, true);
		
		/*
		$this->load->library('form');
		
		$this->form->config(array(
			'template_path' => 'backend/form_template/form1'
		));
		
		$field = new Form;
		$field->type = Form::TEXT;
		$field->name = "user_name";
		$field->value = "admin";
		$field->label = "Name";
		$this->form->addElement($field);
		
		$field->type = Form::TEXT;
		$field->name = "user_name2";
		$field->value = "admin";
		$field->label = "Name";
		$this->form->addElement($field);
		
		echo $this->form->renderElement("user_name1");
		echo $this->form->renderElement("user_name2");
		
		exit();
		*/
		$user_name = "";
		$password = "";	
		$email = "";
		
		$field_user_name = new form_field;
		$field_user_name->type = FieldType::TEXT;
		$field_user_name->name = "user_name";
		$field_user_name->value = $user_name;
		$field_user_name->attributes = array("id" => "field_user_name", "class" => "form-control", "placeholder" => "User Name");
		
		$field_user_name = new form_field;
		$field_user_name->type = FieldType::TEXT;
		$field_user_name->name = "user_name";
		$field_user_name->value = $user_name;
		$field_user_name->attributes = array("id" => "field_user_name", "class" => "form-control", "placeholder" => "User ID");
		
		$field_password = new form_field;
		$field_password->type = FieldType::PASSWORD;
		$field_password->name = "password";
		$field_password->value = "";
		$field_password->attributes = array("id" => "password", "class" => "form-control", "placeholder" => "Password");
		
		$field_user_email = new form_field;
		$field_user_email->type = FieldType::TEXT;
		$field_user_email->name = "email";
		$field_user_email->value = $email;
		$field_user_email->attributes = array("id" => "email", "class" => "form-control", "placeholder" => "Email");
		
		$data["arrField"] = array("field_user_name" => $field_user_name, "field_password" => $field_password);
		
		$data['title'] = 'Add User';
		$data['module'] = 'user';
		$this->template->load('user/add_user', $data);
	}

	public function manage() {
		validateUserAccess($this, true);
		
		$data['title'] = 'Manage Users';
		$data['module'] = 'user';
		$this->template->load('user/manage_user', $data);
	}

	public function view() {
		validateUserAccess($this, true);
		
		$data['title'] = 'User Detail';
		$data['module'] = 'user';
		$this->template->load('user/view_user', $data);
	}
}