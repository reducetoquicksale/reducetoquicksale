<?php 

	/**************** Database Tables ENUMS******************************/

	abstract class DB_Table {
		const ACTION = "action";
		const ROLE = "role";
		const ROLE_ACTION = "role_action_mapping";
		const BUSINESS = "business";
		const USER = "user";
		const ADDRESS = "address";
	}

	class DBAction {
		var $action_id, $action_name, $controller, $function, $module;
		public function __construct($action_id = 0, $action_name = "", $controller = "", $function = "", $module = MODULE::BACKEND) {
			$this->action_id = $action_id;
			$this->action_name = $action_name;
			$this->controller = $controller;
			$this->function = $function;
			$this->module = $module;
		}
	}

	class DBUser {
		var $id, $user_name, $email, $password, $ref_type, $role_id, $last_login_timestamp, $status, $is_super;
		public function __construct() {
			$this->id = 0;
			$this->user_name = "";
			$this->email = "";
			$this->password = "";
			$this->ref_type = UserType::ANNONYMOUS;
			$this->role_id = UserRole::ANNONYMOUS;
			$this->last_login_timestamp = "";
			$this->status = 1;
			$this->is_super = 0;
		}
	}

?>