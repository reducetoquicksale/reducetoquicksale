<?php
class M_User extends M_Core
{
	var $id, $user_name, $password;
	function M_User() {
		parent::__construct(); 

		$this->id = 0;
		$this->user_name = "";
		$this->password = "";
	}

	function authenticate()	{
		//$this->CI->load->library('encryption');//print_r($this->CI);die;
		//$this->password = $this->CI->encrypt->sha1($this->password);
		
		$this->password = sha1($this->password);
		$sql = "SELECT ".DB_Table::USER.".* FROM ".DB_Table::USER." WHERE user_name = '".$this->user_name."' and password = '$this->password'";
		if($this->get_single_row($sql)) {
            $this->update(DB_Table::USER, array("last_login_timestamp" => "time()"), array("id" => $this->result->id));
            return $this->result;
		} else {
			$this->error_code = 123;
			$this->error_message = "Login ID or Password Incorrect";
			return null;
		}
	}
}