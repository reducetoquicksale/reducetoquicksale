<?php
class M_User extends M_Core
{
	var $id, $user_name, $password;
	function M_User() {
		$this->id = 0;
		$this->user_name = "";
		$this->password = "";
	}

	function authenticate()	{
		$this->load->library('encrypt');
		$this->password = $this->encrypt->sha1($this->password);
		$sql = "SELECT ".T_USER.".* FROM ".T_USER." WHERE user_name = ".$this->user_name." and password = '$this->password'";
		if($this->get_single_row($sql)) {
            $this->update(T_USER, array("last_login_time" => "time()"), array("id" => $this->result->id));
            return $this->result;
		} else {
			$this->message = "Login ID or Password Incorrect";
			return null;
		}
	}
}