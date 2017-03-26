<?php

abstract class FieldType {
    const TEXT = 0;
	const PASSWORD = 1;
	const TEXTARAE = 2;
	const HIDDEN = 3;
	const CHECKBOX = 4;
	const RADIO = 5;
}

class form_field { 
	var $type, $name, $value, $attributes, $description, $message, $messageType;
	public function form_field($type = FieldType::TEXT, $name = "", $value = "", $attributes = null, $description = "", $message = "", $messageType = "") {
		$this->type = $type;
		$this->name  = $name;
		$this->value  = $value;
		$this->attributes = $attributes;
		$this->description = $description;
		$this->message = $message;
		$this->messageType = $messageType;
	}

	private function getDescription() {
		if(!empty($this->description)) {
			echo "<div class='description'>".$this->description."</div>";
		}
	}

	private function getFormError() {
		if(!empty(form_error($this->name))) {
			echo getMessageTypeHtml(form_error($this->name), MessageType::ERROR);
		}
	}

	private function getMessage() {
		if(!empty($this->message)) {
			echo getMessageTypeHtml($this->message, $this->messageType);
		}
	}

	function render_field() {
		if($this->type == FieldType::PASSWORD) {
			echo form_password($this->name, $this->value, $this->attributes); 
		} elseif($this->type == FieldType::TEXT) {
			echo form_input($this->name, $this->value, $this->attributes); 
		} elseif($this->type == FieldType::HIDDEN) {
			echo form_hidden($this->name, $this->value, $this->attributes); 
		} elseif($this->type == FieldType::CHECKBOX) {
			echo form_checkbox($this->name, $this->value, $this->attributes); 
		}

		$this->getDescription();
		$this->getFormError();
		$this->getMessage();
	}
}