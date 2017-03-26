<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Init extends MY_Controller {

	public function Init() {		
		parent::InitBackendLogin();
		$this->load->model('m_user');
	}
	
	public function login() {
		$this->load->library('form');
		
		$field = new stdClass();
		$field->type = Form::TEXT;
		$field->name = dbUser::LOGIN_ID;
		$field->label = "User ID";
		$field->attributes = array(
							"placeholder" => "User ID",
							"class" => "form-control"
						);
		if($_POST != NULL && $_POST[dbUser::LOGIN_ID] != "" && $_POST[dbUser::PASSWORD] != "" ){
			$this->form_validation->set_rules(dbUser::LOGIN_ID, 'User ID', 
												array(
													'required',
													array('authenticate2', array($this->m_user, 'authentication'))
												)
											);
			$this->form_validation->set_message('authenticate2', 'Username of Password not correct');
		}
		else {
			$field->validation = "required";
		}
		$this->form->addFormField($field);
		
		$field = new stdClass();
		$field->type = Form::PASSWORD;
		$field->name = dbUser::PASSWORD;
		$field->label = "Password";
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

		if($_POST != NULL) {
			if($this->form->validateForm()){
				redirect(base_url(URL::BACKEND . "/dashboard"));
			}
		}
		
		//$this->form->config(array('template_path'=>'backend/form_template'));
		$this->template->set_title('Login');
		$this->template->load('login', '', 'blank');
	}

	public function dashboard() {
		$this->template->set_title('Dashboard');
		$this->template->load('');
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