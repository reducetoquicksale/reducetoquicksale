
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label"><?php echo $field->label; ?></label>
                              <div class="col-sm-10">
                              <?php if(is_array($field->value)) foreach($field->value as $key=>$value){ ?>
                                <div class="radio">
                                  <label>
                                    <input type="<?php echo $field->type; ?>" class="<?php echo $field->class; ?>" name="<?php echo $field->name; ?>" id="<?php echo $field->name.$key; ?>" value="<?php echo $key; ?>"<?php if(set_value($field->name) == $key) echo ' checked'; if($field->attributes != "") echo $field->attributes; ?>>
                                    <?php echo $value; ?>
                                  </label>
                                </div>
                               <?php } ?>
                              </div>
                          </div>