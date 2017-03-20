<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Init extends MY_Controller {

	public function Init() {		
		parent::InitBackendLogin();
		$this->load->model('m_user');
	}
	
	public function login() {
		$this->load->library('form');
		$objUser = new DBUser();
		$objUser->user_name = "";
		$objUser->password = "";	

		if($_POST != null) {
			$objUser->user_name		= $_POST["user_name"];
			$objUser->password		= $_POST["password"];
			$return_url				= $_POST["return_url"];

			//$this->form_validation->set_rules('user_name', 'Login Id', 'required');
			//$this->form_validation->set_rules('password', 'Password', 'required');
			
			if($this->form->validateForm()) { 
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
		
		//$this->form->config(array('template_path'=>'backend/form_template'));
		
		$field = new stdClass();
		$field->type = Form::TEXT;
		$field->name = "user_name";
		$field->attributes = array(
							"placeholder" => "User ID",
							"class" => "form-control"
						);
		$field->validation = "required";
		$this->form->addFormField($field);
		
		$field = new stdClass();
		$field->type = Form::PASSWORD;
		$field->name = "password";
		$field->attributes = array(
							"placeholder" => "Password",
							"class" => "form-control"
						);
		$field->validation = "required";
		$this->form->addFormField($field);
		
		$field = new stdClass();
		$field->type = Form::HIDDEN;
		$field->name = "return_url";
		$this->form->addFormField($field);

		//$data["arrField"]			 = array("user_name" => $field_user_name, "password" => $field_password, "return_url" => $field_return_url);
		$data['title']				 = 'Login';
		
		$this->template->add_script(array(base_url("assets/backend/js/jquery.backstretch.min.js")));
		$this->template->load('login', $data, 'blank');
	}

	public function logout() {
		$this->session->set_userdata(ProjectENUM::USER_SESSION_NAME, "");
		redirect(URL::BACKEND . '/init/login');
	}

	public function help() {
		$data["title"] = "Help";
		$this->template->load('help', $data, TPLFile::BLANK);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */