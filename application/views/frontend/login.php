<section class="section-padding error-page pattern-bg ">
            <!-- Main Container -->
            <div class="container">
               <!-- Row -->
               <div class="row">
                  <!-- Middle Content Area -->
                  <div class="col-md-5 col-md-push-7 col-sm-6 col-xs-12">
                     <!--  Form -->
                     <div class="form-grid">
                        <form method="post">
                           <?php render_error_success_msg(); ?>
                           <div class="form-group">
                              <?php echo $this->form->renderLabel(dbUser::EMAIL); ?>
                              <?php echo $this->form->renderField(dbUser::EMAIL); ?>
                           </div>
                           <div class="form-group">
                              <?php echo $this->form->renderLabel(dbUser::PASSWORD); ?>
                              <?php echo $this->form->renderField(dbUser::PASSWORD); ?>
                           </div>
                           <div class="form-group">
                              <div class="row">
                                 <div class="col-xs-12">
                                    <div class="skin-minimal">
                                       <ul class="list">
                                          <li>
                                          <!-- 
                                             <input  type="checkbox" id="minimal-checkbox-1">
                                             <label for="minimal-checkbox-1">Remember Me</label>
                                           -->
                                             <?php echo $this->form->renderLabel('remember'); ?>
                                             <?php echo $this->form->renderField('remember'); ?>
                                          </li>
                                       </ul>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <button class="btn btn-theme btn-lg btn-block">Login With Us</button>
                        </form>
                     </div>
                     <!-- Form -->
                  </div>
                  <div class="col-md-7  col-md-pull-5  col-xs-12 col-sm-6">
                     <div class="heading-panel">
                        <h3 class="main-title text-left">
                           Sign In to your account   
                        </h3>
                     </div>
                     <div class="content-info">
                        <div class="features">
                           <div class="features-icons">
                              <img src="images/icons/chat.png" alt="img">
                           </div>
                           <div class="features-text">
                              <h3>Chat & Messaging</h3>
                              <p>
                                 Access your chats and account info from any device.
                              </p>
                           </div>
                        </div>
                        <div class="features">
                           <div class="features-icons">
                              <img src="images/icons/panel.png" alt="img">
                           </div>
                           <div class="features-text">
                              <h3>User Dashboard</h3>
                              <p>
                                 Maintain a wishlist by saving your favourite items.
                              </p>
                           </div>
                        </div>
                        <span class="arrowsign hidden-sm hidden-xs"><img src="images/arrow.png" alt="" ></span>
                     </div>
                  </div>
                  <!-- Middle Content Area  End -->
               </div>
               <!-- Row End -->
            </div>
            <!-- Main Container End -->
         </section>