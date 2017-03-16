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
		
		if(isset($_POST['save'])){
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
		$this->load->library('form');
		$this->load->library("datagrid");
		$this->load->model("m_user");
		
		$field = new stdClass();
		$field->type = Form::CHECKBOX;
		$field->name = "user_id";
		$field->value = array(1=>"");
		$field->attributes = array("class"=> "check_uncheck_all");
		
		$label1 = $this->form->renderField($field);
		
		$field = new stdClass();
		$field->type = Form::CHECKBOX;
		$field->name = "user_id[]";
		$field->value = 'id';
		$field->attributes = array("class"=> "check_field");
		
		$this->datagrid->addColumn($label1, $field, Datagrid::FORM_FIELD);
		$this->datagrid->addColumn("Status", function($row){
				if($row->status == 1)
					return '<span class="label label-success label-mini">Active</span>';
				else
					return '<span class="label label-warning label-mini">In-Active</span>';
			}, Datagrid::CALLBACK);
		$this->datagrid->addColumn("User Name", function($row){
				return '<a href="'.base_url().'"><span id="name'.$row->id.'">'.$row->user_name.'</span></a>';
			}, Datagrid::CALLBACK);
		$this->datagrid->addColumn("Email", "email");
		$this->datagrid->addColumn("Actions", function($row){
					$html = "";
					if($row->status == 0)
						$html .= ' <a class="btn btn-success btn-xs" href="'.base_url('backend/user/status/'.$row->id).'" title="Set Active"><i class="fa fa-check"></i></a>';
					else
	                    $html .= ' <a class="btn btn-danger btn-xs" href="#" title="Set Inactive"><i class="fa fa-ban"></i></a>';
                    $html .= ' <a class="btn btn-success btn-xs" href="'.base_url('backend/user/edit/'.$row->id).'" title="Edit"><i class="fa fa-pencil "></i></a>';
                    $html .= ' <button class="btn btn-danger btn-xs" title="Delete" data-toggle="modal" data-target="#deleteModal" id="'.$row->id.'"><i class="fa fa-trash-o "></i></button>';
					return $html;
			}, Datagrid::CALLBACK);
		
		//$user_data = $this->m_user->pagedList();
		$this->datagrid->setData('m_user', 'pagedList');

		$data['title'] = 'Manage Users';
		$data['module'] = 'user';
		$this->template->load("user/manage_user", $data);
	}
	
	public function edit($user_id) {
		
		$this->load->library('form');
		$this->form->config(array('template_path'=>'backend/form_template'));
		
		$field = new stdClass();
		$field->type = Form::TEXT;
		$field->name = "user_name";
		$field->label = "User Name";
		$field->validation = "required";
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
		
		if(isset($_POST['save'])){
			if($this->form->validateForm()){
				echo 'done';
				exit();
			}
		}
		
		$main_data['form'] = $this->form->renderForm();
		$main_data['title'] = 'Edit User';
		$main_data['module'] = 'user';
		$this->template->load('user/add_user', $main_data);
	}

	public function view() {
		validateUserAccess($this, true);
		
		$data['title'] = 'User Detail';
		$data['module'] = 'user';
		$this->template->load('user/view_user', $data);
	}
}