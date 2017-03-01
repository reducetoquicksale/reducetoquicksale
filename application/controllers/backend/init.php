<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Init extends MY_Controller {

	public function Init() {		
		parent::InitBackendLogin();
		$this->load->model('m_user');
	}
	
	public function login() {
		$this->load->library('user_agent');			
		$return_url = $this->agent->is_referral() ? $this->agent->referrer() : "";
		if($return_url == "" && isset($_GET["return_url"]) ) { $return_url = $_GET["return_url"]; }
		if(!preg_match("/^".str_replace("/","\/",base_url())."/", $return_url)) { $return_url = ""; }

		$user_name = "";
		$password = "";	

		if($_POST != null) {
			$user_name = $_POST["user_name"];
			$password = $_POST["password"];
			$return_url  = $_POST["return_url"];

			$this->form_validation->set_rules('user_name', 'Login Id', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			
			if($this->form_validation->run() == true){ 				
				$this->m_user->user_name = $user_name;
				echo $this->m_user->password = $password;
				$userDetail = $this->m_user->authenticate();
				if($userDetail != null) {	
					$this->session->set_userdata(ProjectENUM::USER_SESSION_NAME, serialize($userDetail));					
					if($return_url != "")
						redirect($return_url);
					else
						redirect(URL::BACKEND . "/dashboard");
				} else {
					set_message($this->m_user->error_message, MessageType::ERROR);
				}
			} 
			/*
			else {
				//set_message(validation_errors(), MessageType::ERROR);
			}
			*/
		}
		
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

		$field_return_url = new form_field;
		$field_return_url->type = FieldType::HIDDEN;
		$field_return_url->name = "return_url";
		$field_return_url->value = $return_url;

		$data["arrField"] = array("field_user_name" => $field_user_name, "field_password" => $field_password, "field_return_url" => $field_return_url);

		$data['title'] = 'Login';
		$this->template->add_js(array("assets/backend/js/jquery.backstretch.min.js"));
		$this->template->load('login', $data, TPLBackend::BLANK);
	}

	public function logout() {
		$this->session->set_userdata(ProjectENUM::USER_SESSION_NAME, "");
		redirect(URL::BACKEND . '/login');
	}

	public function help() {
		$data["title"] = "Help";
		$this->template->load('help', $data, TPLFile::BLANK);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */