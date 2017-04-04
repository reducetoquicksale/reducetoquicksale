<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Init extends MY_Controller {

	public function Init() {
		$this->InitFrontend();
		$this->load->model('m_user');
	}

	public function homepage(){
		$a = array(
				'template/html_head',
				'common/homepage_banner',
				'template/main_content_area',
				'[main]',
				'template/html_foot'
		);
		$this->template->set_structure($a);
		$this->template->set_title('Dashboard');
		$this->template->load('homepage');
	}
	
	public function login() {
		$this->load->library('form');
		
		$field = new FormField(dbUser::EMAIL, "Email");
		$field->attributes = array(
				"placeholder" => "Your Email",
				"class" => "form-control"
		);
		$field->validation = array("required", array('authenticate', array($this->m_user, 'authentication')));
		$this->form_validation->set_message('authenticate', 'Username of Password not correct');
		$this->form->addFormField($field);
		
		$field = new FormField(dbUser::PASSWORD, "Password", Form::PASSWORD);
		$field->attributes = array(
				"placeholder" => "Your Password",
				"class" => "form-control"
		);
		$field->validation = "required";
		$this->form->addFormField($field);
		
		$field = new FormField('remember', "Remember Me", Form::CHECKBOX);
		$field->id = "minimal-checkbox-1";
		$field->value = 1;
		$this->form->addFormField($field);
		
		$field = new FormField();
		$field->type = Form::HIDDEN;
		$field->name = "return_url";
		$this->form->addFormField($field);
		
		if($_POST != NULL) {
			if($this->form->validateForm()){
				redirect(base_url());
			}
		}
		
		$data['page_heading'] = "Login";
		//$this->form->config(array('template_path'=>'backend/form_template'));
		$this->template->set_title('Login');
		$this->template->load('login', $data);
	}
	
	public function register() {
		$this->load->library('form');
		
		$field = new FormField(dbUser::EMAIL, "Email");
		$field->attributes = array(
				"placeholder" => "Your Email",
				"class" => "form-control"
		);
		$field->validation = array("required", array('authenticate', array($this->m_user, 'authentication')));
		$this->form_validation->set_message('authenticate', 'Username of Password not correct');
		$this->form->addFormField($field);
		
		$field = new FormField(dbUser::PASSWORD, "Password", Form::PASSWORD);
		$field->attributes = array(
				"placeholder" => "Your Password",
				"class" => "form-control"
		);
		$field->validation = "required";
		$this->form->addFormField($field);
		
		$field = new FormField('remember', "Remember Me", Form::CHECKBOX);
		$field->id = "minimal-checkbox-1";
		$field->value = 1;
		$this->form->addFormField($field);
		
		$field = new FormField();
		$field->type = Form::HIDDEN;
		$field->name = "return_url";
		$this->form->addFormField($field);
		
		if($_POST != NULL) {
			if($this->form->validateForm()){
				redirect(base_url());
			}
		}
		
		$data['page_heading'] = "Register";
		//$this->form->config(array('template_path'=>'backend/form_template'));
		$this->template->set_title('Register');
		$this->template->load('register', $data);
	}
	
	public function logout() {
		$this->session->set_userdata(ProjectENUM::USER_SESSION_NAME, "");
		redirect(base_url());
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */