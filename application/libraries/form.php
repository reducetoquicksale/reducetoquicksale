<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form {
	
    const TEXT = "text";
	const PASSWORD = "password";
	const TEXTAREA = "textarea";
	const HIDDEN = "hidden";
	const CHECKBOX = "checkbox";
	const RADIO = "radio";
	const SELECT = "select";
	const SUBMIT = "submit";
	const BUTTON = "button";
	const RESET = "reset";
	
	private $formElements = array();
	
	private $config; 

	function __construct(){
		$this->config = array(
						'auto_validation' => TRUE,
						'template_path' => '',
						'form_submit_url' => '',
						'form_submit_method' => 'POST',
						'form_start_file_name' => 'form_start',
						'form_field_file_name' => 'form_fields',
						'form_end_file_name' => 'form_end'
		);
	}
	
	public function config($configrations){
		$this->config = array_replace($this->config, $configrations);
	}
	
	public function addElement($elementObj){
		if(isset($elementObj->type)){
			$new_field = new stdClass();
			$new_field->type = isset($elementObj->type) ? $elementObj->type : "";
			$new_field->name = isset($elementObj->name) ? $elementObj->name : "";
			$new_field->value = isset($elementObj->value) ? $elementObj->value : "";
			$new_field->label = isset($elementObj->label) ? $elementObj->label : "";
			$new_field->class = isset($elementObj->class) ? $elementObj->class : "";
			$new_field->id = isset($elementObj->id) ? $elementObj->id : $elementObj->name;
			$new_field->maxlength = isset($elementObj->maxlength) ? $elementObj->maxlength : "";
			$new_field->placeholder = isset($elementObj->placeholder) ? $elementObj->placeholder : "";
			$new_field->description = isset($elementObj->description) ? $elementObj->description : "";
			$new_field->error = isset($elementObj->error) ? $elementObj->error : "";
			$new_field->attributes = isset($elementObj->attributes) ? $elementObj->attributes : "";
			$new_field->validation = isset($elementObj->validation) ? $elementObj->validation : "";
			
			array_push($this->formElements, $new_field);
		}
	}
	
	public function renderForm($template_path=""){
		$CI =& get_instance();
		
		if(count($this->formElements)){
			//$this->resetButtonFields();
			$data['form_submit_url'] = $this->config['form_submit_url'];
			$data['form_submit_method'] = $this->config['form_submit_method'];
			
			if($this->config['template_path'] != ""){
				echo $CI->load->view($this->config['template_path'].'/'.$this->config['form_start_file_name'], $data, TRUE);
			}
			foreach($this->formElements as $key => $value){
				//print_r($this->formElements[$key]);
				echo $this->singleElement($key);
			}
			if($this->config['template_path'] != ""){
				echo $CI->load->view($this->config['template_path'].'/'.$this->config['form_end_file_name'], $data, TRUE);
			}
		}
	}
	
	public function renderElement($elementName){
		foreach($this->formElements as $index => $element_object){
			if($element_object->name == $elementName){
				break;	
			}	
		}
		return $this->singleElement($index);
	}
	
	public function validateForm(){
		$CI =& get_instance();
		$flag = FALSE;
		
		foreach($this->formElements as $index => $element_object){
			if($element_object->validation != ""){
				$flag = TRUE;
				$CI->form_validation->set_rules($element_object->name, $element_object->label, $element_object->validation);
			}
		}
		
		if($flag){
			return $CI->form_validation->run();
		}
		else{
			return TRUE;
		}
	}
	
	private function resetButtonFields(){
		$formEle = &$this->formElements;
		print_r($formEle);
		$replace_index = array();
		
		foreach($formEle as $key => $ele){
			if($ele->type == $this::SUBMIT || $ele->type == $this::RESET || $ele->type == $this::BUTTON){
				$replace_index[] = $key;
			}
		}
		$r_array = array();
		foreach($replace_index as $key){
			echo $key;
			array_push($r_array, $formEle[$key]);
			unset($formEle[$key]);
		}
		$abc = new stdClass();
		$abc->type = $this::BUTTON;
		$abc->name = 'button';
		$abc->value = $r_array;
		print_r($r_array);
		$formEle[] = $abc;
		
		$formEle[$key+1] = $formEle[$key+1]->value[0];
		print_r($formEle);
	}
	
	private function singleElement($index){
		$CI =& get_instance();
		
		$templatePath = ($this->config['template_path'] != "") ? $this->config['template_path'] : "";
		$data['field'] = $this->formElements[$index];
		if($templatePath != ""){
			$formHtml = $CI->load->view($templatePath.'/'.$this->config['form_field_file_name'], $data, TRUE);
		}
		else{
			$field = array(
					'name'          => $data['field']->name,
					'id'            => $data['field']->name,
					'value'         => $data['field']->value,
					'maxlength'     => $data['field']->maxlength
			);
			
			if($data['field']->label != "")
				$formHtml = '<label for="'.$data['field']->name.'">'.$data['field']->label.'</label>';
			$formHtml .= form_input($field);
		}
		return $formHtml;
	}
}

?>