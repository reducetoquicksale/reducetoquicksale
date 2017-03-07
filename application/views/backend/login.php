<?php if($section == "script") { ?>
	$.backstretch("<?php echo base_url("assets/backend/img/login-bg.jpg"); ?>", {speed: 500});
<?php } if($section == "body") { ?>		
	<div id="login-page">
	  	<div class="container">	  	
		      <form class="form-login" action="" method="post">
		        <h2 class="form-login-heading">sign in now</h2>
		        <?php get_message(); ?>
				<div class="login-wrap">
					<?php $arrField["user_name"]->render_field(); ?>
		            <br>
					<?php $arrField["password"]->render_field(); ?>
		            <label class="checkbox">
		                <span class="pull-right"><a data-toggle="modal" href="login.html#myModal"> Forgot Password?</a></span>
		            </label>
					<?php $arrField["return_url"]->render_field(); ?>
		            <button class="btn btn-theme btn-block" href="index.html" type="submit"><i class="fa fa-lock"></i> SIGN IN</button>
		        </div>
		
		          <!-- Modal -->
		          <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
		              <div class="modal-dialog">
		                  <div class="modal-content">
		                      <div class="modal-header">
		                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		                          <h4 class="modal-title">Forgot Password ?</h4>
		                      </div>
		                      <div class="modal-body">
		                          <p>Enter your e-mail address below to reset your password.</p>
		                          <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">
		
		                      </div>
		                      <div class="modal-footer">
		                          <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
		                          <button class="btn btn-theme" type="button">Submit</button>
		                      </div>
		                  </div>
		              </div>
		          </div>
		          <!-- modal -->
		
		      </form>	  	
	  	
	  	</div>
	</div>
<?php } ?>