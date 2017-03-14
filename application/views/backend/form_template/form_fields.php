
                          <div class="form-group">
                              <?php
                              $label = $this->form->label(array('class'=>'col-sm-2 col-sm-2 control-label')); 
							  if($label != "")
							  	echo $label;
								else
								echo '<label class="col-sm-2 col-sm-2 control-label">&nbsp;</label>';
							  ?>
                              <div class="col-sm-10">
                              	<?php 
								$classes = "";
								if($field_object->type == Form::TEXT || $field_object->type == Form::PASSWORD || $field_object->type == Form::SELECT || $field_object->type == Form::MULTISELECT)
									$classes = array('class' => 'form-control');
								if($field_object->type == Form::SUBMIT || $field_object->type == Form::RESET || $field_object->type == Form::BUTTON)
									$classes = array('class' => 'btn');
								
								echo $this->form->field($classes);
								?>
                              </div>
                          </div>