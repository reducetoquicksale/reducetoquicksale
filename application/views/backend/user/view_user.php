<!-- Modal -->
						<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						  <div class="modal-dialog">
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						        <h4 class="modal-title" id="myModalLabel">Delete User</h4>
						      </div>
						      <div class="modal-body">
						        Are you sure you want to delete <strong>'Admin User Name'</strong>?
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						        <a type="button" class="btn btn-primary btn-danger" href="#">Confirm Delete</a>
						      </div>
						    </div>
						  </div>
						</div>  
<!-- Modal Ends --> 
                        
<!-- Reset Password Modal -->   
						<div class="modal fade" id="suspendModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						  <div class="modal-dialog">
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						        <h4 class="modal-title" id="myModalLabel">Reset Password</h4>
						      </div>
                              <form method="post" action="">
						      <div class="modal-body">
						        Please enter new password
                                <input type="password" class="form-control" name="user_pass">
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						        <button type="submit" class="btn btn-primary btn-warning" name="resetpass">Save Password</button>
						      </div>
                              </form>
						    </div>
						  </div>
						</div> 
<!-- Modal Ends -->
            
          	<!-- BASIC FORM ELELEMNTS -->
          	<h3><i class="fa fa-user"></i> View User Detail</h3>
          	<div class="row mt">
          		<div class="col-lg-12">
                  <div class="form-panel">
                  	  <h4 class="mb"><i class="fa fa-angle-right"></i> User Details &nbsp; &nbsp; 
                      <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal">Delete</a>
                      </h4>
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
                              <label class="col-sm-2 col-sm-2 control-label">Name</label>
                              <div class="col-sm-10">
                                  <p class="form-control-static">
								  Administrator Name
                                  	<span class="label label-warning label-mini">In-Active</span>
                                  	<span class="label label-success label-mini">Active</span>
                                  </p>
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">User Type</label>
                              <div class="col-sm-10">
                                  <p class="form-control-static">Admin</p>
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">User ID</label>
                              <div class="col-sm-10">
                                  <p class="form-control-static">admin_user</p>
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-2 col-sm-2 control-label">Password</label>
                              <div class="col-sm-10">
                                  <p class="form-control-static">***** &nbsp;
                      				<a href="#" class="btn btn-warning  btn-sm" data-toggle="modal" data-target="#suspendModal">Reset Password</a>
                                  </p>
                              </div>
                          </div>
                      </form>
                  </div>
          		</div><!-- col-lg-12-->      	
          	</div><!-- /row -->
