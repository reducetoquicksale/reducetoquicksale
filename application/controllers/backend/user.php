<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller {

	public function User() {
		parent::InitBackendSite();
	}
	
	public function add() {
		
		$this->load->library('form');
		$this->form->config(array('template_path'=>'backend/form_template'));
		
		$field = new stdClass();
		$field->type = Form::TEXT;
		$field->name = "user_name";
		$field->label = "User Name";
		$field->validation = "required";
		$field->value = "Test Value";
		$this->form->addFormField($field);
		
		$field = new stdClass();
		$field->type = Form::PASSWORD;
		$field->name = "password";
		$field->label = "Password";
		$field->validation = "required";
		$this->form->addFormField($field);
		
		$field = new stdClass();
		$field->type = Form::TEXT;
		$field->name = "email";
		$field->label = "Email";
		$field->validation = "required|valid_email";
		$this->form->addFormField($field);
		
		$field = new stdClass();
		$field->type = Form::RADIO;
		$field->name = "ref_type";
		$field->label = "Reference Type";
		$field->value = array(1=>"Admin", 2=>"User");
		$field->attributes = array('checked' => 1);
		$this->form->addFormField($field);
		
		$field = new stdClass();
		$field->type = Form::SUBMIT;
		$field->name = "save";
		$field->value = "Add User";
		$field->attributes = array(
								'class' => "btn-primary"
							);
		$this->form->addFormField($field);
		
		//$this->form->groupFormFields(array('save', 'reset'));
		
		//echo $this->form->renderFieldHtml('email');
		//echo $this->form->renderFieldHtml('password');
		//$this->form->renderForm();
		
		if(isset($_POST['save'])){
			//$this->form_validation->set_rules("user_name", "User Name", "required");
			//$this->form_validation->set_rules("password", "Password", "required");
			if($this->form->validateForm()){
				echo 'done';
				exit();
			}
		}
		
		$main_data['form'] = $this->form->renderForm();
		$main_data['title'] = 'Add User';
		$main_data['module'] = 'user';
		$this->template->load('user/add_user', $main_data);
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

		$data['title'] = 'Manage Users';
		$data['module'] = 'user';
		$this->template->load("action/pagedList", $data);
	}

	public function view() {
		validateUserAccess($this, true);
		
		$data['title'] = 'User Detail';
		$data['module'] = 'user';
		$this->template->load('user/view_user', $data);
	}
}