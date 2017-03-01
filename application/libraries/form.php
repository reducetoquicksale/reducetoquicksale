<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form {
	
    const TEXT = 0;
	const PASSWORD = 1;
	const TEXTARAE = 2;
	const HIDDEN = 3;
	const CHECKBOX = 4;
	const RADIO = 5;
	
	private $formElements = array();
	
	private $config; 

	function __construct(){
		$this->config = array(
						'auto_errors' => FALSE,
						'template_path' => '',
						'form_submit_url' => '',
						'form_submit_method' => 'POST'
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
			$new_field->maxlength = isset($elementObj->maxlength) ? $elementObj->maxlength : "";
			$new_field->placeholder = isset($elementObj->placeholder) ? $elementObj->placeholder : "";
			$new_field->description = isset($elementObj->description) ? $elementObj->description : "";
			$new_field->error = isset($elementObj->error) ? $elementObj->error : "";
			$new_field->attributes = isset($elementObj->attributes) ? $elementObj->attributes : "";
			
			array_push($this->formElements, $new_field);
			
			
			/*
			$this->formElements[] = array(
					'type' => isset($elementObj->type) ? $elementObj->type : "",
					'name' => isset($elementObj->name) ? $elementObj->name : "",
					'value' => isset($elementObj->value) ? $elementObj->value : "",
					'label' => isset($elementObj->label) ? $elementObj->label : "",
					'placeholder' => isset($elementObj->placeholder) ? $elementObj->placeholder : "",
					'description' => isset($elementObj->description) ? $elementObj->description : "",
					'error' => isset($elementObj->error) ? $elementObj->error : "",
					'attributes' => isset($elementObj->attributes) ? $elementObj->attributes : ""
			);
			*/
		}
	}
	
	public function renderForm($template_path=""){
		if(count($this->formElements)){
			$data['form'] = $this->formElements;
			$data['config'] = $this->config;
			$templatePath = ($template_path != "") ? $template_path : ($this->config['template_path'] != "") ? $this->config['template_path'] : "";
			if($templatePath != ""){
				$formHtml = $this->load->view($templatePath, $data, TRUE);
			}
			else
				return "Form template path not set";
		}
	}
	
	public function renderElement($elementName){
		$CI =& get_instance();
		
		foreach($this->formElements as $index => $element_object){
			if($element_object->name == $elementName){
				break;	
			}	
		}
		
		$templatePath = ($this->config['template_path'] != "") ? $this->config['template_path'] : "";
		$data['field'] = $this->formElements[$index];
		if($templatePath != ""){
			$formHtml = $CI->load->view($templatePath, $data, TRUE);
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