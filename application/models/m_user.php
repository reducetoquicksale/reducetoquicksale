<?php
class M_User extends M_Core
{
	function M_User() {
		parent::__construct(); 
	}

	function authenticate(user $objUser)	{
		$objUser->password = sha1($objUser->password);
		$sql = "SELECT ".DB_Table::USER.".* FROM ".DB_Table::USER." WHERE user_name = '".$objUser->user_name."' and password = '$objUser->password'";
		if($this->get_single_row($sql)) {
			$objUser = arrayToClassObj($objUser, $this->result);
            $this->update(DB_Table::USER, array("last_login_timestamp" => "time()"), array("id" => $objUser->id));
			$objUser->password = "";
            return $objUser;
		} else {
			$this->error_code = 123;
			$this->error_message = "Login ID or Password Incorrect";
			return null;
		}
	}
	
	function pagedList() {
		$this->use_pagination = TRUE;
		$this->data_only = FALSE;
		if($this->getAll(DB_Table::USER)) {
			$arrAction = array();
			foreach($this->result as $row) {
				$arrAction[] = $row;
				//$arrAction[] = arrayToClassObj(new DBAction(), $row);
			}
			return $arrAction;
		} else {

		}
	}
}