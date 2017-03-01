<?php

abstract class FieldType {
    const TEXT = 0;
	const PASSWORD = 1;
	const TEXTARAE = 2;
	const HIDDEN = 3;
	const CHECKBOX = 4;
	const RADIO = 5;
}

/*define("TEXT", "text");
define("PASSWORD", "password");
define("TEXTARAE", "textarea");
define("HIDDEN", "hidden");
define("CHECKBOX", "checkbox");
define("RADIO", "radio");*/

class form_field { 
	var $type, $name, $value, $attributes;
	public function form_field() {
		$this->type = FieldType::TEXT;
		$this->name  = "";
		$this->value  = "";;
		$this->attributes = NULL;

	}
}

function rander_field(form_field $field) {
	if($field->type == FieldType::PASSWORD) {
		echo form_password($field->name, $field->value, $field->attributes); 
		//echo getMessageTypeHtml(form_error($field->name), 'error', '');
	} elseif($field->type == FieldType::TEXT) {
		echo form_input($field->name, $field->value, $field->attributes);
		//echo getMessageTypeHtml(form_error($field->name), 'error', '');
	}  elseif($field->type == FieldType::HIDDEN) {
		echo form_hidden($field->name, $field->value, $field->attributes); 
	}
}