<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$CI = &get_instance();
function set_message($msg, $type = MESSAGE_TYPE_ERROR)
{
	$messages = array();
	if(!is_array($msg))
		$arrMessages[] = $msg;
	else
		$arrMessages = $msg;
		
	foreach($arrMessages as $msg)
	{
		$messages[] = array('message' => $msg, 'type' => $type);
	}
	//keeps on filling the messages array in a session variable
	$CI = &get_instance();
	$CI->load->library('session');
	$existingMessages = $CI->session->userdata('err_msg');
	if($existingMessages!=false)
	{
		$existingMessages = unserialize($existingMessages);
		$messages = array_merge((array)$existingMessages, (array)$messages);
	}
	$CI->session->set_userdata('err_msg', serialize($messages));
}

function getMessageTypeHtml($arrMessage, $msgClassName, $appendAfterThisHtml)
{
		$appendAfterThisHtml .= "<div class='".$msgClassName."'>";
		foreach($arrMessage as $msg)
			$appendAfterThisHtml .= '<div>'.$msg.'</div>';
		$appendAfterThisHtml .= "</div>";
		return $appendAfterThisHtml;
}

function get_message($returnHtml = false)
{
	$result = false;
	$CI = &get_instance();
	$CI->load->library('session');
	$formattedMessages = "";
	$messages = $CI->session->userdata('err_msg');
	if($messages!=false)
	{
		$CI->session->unset_userdata('err_msg');
		$messages = unserialize($messages);
		if(count($messages)>0)
		{
			$arrError = array();
			$arrWarning = array();
			$arrSuccess = array();
			$arrInformation = array();
			foreach($messages as $msg)
			{
				switch($msg['type'])
				{
					case MESSAGE_TYPE_ERROR:
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
				$formattedMessages = getMessageTypeHtml($arrError, 'error', $formattedMessages);
			if(count($arrWarning)>0)
				$formattedMessages = getMessageTypeHtml($arrWarning, 'warning', $formattedMessages);			
			if(count($arrSuccess)>0)
				$formattedMessages = getMessageTypeHtml($arrSuccess, 'success', $formattedMessages);				
			if(count($arrInformation)>0)
				$formattedMessages = getMessageTypeHtml($arrInformation, 'information', $formattedMessages);	
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

function setValidationError($arrFields = null)
{
	if($arrFields != null && count($arrFields) > 0 && gettype($arrFields) == "array")
	{
		$arrErrors = array();
		foreach($arrFields as $field) {
			if(gettype($field) == "string") {
				if(form_error($field) != "") {
					$arrTemp = array();
					$arrTemp["name"] = $field;
					$arrTemp["field"] = "[name='".$field."']";
					$arrTemp["message"] = form_error($field);
					$arrTemp["target"] = "[name='".$field."']";
					$arrErrors[] = $arrTemp;
				}
			}
			else if(gettype($field) == "array") {
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
		if($existingErrors!=false)
		{
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
	if($arrErrors!=false)
	{
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

function genrateLink($item, $returnText = FALSE) {
	if(validateUserAccess($item["controller"], $item["function"]) || $item["controller"] == "#" || (isset($item["validateLink"]) && $item["validateLink"] == FALSE)) {
		$href = base_url().$item["controller"]."/".$item["function"];
		if(isset($item["query_string"]) && $item["query_string"]!= "") { $href .= "?".$item["query_string"]; } 
		$attributes = "";
		if(isset($item["attributes"]) && count($item["attributes"]) > 0) { 
			foreach($item["attributes"] as $index=>$value) {
				$attributes .= " ".$index.'="'.$value.'"';
			}
		}
		$return_link = '<a href="'.strtolower($href).'" '.$attributes.' title="'.$item["title"].'">';
		if(isset($item['icon'])){
			if($item['icon']['type'] == 'fa'){
				$return_link .= '<i class="fa '.$item['icon']['class'].'"></i>&nbsp;';
			}
			if(isset($item['icon']['new_line']) && $item['icon']['new_line'])
				$return_link .= '<br>';
		}
		$return_link .= $item["title"].'</a>';
		return $return_link;
	} else
		if($returnText == TRUE) { return $item["title"]; } else { return ""; }
		
}

function genrateDateField($field_name, $date = "", $start_date = "1933-1-1", $end_date = "", $id = "", $attribures = null) {
	$CI = & get_instance();
	$data = array("field_name"=>$field_name, "date"=>$date, "start_date"=>$start_date, "end_date"=>$end_date, "id"=>$id, "attribures"=>$attribures);
	return $CI->load->view("common/datefield", $data, TRUE);
}

function generateToolbar($arrToolbar) {
	if(is_array($arrToolbar)) {
		echo "<div class='buttons'><div class='buttons-inner-wrapper'>";
		foreach($arrToolbar as $item) {
			$item["controller"] = strtolower($item["controller"]);
			$item["function"] = strtolower($item["function"]);
			if($item["controller"] != "#" && !isset($item["validateLink"]))
				$userAccess = validateUserAccess($item["controller"], $item["function"]);
			else
				$userAccess = TRUE;
			if($userAccess) { 
				$href = base_url().$item["controller"]."/".$item["function"];
				if(isset($item["query_string"]) && $item["query_string"]!= "") { $href .= "?".$item["query_string"]; } 
				$attributes = "";
				if(isset($item["attributes"]) && count($item["attributes"]) > 0) { 
					foreach($item["attributes"] as $index=>$value) {
						$attributes .= " ".$index.'="'.$value.'"';
					}
				}
				unset($add);
				if(stripos($item["text"], 'save') !== false){
					$add = '<i class="fa fa-floppy-o"></i>';
				}
				if(stripos($item["text"], 'dispatch') !== false){
					$add = '<i class="fa fa-truck"></i>';
				}
				if(stripos($item["text"], 'cancel') !== false){
					$add = '<i class="fa fa-times"></i>';
				}
				if(stripos($item["text"], 'close') !== false){
					$add = '<i class="fa fa-times"></i>';
				}
				if(stripos($item["text"], 'delete') !== false){
					$add = '<i class="fa fa-trash-o"></i>';
				}
				if(stripos($item["text"], 'print') !== false){
					$add = '<i class="fa fa-print"></i>';
				}
				if(stripos($item["text"], 'new') !== false){
					$add = '<i class="fa fa-plus"></i>';
				}
				if(stripos($item["text"], 'active') !== false){
					$add = '<i class="fa fa-check-circle-o"></i>';
				}
				if(stripos($item["text"], 'deactive') !== false){
					$add = '<i class="fa fa-ban"></i>';
				}
				if(stripos($item["text"], 'enable') !== false){
					$add = '<i class="fa fa-check-circle-o"></i>';
				}
				if(stripos($item["text"], 'disable') !== false){
					$add = '<i class="fa fa-ban"></i>';
				}
				if(stripos($item["text"], 'assigned') !== false){
					$add = '<i class="fa fa-square"></i>';
				}
				if(stripos($item["text"], 'unassigned') !== false){
					$add = '<i class="fa fa-share-square-o"></i>';
				}
				if(stripos($item["text"], 'ship') !== false){
					$add = '<i class="fa fa-location-arrow"></i>';
				}
				if(stripos($item["text"], 'expenses') !== false){
					$add = '<i class="fa fa-usd"></i>';
				}
				if(stripos($item["text"], 'tracking') !== false){
					$add = '<i class="fa fa-exchange"></i>';
				}
				if(stripos($item["text"], 'copy') !== false){
					$add = '<i class="fa fa-files-o"></i>';
				}
				if(stripos($item["text"], 'receivable') !== false){
					$add = '<i class="fa fa-money"></i>';
				}
				if(stripos($item["text"], 'payable') !== false){
					$add = '<i class="fa fa-money"></i>';
				}
				if(stripos($item["text"], 'edit') !== false){
					$add = '<i class="fa fa-pencil"></i>';
				}
				if(stripos($item["text"], 'manage') !== false){
					$add = '<i class="fa fa-list"></i>';
				}
?>
				<a href="<?php echo $href; ?>" <?php echo $attributes; ?>><?php echo $add.'<br>'.$item["text"]; ?></a>
<?php 		}
		}
		echo "</div></div>";
	}
}

function generateListLinks($controller, $fieldName, $data) {
	$controller = strtolower($controller);
	$string = "";
	if(validateUserAccess($controller, "edit")) {
		$string .= '<a href="'.base_url().$controller."/edit?".$fieldName."=".$data[$fieldName].'" class="list-link edit" title="Edit">Edit</a>';
	}
	/*if(validateUserAccess($controller, "detail")) { 
		$string .= '<a href="'.base_url().$controller."/detail?".$fieldName."=".$data[$fieldName].'" class="list-link view" title="View">View</a>';
	} 
	if(validateUserAccess($controller, "delete")) { 
		$string .= '<a href="'.base_url().$controller."/delete/".$data[$fieldName].'" class="list-link delete" title="Delete">Delete</a>';
	}
	if(validateUserAccess($controller, "setStatus")) {
		if($data["status"] != STATUS_ENABLE) { 
			$string .= '<a href="'.base_url().$controller."/setStatus/".$data[$fieldName]."?s=".STATUS_ENABLE.'" class="list-link enable" title="Enable">Enable</a>';
		 } else { 
			$string .= '<a href="'.base_url().$controller."/setStatus/".$data[$fieldName]."?s=".STATUS_DISABLE.'" class="list-link disable" title="Disable">Disable</a>';
		 } 
	}*/
	return $string;
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

function formatDate($para){
	return ($para != 0) ? date('M d, Y', $para) : "";;
}

function formatDateTime($para){
	return ($para != 0) ? date('D, j M y h:i:s a', $para) : "";
}

function setVariable($variable_name, $value)
{
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

function getVariable($variable_name, $defaultValue)
{
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