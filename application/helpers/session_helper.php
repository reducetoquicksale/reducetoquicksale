<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	//global $calledController, $calledFunction;

	function getLoggedUser() {
		$CI = &get_instance();
		$CI->load->library("session");
		$user = unserialize($CI->session->userdata(ProjectENUM::USER_SESSION_NAME));
		return $user;
	}

	function validateUserLogin($redirect = TRUE) {
		$oUser = getLoggedUser();
		if($oUser == null) { 
			if($redirect == TRUE) { 
				redirect(base_url()."login", "refresh"); 
			} else {
				return FALSE;
			}
		}
	}

	function validateUserAccess($obj){
		$action_id = UserAction::NONE;
		if(!file_exists(DOCUMENT_ROOT."roles/actions.php")) { createActionFile(); }
		include_once(DOCUMENT_ROOT."roles/actions.php");
		global $ACTION;
		if(isset($ACTION[$obj->router->class][$obj->router->method])) { 
			$action_id = $ACTION[$obj->router->class][$obj->router->method];
			return validateAction($action_id);
		}
	}

	function validateAction($action_id) {
		$flag = FALSE;
		$oUser = getLoggedUser();
		$user_role_id = UserRole::ANNONYMOUS;
		if(!empty($oUser)) {
			if($oUser->is_super == 1) {
				$flag = TRUE;
				return $flag;
			} else {
				$user_role_id = $oUser->user_role_id;
			}
		}
		if(!file_exists(DOCUMENT_ROOT."roles/role_".$user_role_id.".php")) { createRoleFiles(); }
		include_once(DOCUMENT_ROOT."roles/role_".$user_role_id.".php");
		global $ROLE_ACTION;		
		foreach ($ROLE_ACTION as $role) { if(in_array($action_id, $role)) { $flag = TRUE; } }
		return $flag;
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