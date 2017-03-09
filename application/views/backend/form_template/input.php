
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label"><?php echo $field->label; ?></label>
                              <div class="col-sm-10">
                                  <input type="<?php echo $field->type; ?>" class="form-control <?php echo $field->class; ?>" name="<?php echo $field->name; ?>" id="<?php echo $field->id; ?>" value="<?php if(set_value($field->name) != "") echo set_value($field->name); else echo $field->value ?>"<?php if($field->placeholder != "") echo ' placeholder="'.$field->placeholder.'"'; if($field->maxlength != "") echo ' maxlength="'.$field->maxlength.'"'; if($field->attributes != "") echo $field->attributes; ?>>
                                  <?php if($field->description != ""){ ?>
                                  <span class="help-block"><?php echo $field->description; ?></span>
                                  <?php } ?>
                              </div>
                          </div>