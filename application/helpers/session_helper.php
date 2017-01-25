<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	global $calledController, $calledFunction;
	function getLoggedUser() {
		$CI = &get_instance();
		$CI->load->library("session");
		$user = unserialize($CI->session->userdata(USER_SESSION_NAME));
		return $user;
	}

	function validateUserLogin() {
		$oUser = getLoggedUser();
		if($oUser == null){
			redirect(base_url()."login", "refresh");
		} else {
			if($oUser->is_super == 0 && getVariable("is_authenticated_enable", STATUS_DISABLE) == STATUS_ENABLE) {
				$CI = & get_instance();//print getVariable("is_authenticated_enable", STATUS_DISABLE);die;
				$CI->m_core->table = T_IP;
				$CI->m_core->data_only = TRUE;
				$CI->m_core->use_join = FALSE;
				if($CI->m_core->listing(NULL,array("user_ref_id"=>$oUser->user_id))) {
					$temp = $CI->m_core->class_data;
					if($temp["status"] == STATUS_ENABLE && $temp["ip"] != $_SERVER["REMOTE_ADDR"]) {
						set_message("Sorry! Your IP Address is not Autenticated", MESSAGE_TYPE_ERROR);
						redirect(base_url("logout"));
					}
				}
			}
		}
	}

	function validateUserAccess($controller, $function, $setGlobal = FALSE){
		$controller = strtolower($controller);
		$function = strtolower($function);
		//validateUserAccess(__CLASS__, __FUNCTION__, TRUE);
		$flag = FALSE;
		$oUser = getLoggedUser();	
		if(NULL != $oUser && $oUser != "") {
			if($oUser->user_role_id == 0 && $oUser->is_super == 1) {
				$flag = TRUE;
			} else if($oUser->user_role_id != 0) {
				if(!file_exists(DOCUMENT_ROOT."roles/role_".$oUser->user_role_id.".php")) {
					createRoleFiles();
				}
				include_once(DOCUMENT_ROOT."roles/role_".$oUser->user_role_id.".php");
				global $ACTION;
				if(isset($ACTION[$controller][$function]) && $ACTION[$controller][$function] == TRUE) { $flag = TRUE; }
			}
		}
		if($setGlobal == TRUE) {
			global $calledController, $calledFunction;
			$calledController = $controller;
			$calledFunction = $function;
		}
		return $flag;
	}

	function createRoleFiles($role_id = 0) {
		$CI = & get_instance();
		$CI->load->model('m_role');
		$CI->load->model('m_user_ref_type');

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
				$file_content[] = "<?php \n global ".'$ACTION;'." \n";
				if(count($arrActions) > 0) {					
					foreach($arrActions as $action) {
						$action["controller"] = strtolower($action["controller"]);
						$action["function"] = strtolower($action["function"]);
						if(isset($roleActions[$action["action_id"]])) {
							$file_content[] = '$ACTION["'.$action["controller"].'"]["'.$action["function"].'"] = TRUE;'."\n";
						} else {
							$file_content[] = '$ACTION["'.$action["controller"].'"]["'.$action["function"].'"] = FALSE;'."\n";
						}
					}					
				}

				$file_content[] = "?>";
				$file = implode(" ", $file_content);

				$file_path = DOCUMENT_ROOT."roles"; 
				if(!is_dir($file_path)){
					mkdir($file_path,0755,TRUE);
				}

				file_put_contents($file_path."/role_".$role["role_id"].".php", $file_content);
			}
		}
	}