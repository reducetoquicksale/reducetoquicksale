<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class actionLink {
		var $action_id, $linkPrefix, $queryString, $attributes, $preFix, $postFix;
		function __construct($action_id, $linkText, $linkPreFix, $queryString = "", $attributes = null, $preFix = "", $postFix = ""){
			$this->action_id	= $action_id;
			$this->linkText		= $linkText;
			$this->linkPreFix	= $linkPreFix;
			$this->queryString	= $queryString;
			$this->attributes	= $attributes;
			$this->preFix		= $preFix;
			$this->postFix		= $postFix;
		}

		function getLink() {
			if(validateAction($this->action_id)) {
				$link = $this->linkPreFix;
				$link .= "/".getActionUrl();
				if($this->queryString != "") { $link .= "?".$this->queryString; }

				$anchor = $this->preFix;

				$anchor .= '<a href="'.$link.'" ';
				if(is_array($this->attributes)) {
					foreach($this->attributes as $key=>$value) { 
						$anchor .= $key.'="'.$value.'" '; 
					}
				}
				$anchor .= '>'.$this->linkText.'</a>';

				$anchor .= $this->postFix;
				return $anchor;
			}
		}
	}
	
	function getLoggedUser() {
		$CI = &get_instance();
		$CI->load->library("session");
		$user = unserialize($CI->session->userdata(ProjectENUM::USER_SESSION_NAME));
		//print_r($user);
		//exit();
		if($user == null){
			$user = new stdClass();
			$user->is_super = 0;
			$user->role_id = UserType::ANNONYMOUS;
			$user->ref_type = UserRole::ANNONYMOUS;
		}
		return $user;
	}

	/*function validateUserLogin($redirect = null) {
		$oUser = getLoggedUser();
		if($oUser == null) { 
			if($redirect != TRUE) { 
				redirect($redirect, "refresh"); 
			} else {
				return FALSE;
			}
		}
	}*/

	function validateUserAccess($obj, $show_access_denied = false){
		
		$oUser = getLoggedUser();
		
		if($oUser->is_super == 1) {
			$flag = TRUE;
			return $flag;
		}

		$action_id = UserAction::NONE;

		if(!file_exists(DOCUMENT_ROOT."roles/actions.php")) { createActionFile(); }
		include_once(DOCUMENT_ROOT."roles/actions.php");

		global $ACTION;
		$obj->router->class  = strtolower($obj->router->class);
		$obj->router->method = strtolower($obj->router->method);

		if(isset($ACTION[$obj->router->class][$obj->router->method])) { 
			$action_id = $ACTION[$obj->router->class][$obj->router->method];
			$flag = validateAction($action_id);
			if($flag == false && $show_access_denied) {
				show_error("Access Denied.");
			} else {
				return $flag;
			}
		}
	}

	function validateAction($action_id) {
		$flag = FALSE;
		$oUser = getLoggedUser();
		
		if($oUser->is_super == 1) {
			$flag = TRUE;
			return $flag;
		}

		if(!file_exists(DOCUMENT_ROOT."roles/role_".$oUser->role_id.".php")) { createRoleFiles(); }
		include_once(DOCUMENT_ROOT."roles/role_".$oUser->role_id.".php");

		global $ROLE_ACTION;
		foreach ($ROLE_ACTION as $role) { if(in_array($action_id, $role)) { $flag = TRUE; } }
		return $flag;
	}

	function getActionUrl($action_id) {
		if(validateAction($action_id)) {
			include_once(DOCUMENT_ROOT."roles/actions.php");
			global $ACTION;
			foreach ($ACTION as $controller=>$action) {
				foreach ($action as $method=>$value) { 
					if($value == $action_id) { return  $controller ."/". $method; }
				}
			}
		}
	}

	function createRoleFiles($role_id = 0) {
		$CI = & get_instance();
		$CI->load->model('m_role');

		$arrRoles = array();
		if($role_id == 0) {
			$arrRoles = $CI->m_role->getRoles();
		} else {
			$arrRoles[]["role_id"] = $role_id;
		}

		$arrActions = $CI->m_role->getActions();
		if(count($arrRoles) > 0) {
			foreach($arrRoles as $role) {
				$CI->m_role->role_id = $role["role_id"];
				$roleActions = $CI->m_role->getRoleActions();			 
				$file_content = array();
				$file_content[] = "<?php \n global ".'$ROLE_ACTION;'." \n".'$ROLE_ACTION'." = array(); \n";
				if(count($arrActions) > 0) {					
					foreach($arrActions as $action) {
						$action["controller"] = strtolower($action["controller"]);
						$action["function"] = strtolower($action["function"]);
						if(isset($roleActions[$action["action_id"]])) {
							$file_content[] = '$ROLE_ACTION["'.$action["controller"].'"]["'.$action["function"].'"] = '.$action["action_id"].';'."\n";
						}
					}					
				}

				$file_content[] = "?>";
				$file = implode(" ", $file_content);

				$file_path = DOCUMENT_ROOT."roles"; 
				if(!is_dir($file_path)) { mkdir($file_path,0755,TRUE); }
				file_put_contents($file_path."/role_".$role["role_id"].".php", $file_content);
			}
		}
	}

	function createActionFile() {
		$CI = & get_instance();
		$CI->load->model('m_role');
		$arrActions = $CI->m_role->getActions();
		$file_content = array();
		$file_content[] = "<?php \n global ".'$ACTION;'." \n";
		if(count($arrActions) > 0) {			
			foreach($arrActions as $action) {
				$file_content[] = '$ACTION["'.$action["controller"].'"]["'.$action["function"].'"] = '.$action["action_id"].';'."\n";
			}					
		}

		$file_content[] = "?>";
		$file = implode(" ", $file_content);

		$file_path = DOCUMENT_ROOT."roles"; 
		if(!is_dir($file_path)) { mkdir($file_path,0755,TRUE); }
		file_put_contents($file_path."/actions.php", $file_content);
			
	}