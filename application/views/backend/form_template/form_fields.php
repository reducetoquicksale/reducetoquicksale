<?php
if($field->type == 'text' || $field->type == 'password'){ 
	include('input.php');
} 
?>

<?php if($field->type == 'hidden'){ ?>
								<input type="text" class="<?php echo $field->class; ?>" name="<?php echo $field->name; ?>" id="<?php echo $field->id; ?>" value="<?php echo set_value('user_loginid'); ?>"<?php if($field->attributes != "") echo $field->attributes; ?>>
<?php } ?>

<?php
if($field->type == 'select'){
	include('select.php');
}
?>

<?php
if($field->type == 'radio' || $field->type == 'checkbox'){
	include('radio.php');
}
?>

<?php
if($field->type == 'submit' || $field->type == 'reset' || $field->type == 'button'){
	include('button.php');
}
?>