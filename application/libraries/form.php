<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form {
	const TEXT = "text";
	const PASSWORD = "password";
	const TEXTAREA = "textarea";
	const HIDDEN = "hidden";
	const CHECKBOX = "checkbox";
	const RADIO = "radio";
	const SELECT = "select";
	const MULTISELECT = "multiselect";
	const FILE = "file";
	const SUBMIT = "submit";
	const BUTTON = "button";
	const RESET = "reset";
	
	private $formFieldMainArray = array();
	private $fieldGroup = array();
	private $labelVar = "";
	private $fieldVar = "";
	private $config;
	
	function __construct(){
		$this->config = array(
				'auto_validation' => TRUE,
				'template_path' => '',
				'form_action' => '',
				'form_method' => 'POST',
				'form_start_file_name' => 'form_start',
				'form_field_file_name' => 'form_fields',
				'form_end_file_name' => 'form_end'
		);
	}
	
	public function config($configrations){
		$this->config = array_replace($this->config, $configrations);
	}
	
	public function addFormField(FormField $elementObj){
		$elementObj->id = empty($elementObj->id) ? $elementObj->name : $elementObj->id;
		array_push($this->formFieldMainArray, $elementObj);
	}
	
	public function groupFormFields($fields_array){
		if(is_array($fields_array)){
			array_push($this->fieldGroup, $fields_array);
		}
	}
	
	public function renderForm($template_path=""){
		$CI =& get_instance();
		//print_r($this->formFieldMainArray);
		if(count($this->formFieldMainArray)){
			$data['action'] = $this->config['form_action'];
			$data['method'] = $this->config['form_method'];
			
			$formHtml = '';
			if($this->config['template_path'] != ""){
				$formHtml .= $CI->load->view($this->config['template_path'].'/'.$this->config['form_start_file_name'], $data, TRUE);
			}
			else{
				foreach($this->formFieldMainArray as $column){
					if($column->type == Form::FILE){
						$multipart = TRUE;
						break;
					}
				}
				if(isset($multipart))
					$formHtml .= form_open_multipart($this->config['form_action']);
					else
						$formHtml .= form_open($this->config['form_action']);
			}
			foreach($this->formFieldMainArray as $key => $value){
				if(array_key_exists($key, $this->formFieldMainArray))
					$formHtml .= $this->renderFieldHtml($value->name);
			}
			if($this->config['template_path'] != ""){
				$formHtml .= $CI->load->view($this->config['template_path'].'/'.$this->config['form_end_file_name'], $data, TRUE);
			}
			else{
				$formHtml .= form_close();
			}
			return $formHtml;
		}
	}
	
	public function renderFieldHtml($field_name){
		// GET INDEX OF THE FIELD TO BE RENDERED FROM MAIN FIELDS ARRAY
		foreach($this->formFieldMainArray as $index => $value){
			if($value->name == $field_name)
				break;
		}
		$data['field_object'] = $this->formFieldMainArray[$index];
		
		$this->labelVar = array();
		if($data['field_object']->label != ""){
			$this->labelVar = array(
					'label' => $data['field_object']->label,
					'id' => $data['field_object']->id,
					'attributes' => array(
							'class' => $data['field_object']->name."_label"
					)
			);
		}
		
		$this->fieldVar = array(
				'name' => $data['field_object']->name,
				//'field_index' => $index
		);
		
		$formHtml = "";
		$CI =& get_instance();
		$templatePath = ($this->config['template_path'] != "") ? $this->config['template_path'] : "";
		if($templatePath != ""){
			$formHtml = $CI->load->view($templatePath.'/'.$this->config['form_field_file_name'], $data, TRUE);
		}
		else{
			$formHtml .= '<div class="'.$this->fieldVar['name'].'_wrapper field_wrapper">';
			if(!empty($this->labelVar))
				$formHtml .= $this->label();
				$formHtml .= $this->field();
				$formHtml .= '</div>';
		}
		return $formHtml;
	}
	
	public function renderField($field_name, $custom_attributes=""){
		if(is_object($field_name)){
			$this->addFormField($field_name);
			$field_name = $field_name->name;
		}
		foreach($this->formFieldMainArray as $index => $value){
			if($value->name == $field_name)
				break;
		}
		
		$attributes = $value->attributes;
		if(is_array($custom_attributes))
			$attributes = $this->array_add($attributes, $custom_attributes);
			$attributes['id'] = $value->id;
			
			if(set_value($value->name) != "")
				$set_value = set_value($value->name);
				else
					$set_value = $value->value;
					
					$formHtml = "";
					switch($value->type){
						case Form::TEXT:
							$formHtml = form_input($value->name, $set_value, $attributes);
							break;
						case Form::PASSWORD:
							$formHtml = form_password($value->name, '', $attributes);
							break;
						case Form::TEXTAREA:
							$formHtml = form_textarea($value->name, $set_value, $attributes);
							break;
						case Form::HIDDEN:
							$formHtml = form_hidden($value->name, $value->value);
							break;
						case Form::FILE:
							$formHtml = form_upload($value->name, $value->value, $attributes);
							break;
						case Form::CHECKBOX:
							if(set_value($value->name) != "" && !is_array($set_value))
								$dummy_checked = array($set_value);
								else if(set_value($value->name) != "" && is_array($set_value))
									$dummy_checked = $set_value;
									else if(isset($attributes['checked']) && is_array($attributes['checked']))
										$dummy_checked = $attributes['checked'];
										unset($attributes['checked']);
										
										if(!is_array($value->value))
											$value->value = array($value->value=>"");
											
											foreach($value->value as $val=>$lab){
												$checked = FALSE;
												if(isset($dummy_checked) && in_array($val, $dummy_checked))
													$checked = TRUE;
													$attributes['id'] = $value->name.'_'.$val;
													if($lab != "")
														$formHtml .= '<label for="'.$value->name.'_'.$val.'">';
														$formHtml .= form_checkbox($value->name, $val, $checked, $attributes);
														if($lab != "")
															$formHtml .= $lab.'</label>';
											}
											break;
						case Form::RADIO:
							if(!is_array($value->value))
								$value->value = array($value->value=>"");
								
								foreach($value->value as $val=>$lab){
									$checked = FALSE;
									if(set_value($value->name) != "" && $set_value == $val)
										$checked = TRUE;
										else if(isset($attributes['checked']) && $attributes['checked'] == $val){
											$checked = TRUE;
											unset($attributes['checked']);
										}
										$attributes['id'] = $value->name.'_'.$val;
										if($lab != "")
											$formHtml .= '<label for="'.$value->name.'_'.$val.'">';
											$formHtml .= form_radio($value->name, $val, $checked, $attributes);
											if($lab != "")
												$formHtml .= $lab.'</label>';
								}
								break;
						case Form::SELECT:
							$checked = FALSE;
							if(set_value($value->name) != "")
								$checked = $set_value;
								else if(isset($attributes['checked']))
									$checked = $attributes['checked'];
									unset($attributes['checked']);
									$formHtml = form_dropdown($value->name, $value->value, $checked, $attributes);
									break;
						case Form::MULTISELECT:
							$checked = FALSE;
							if(set_value($value->name) != "" && !is_array($set_value))
								$checked = array($set_value);
								else if(set_value($value->name) != "" && is_array($set_value))
									$checked = $set_value;
									else if(isset($attributes['checked']) && is_array($attributes['checked']))
										$checked = $attributes['checked'];
										unset($attributes['checked']);
										//print_r($checked);
										$formHtml = form_multiselect($value->name, $value->value, $checked, $attributes);
										break;
						case Form::SUBMIT:
							$formHtml = form_submit($value->name, $value->value, $attributes);
							break;
						case Form::BUTTON:
							$formHtml = form_reset($value->name, $value->value, $attributes);
							break;
						case Form::RESET:
							$formHtml = form_button($value->name, $value->value, $attributes);
							break;
					}
					if(isset($index))
						unset($this->formFieldMainArray[$index]);
						return $formHtml;
	}
	
	public function renderLabel($field_name, $attributes = ""){
		if(is_object($field_name)){
			$this->addFormField($field_name);
			$field_name = $field_name->name;
		}
		foreach($this->formFieldMainArray as $index => $value){
			if($value->name == $field_name)
				break;
		}
		return form_label($value->label, $value->id, $attributes);
	}
	
	public function label($attributes = ""){
		if(isset($this->labelVar['attributes'])){
			$attributes = $this->array_add($this->labelVar['attributes'], $attributes);
			return form_label($this->labelVar['label'], $this->labelVar['id'], $attributes);
		}
	}
	
	public function field($attributes = ""){
		$fieldHtml = "";
		
		foreach($this->fieldGroup as $groups){
			if(in_array($this->fieldVar['name'], $groups)){
				break;
			}
			else
				unset($groups);
		}
		
		if(!isset($groups))
			$groups = array($this->fieldVar['name']);
			
			foreach($groups as $field_name){
				foreach($this->formFieldMainArray as $index => $value){
					if($value->name == $field_name)
						break;
				}
				
				$new_attributes = $this->array_add($value->attributes, $attributes);
				$this->formFieldMainArray[$index]->attributes = $new_attributes;
				$fieldHtml .= $this->renderField($field_name);
			}
			
			return $fieldHtml;
	}
	
	public function validateForm(){
		$CI =& get_instance();
		$flag = FALSE;
		
		foreach($this->formFieldMainArray as $index => $element_object){
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
	
	// CONCAT VALUES OF TWO ARRAY IF SAME KEY EXISTS
	private function array_add($arr1, $arr2){
		// CHECK IF KEY OF FIRST ARRAY EXIST IN SECOND ARRAY, IF YES THEN CONCATINATE VALUE OF BOTH AND UNSET VALUE OF SECOND ARRAY
		if(is_array($arr1) && is_array($arr2)){
			foreach($arr1 as $key=> $val){
				if(array_key_exists($key, $arr2)){
					$arr1[$key] = $arr1[$key]." ".$arr2[$key];
					unset($arr2[$key]);
				}
			}
			return array_merge($arr1, $arr2);
		}
		if(is_array($arr1))
			return $arr1;
	}
}

class FormField {
	var $type, $name, $label, $value, $id, $description, $error, $attributes, $validation;
	
	public function __construct($name= "", $label= "", $type = Form::TEXT, $validation="") {
		$this->type = $type;
		$this->name = $name;
		$this->label = $label;
		$this->value = "";
		$this->id = '';
		$this->description = '';
		$this->error = '';
		$this->attributes = array();
		$this->validation = $validation;
	}
}
