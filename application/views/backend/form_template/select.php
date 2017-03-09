
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label"><?php echo $field->label; ?></label>
                              <div class="col-sm-10">
                                  <select class="form-control <?php echo $field->class; ?>" name="<?php echo $field->name; ?>" id="<?php echo $field->id; ?>"<?php if($field->attributes != "") echo $field->attributes; ?>>
                                  <?php if(is_array($field->value)) foreach($field->value as $key=>$value){ ?>
						  			<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                  <?php } ?>
                                  </select>
                                  <?php if($field->description != ""){ ?>
                                  <span class="help-block"><?php echo $field->description; ?></span>
                                  <?php } ?>
                              </div>
                          </div>