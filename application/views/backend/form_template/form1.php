<?php if($field->type == 'text'){ ?>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label"><?php echo $field->label; ?></label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="<?php echo $field->name; ?>" id="<?php echo $field->name; ?>" value="<?php echo set_value('user_loginid'); ?>">
                              </div>
                          </div>
<?php } ?>