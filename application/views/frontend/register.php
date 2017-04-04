<?php 
$this->template->add_script("

$(document).ready(function(e) {
    var form_to_show = '';
	
	if(form_to_show == ''){
		$('#register-business-form-wrapper').hide();
		$('#register-user-btn').hide();
	}
	else{
		$('#register-user-form-wrapper').hide();
		$('#register-business-btn').hide();
	}
	
	$('#register-business-btn').click(function(e) {
        $('#register-user-form-wrapper').slideUp('700', function(){
			$('#register-user-btn').show();
		});
		$('#register-business-btn').hide(function(e){
			$('#register-business-form-wrapper').slideDown('700');
		});
		return false;
    });
	
	$('#register-user-btn').click(function(e) {
        $('#register-business-form-wrapper').slideUp('700', function(){
			$('#register-business-btn').show();
		});
		$('#register-user-btn').hide(function(){
        	$('#register-user-form-wrapper').slideDown('700');
		});
		return false;
    });
});

");
?>
<section class="section-padding error-page pattern-bg ">
            <!-- Main Container -->
            <div class="container">
               <!-- Row -->
               <div class="row">
                  <div class="col-md-6 col-sm-12 col-xs-12">
                     <div class="heading-panel">
                        <h3 class="main-title text-left">Register with us</h3>
                        <p>&nbsp;</p>
                        <p>Never miss a deal to save money. Register now to stay updated</p>
                     </div>
                     <p><a href="#" class="btn btn-theme" id="register-user-btn">Register as user</a></p>
                     <div class="form-grid" id="register-user-form-wrapper">
                        <form>
                           <div class="form-group">
                              <label>Name</label>
                              <input placeholder="Enter Your Name" class="form-control" type="text">
                           </div>
                           <div class="form-group">
                              <label>Contact Number</label>
                              <input placeholder="Enter Your Contact Number" class="form-control" type="text">
                           </div>
                           <div class="form-group">
                              <label>Email</label>
                              <input placeholder="Your Email" class="form-control" type="email">
                           </div>
                           <div class="form-group">
                              <label>Password</label>
                              <input placeholder="Your Password" class="form-control" type="password">
                           </div>
                           <div class="form-group">
                              <div class="row">
                                 <div class="col-xs-12 col-sm-12">
                                    <div class="skin-minimal">
                                       <ul class="list">
                                          <li>
                                             <input  type="checkbox" id="minimal-checkbox-1">
                                             <label for="minimal-checkbox-1">I agree <a href="#">Terms of Services</a></label>
                                          </li>
                                       </ul>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <button class="btn btn-theme btn-lg btn-block">Register</button>
                        </form>
                     </div>
                  </div>
                  <!-- Middle Content Area  End -->
                  
                  <!-- Middle Content Area -->
                  <div class="col-md-6 col-sm-12 col-xs-12">
                     <div class="heading-panel">
                        <h3 class="main-title text-left">Have a product to sell here?</h3>
                        <p>&nbsp;</p>
                        <p>Register your business today to start increasing you sales.</p>
                     </div>
                     <p><a href="#" class="btn btn-theme" id="register-business-btn">Register a business</a></p>
                     <!--  Form -->
                     <div class="form-grid" id="register-business-form-wrapper">
                        <form>
                           <div class="form-group">
                              <label>Name</label>
                              <input placeholder="Enter Your Name" class="form-control" type="text">
                           </div>
                           <div class="form-group">
                              <label>Contact Number</label>
                              <input placeholder="Enter Your Contact Number" class="form-control" type="text">
                           </div>
                           <div class="form-group">
                              <label>Email</label>
                              <input placeholder="Your Email" class="form-control" type="email">
                           </div>
                           <div class="form-group">
                              <label>Password</label>
                              <input placeholder="Your Password" class="form-control" type="password">
                           </div>
                           <div class="form-group">
                              <div class="row">
                                 <div class="col-xs-12 col-sm-12">
                                    <div class="skin-minimal">
                                       <ul class="list">
                                          <li>
                                             <input  type="checkbox" id="minimal-checkbox-1">
                                             <label for="minimal-checkbox-1">I agree <a href="#">Terms of Services</a></label>
                                          </li>
                                       </ul>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <button class="btn btn-theme btn-lg btn-block">Register</button>
                        </form>
                     </div>
                     <!-- Form -->
                  </div>
               </div>
               <!-- Row End -->
            </div>
            <!-- Main Container End -->
         </section>