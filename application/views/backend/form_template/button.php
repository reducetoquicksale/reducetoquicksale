
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">&nbsp;</label>
                              <div class="col-sm-10">
                                  <button type="<?php echo $field->type; ?>" class="btn <?php echo $field->class; ?>" name="<?php echo $field->name; ?>" id="<?php echo $field->name; ?>" value="<?php echo $field->value; ?>"<?php if($field->attributes != "") echo $field->attributes; ?>><?php echo $field->label; ?></button>
                              </div>
                          </div>