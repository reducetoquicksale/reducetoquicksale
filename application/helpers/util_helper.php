<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	
	function set_message($msg, $type = MessageType::ERROR) {
		$CI = &get_instance();
		$messages = array();
		if(!is_array($msg))
			$arrMessages[] = $msg;
		else
			$arrMessages = $msg;
			
		foreach($arrMessages as $msg) { $messages[] = array('message' => $msg, 'type' => $type); }
		//keeps on filling the messages array in a session variable
		$existingMessages = $CI->session->userdata('err_msg');
		if($existingMessages != false) {
			$existingMessages = unserialize($existingMessages);
			$messages = array_merge((array)$existingMessages, (array)$messages);
		}
		$CI->session->set_userdata('err_msg', serialize($messages));
	}

	function getMessageTypeHtml($message, $msgClassName, $appendAfterThisHtml = "") {
		$appendAfterThisHtml .= "<div class='".$msgClassName."'>";
		if(is_array($message)) {
			foreach($message as $msg) { $appendAfterThisHtml .= '<div>'.$msg.'</div>'; }
		} else {
			$appendAfterThisHtml .= '<div>'.$message.'</div>';
		}
		$appendAfterThisHtml .= "</div>";
		return $appendAfterThisHtml;
	}

	function get_message($returnHtml = false) {
		$result = false;
		$CI = &get_instance();
		$CI->load->library('session');
		$formattedMessages = "";
		$messages = $CI->session->userdata('err_msg');
		if($messages!=false) {
			$CI->session->unset_userdata('err_msg');
			$messages = unserialize($messages);
			if(count($messages)>0) {
				$arrError = array();
				$arrWarning = array();
				$arrSuccess = array();
				$arrInformation = array();
				foreach($messages as $msg) {
					switch($msg['type']) {
						case MessageType::ERROR:
							$arrError[] = $msg['message'];
							break;
						case MESSAGE_TYPE_WARNING:
							$arrWarning[] = $msg['message'];
							break;
						case MESSAGE_TYPE_SUCCESS:
							$arrSuccess[] = $msg['message'];
							break;
						case MESSAGE_TYPE_INFORMATION;
							$arrInformation[] = $msg['message'];
							break;
					}
				}
				if(count($arrError)>0)
					$formattedMessages = getMessageTypeHtml($arrError, MessageType::ERROR, $formattedMessages);
				if(count($arrWarning)>0)
					$formattedMessages = getMessageTypeHtml($arrWarning, MessageType::WARNING, $formattedMessages);			
				if(count($arrSuccess)>0)
					$formattedMessages = getMessageTypeHtml($arrSuccess, MessageType::SUCCESS, $formattedMessages);				
				if(count($arrInformation)>0)
					$formattedMessages = getMessageTypeHtml($arrInformation, MessageType::INFO, $formattedMessages);	
				$result = true;
			}
		}
		$formattedMessages .= '<div style="clear:both;font-size:0px;">&nbsp;</div>';
		if($result == true) {
			if($returnHtml == FALSE)
				echo $formattedMessages;
			else
				return $formattedMessages;
		}
	}

	function setValidationError($arrFields = null) {
		if($arrFields != null && count($arrFields) > 0 && gettype($arrFields) == "array") {
			$arrErrors = array();
			foreach($arrFields as $field) {
				if(gettype($field) == "string") {
					if (form_error($field) != "") {
						$arrTemp = array();
						$arrTemp["name"] = $field;
						$arrTemp["field"] = "[name='" . $field . "']";
						$arrTemp["message"] = form_error($field);
						$arrTemp["target"] = "[name='" . $field . "']";
						$arrErrors[] = $arrTemp;
					}
				} else if(gettype($field) == "array") {
					if(isset($field["name"])) {
						$temp = form_error($field["name"]);
						if($temp != "" || isset($field["customMessage"])) {
							$arrTemp = array();
							$arrTemp["name"] = $field["name"];
							$arrTemp["field"] = "[name='".$field['name']."']";
							$arrTemp["message"] = isset($field["customMessage"]) ? $field["customMessage"] : $temp;
							$arrTemp["target"] = isset($field["target"]) ? $field["target"] : "[name='".$field['name']."']";
							$arrErrors[] = $arrTemp;
						}
					}
				}
			}

			$CI = &get_instance();		
			$existingErrors = $CI->session->userdata('validation_errors');
			if($existingErrors!=false) {
				$existingErrors = unserialize($existingErrors);
				$arrErrors = array_merge((array)$existingErrors, (array)$arrErrors);
			}
			$CI->session->set_userdata('validation_errors', serialize($arrErrors));
		}
	}

	function getValidationError()
	{
		$CI = &get_instance();		
		$arrErrors = $CI->session->userdata('validation_errors');
		if($arrErrors!=false) {
			$CI->session->unset_userdata('validation_errors');
			$arrErrors = unserialize($arrErrors);
			return $arrErrors;
		}
	}

	function showValidationError() {
		$errors = getValidationError();
		if(is_array($errors)){
			echo "\n\t var errors = ".json_encode($errors);
			echo "\n\t".'$.showCustomErrors(errors)'."\n";
		}
	}

	/*********************************************************************************************/

	function post_json_decode($post) {
		$post = (array)json_decode($post["data"]);
		foreach($post as $index=>$value) {				
			if(preg_match("/[\[]/",$index)) {
				$temp = explode("[",$index);
				$var_name = $temp[0];
				$var_index = preg_replace('/[\[\]\"\']/', '', $temp[1]);
				if(!isset($post[$var_name])) { $post[$var_name] = array(); }
				if($var_index != "") {
					$post[$var_name][$var_index] = $value;
				} else {
					$post[$var_name][] = $value;
				}
				unset($post[$index]);
			}
		}
		return $post;
	}

	function get_previous_page_query_string() {
		$CI = & get_instance();
		$url = $CI->agent->is_referral() ? $CI->agent->referrer() : "";
		$url = explode("?",$url);
		if(count($url) > 1) {
			return $url[1];
		} else {
			return "";
		}
	}

	function get_current_page_query_string($filter = NULL) {
		$CI = & get_instance();
		$arrQuery = explode("&",$_SERVER["QUERY_STRING"]);
		if(is_array($filter)) {
			foreach($filter as $temp) {
				foreach($arrQuery as $index=>$query) {
					$query = explode("=",$query);
					if($query[0] == $temp) {
						unset($arrQuery[$index]);
					}
				}
			}
		} else {
			foreach($arrQuery as $index=>$query) {
				$query = explode("=",$query);
				if($query[0] == $filter) {
					unset($arrQuery[$index]);
				}
			}
		}
		return implode("&",$arrQuery);
	}

	function currency_format($amount, $return_zero = FALSE) {
		return ($amount != 0 || $return_zero == TRUE) ? CURRENCY_SIGN." ".number_format($amount,2) : "";
	}

	function formatDate($para) {
		return ($para != 0) ? date('M d, Y', $para) : "";;
	}

	function formatDateTime($para) {
		return ($para != 0) ? date('D, j M y h:i:s a', $para) : "";
	}

	function setVariable($variable_name, $value) {
		$CI = &get_instance();
		$CI->load->model("m_core");
		$CI->m_core->table = "variables";
		$CI->m_core->data_only = TRUE;

		$form_data = array();
		$form_data["variable_name"] = $variable_name;
		$form_data["value"] = $value;
		if($CI->m_core->listing("id",array("variable_name"=>$variable_name))) {
			$CI->m_core->update($form_data,array("id"=>$CI->m_core->class_data["id"]));
		} else {
			$CI->m_core->add($form_data);
		}
	}

	function getVariable($variable_name, $defaultValue) {
		$CI = &get_instance();
		$CI->load->model("m_core");
		$CI->m_core->table = "variables";
		$CI->m_core->data_only = TRUE;

		if($CI->m_core->listing("value",array("variable_name"=>$variable_name))) {
			return $CI->m_core->class_data["value"];
		} else {
			return $defaultValue;
		}
	}

	function return_url($default_url = "", $get_referral = TRUE) {
		$default_url = ($default_url == "") ? base_url() : $default_url;
		$CI = & get_instance();
		$return_url = $CI->agent->is_referral() && $get_referral == TRUE ? $CI->agent->referrer() : $default_url;
		if(isset($_POST["return_url"])) {
			$return_url = urldecode($_POST["return_url"]);
		}
		return $return_url;
	}

	function currentUrl() {
		return base_url(uri_string());
	}

	function arrayToClassObj($classObj, Array $array) {
		$class_vars = get_class_vars(get_class($classObj));
		foreach ($class_vars as $name => $value) {
			$classObj->$name = $array[$name];
		}
		return $classObj;
	}

	function objectToClassArray($classObj, Object $array) {
		$class_vars = get_class_vars(get_class($classObj));
		foreach ($class_vars as $name => $value) {
			$classObj[$name] = $array->$name;
		}
		return $classObj;
	}

	function arrayToObject($data)	{
		if (is_array($data) || is_object($data)) {
			$result = array();
			foreach ($data as $key => $value) {
				$result->$key = arrayToObject($value);
			}
			return $result;
		}
		return $data;
	}

	function objectToArray($data)	{
		if (is_array($data) || is_object($data)) {
			$result = array();
			foreach ($data as $key => $value) {
				$result[$key] = objectToArray($value);
			}
			return $result;
		}
		return $data;
	}

	function backendUrl($url) {
		return base_url(URL::BACKEND ."/". $url);
	}