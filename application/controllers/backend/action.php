<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Action extends MY_Controller {

	public function Action() {	
		parent::InitBackendSite();
		$this->load->model("m_action");
		$this->load->library("grid");
	}

	public function add() {
		$object = new DBAction();	

		if($_POST != null) {
			$objUser->user_name		= $_POST["user_name"];
			$objUser->password		= $_POST["password"];
			$return_url				= $_POST["return_url"];

			$this->form_validation->set_rules('user_name', 'Login Id', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			
			if($this->form_validation->run() == true) { 
				$objUser = $this->m_user->authenticate($objUser);
				if($objUser != null) {	
					$this->session->set_userdata(ProjectENUM::USER_SESSION_NAME, serialize($objUser));					
					if($return_url != "")
						redirect($return_url);
					else
						redirect(URL::BACKEND . "/dashboard");
				} else {
					set_message($this->m_user->error_message, MessageType::ERROR);
				}
			}
		}
		
		$field_user_name			 = new form_field;
		$field_user_name->type		 = FieldType::TEXT;
		$field_user_name->name		 = "action_name";
		$field_user_name->value		 = $object->action_name;
		$field_user_name->attributes = array("id" => "action_name", "class" => "form-control", "placeholder" => "Action Name");
		
		$field_password				 = new form_field;
		$field_password->type		 = FieldType::PASSWORD;
		$field_password->name		 = "password";
		$field_password->value		 = "";
		$field_password->attributes  = array("id" => "password", "class" => "form-control", "placeholder" => "Password");

		$field_return_url			 = new form_field;
		$field_return_url->type		 = FieldType::HIDDEN;
		$field_return_url->name		 = "return_url";
		//$field_return_url->value	 = $return_url;

		$data["arrField"]			 = array("field_user_name" => $field_user_name, "field_password" => $field_password, "field_return_url" => $field_return_url);
		$data['title']				 = 'Add Action';

		$this->template->load('login', $data);
	}

	public function pagedList() {

		$this->grid->addColumn(new gridColumn("Action Name", "action_name"));
		$this->grid->addColumn(new gridColumn("Controller", "controller"));
		$this->grid->addColumn(new gridColumn("Method", "function"));
		$this->grid->setData($this->m_action->pagedList());
		$this->grid->setID_field("action_id");

		$data['title']	= 'Actions';
		$this->template->load("action/pagedList", $data);
	}
}