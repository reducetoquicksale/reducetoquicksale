          	<h3><i class="fa fa-user"></i> Add User</h3>
          	
          	<!-- BASIC FORM ELELEMNTS -->
          	<div class="row mt">
          		<div class="col-lg-12">
                  <div class="form-panel">
                  	  <h4 class="mb"><i class="fa fa-angle-right"></i> User Details</h4>
                      <?php $msg = $this->session->flashdata(); 
					  		if(is_array($msg) && array_key_exists('msg_type', $msg)){
								if($msg['msg_type'] == 'success')
									$class = 'alert alert-success';
								if($msg['msg_type'] == 'error')
									$class = 'alert alert-danger';
								echo '<div class="'.$class.'">';
								echo $msg['msg'];
								echo '</div>';
							}
					  ?>
						<?php if(validation_errors()){ ?>
                        <div class="alert alert-danger">
                        <?php echo validation_errors(); ?>
                        </div>
                        <?php } ?>
                      <form class="form-horizontal style-form" method="post">
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">User Type</label>
                              <div class="col-sm-10">
                                <div class="radio">
                                  <label>
                                    <input type="radio" class="user_type" name="user_type" id="optionsRadios1" value="1"<?php if(set_value('user_type') == '1' || set_value('user_type') == '') echo ' checked';  ?> checked>
                                    Hotel User
                                  </label>
                                </div>
                                <div class="radio">
                                  <label>
                                    <input type="radio" class="user_type" name="user_type" id="optionsRadios2" value="2"<?php if(set_value('user_type') == '2') echo ' checked'; ?>>
                                    Card User/Member
                                  </label>
                                </div>
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Name</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="user_name" value="<?php echo set_value('user_name'); ?>">
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Email</label>
                              <div class="col-sm-10">
                                  <input type="text" class="form-control" name="email" value="<?php echo set_value('email'); ?>">
                                  <span class="help-block">A block of help text that breaks onto a new line and may extend beyond one line.</span>
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Password</label>
                              <div class="col-sm-10">
                                  <input type="password" class="form-control" name="user_pass" value="<?php echo set_value('user_pass'); ?>">
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Disabled</label>
                              <div class="col-sm-10">
                                  <input class="form-control" id="disabledInput" type="text" placeholder="Disabled input here..." disabled>
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Select Box</label>
                              <div class="col-sm-10">
                                  <select class="form-control">
						  			<option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                  </select>
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-lg-2 col-sm-2 control-label">&nbsp;</label>
                              <div class="col-lg-10">
                                  <button type="submit" class="btn btn-success" name="save"><i class="fa fa-check"></i> Save</button>
                                  <button type="button" class="btn btn-danger" name="cancel"><i class="fa fa-times"></i> Cancel</button>
                              </div>
                          </div>
                      </form>
                  </div>
          		</div><!-- col-lg-12-->      	
          	</div><!-- /row -->
      
<script>
$(document).ready(function(e) {
    $('.user_type').change(function(){
		var c_id = $(this).val();
		if(c_id == 1){
			$('#u_name').show();
			$('#m_name').hide();
		}
		else{
			$('#u_name').hide();
			$('#m_name').show();
		}
	})
});
</script>