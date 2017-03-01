<!-- Modal -->
						<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						  <div class="modal-dialog">
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						        <h4 class="modal-title" id="myModalLabel">Delete User</h4>
						      </div>
						      <div class="modal-body">
						        Are you sure you want to delete '<strong id="delName"></strong>'?
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						        <a type="button" class="btn btn-primary btn-danger" id="delBtn" href="">Confirm Delete</a>
						      </div>
						    </div>
						  </div>
						</div>  

<section id="main-content">
          <section class="wrapper">
          	<h3><i class="fa fa-user"></i> Users List
            <form method="get" action="" class="pull-right">
            <ul class="nav pull-right top-menu">
                <li>
                	<input type="text" class="form-control" name="keyword" placeholder="Enter keywords..." value="<?php echo $this->input->get('keyword'); ?>">
                </li>
                <li>
                	<button type="submit" name="search" class="btn btn-primary">Go</button>
                </li>
            </ul>
            </form>
            </h3>
              <div class="row mt">
                  <div class="col-md-12">
                      <div class="content-panel">
                          <table class="table table-striped table-advance table-hover">
	                  	  	  <h4><i class="fa fa-angle-right"></i> User Details</h4>
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
	                  	  	  <hr>
                              <thead>
                              <tr>
                                  <th><i class=" fa fa-edit"></i> Status</th>
                                  <th><i class="fa fa-bullhorn"></i> Name</th>
                                  <th><i class="fa fa-bookmark"></i> User Type</th>
                                  <th><i class="fa fa-question-circle"></i> User ID</th>
                                  <th></th>
                              </tr>
                              </thead>
                              <tbody>
                              <?php foreach($user_list->result() as $row){ ?>
                              <tr>
                                  <td>
                                  <?php if($row->user_status == 0){ ?>
                                  	<span class="label label-warning label-mini">In-Active</span>
                                  <?php } else{ ?>
                                  	<span class="label label-success label-mini">Active</span>
                                  <?php } ?>
                                  </td>
                                  <td id="name<?php echo $row->user_id; ?>"><a href="<?php echo base_url('user/view/'.$row->user_id); ?>"><?php if($row->user_type == 2) echo $row->mem_name; else echo $row->user_name ?></a></td>
                                  <td><?php echo userType($row->user_type); ?></td>
                                  <td><?php echo $row->user_loginid; ?></td>
                                  <td>
                                  <?php if($row->user_status == 0){ ?>
                                      <a class="btn btn-success btn-xs" href="<?php echo base_url('user/status/'.$row->user_id.'/1'); ?>" title="Set Active"><i class="fa fa-check"></i></a>
                                  <?php } else{ ?>
                                      <a class="btn btn-danger btn-xs" href="<?php echo base_url('user/status/'.$row->user_id.'/0'); ?>" title="Set Inactive"><i class="fa fa-ban"></i></a>
                                  <?php } ?>
                                      <button class="btn btn-danger btn-xs" title="Delete" data-toggle="modal" data-target="#deleteModal" id="<?php echo $row->user_id; ?>"><i class="fa fa-trash-o "></i></button>
                                  </td>
                              </tr>
                              <?php } ?>
                              </tbody>
                          </table>
                          <div align="center">
                          <div class="btn-group">
                          <?php echo $this->pagination->create_links(); ?>
                          </div>
                          </div>
                      </div><!-- /content-panel -->
                  </div><!-- /col-md-12 -->
              </div><!-- /row -->

		</section><! --/wrapper -->
      </section>

<script>
$(document).ready(function(e) {
	$('#deleteModal').on('show.bs.modal', function (e) {
		var button = e.relatedTarget;
		var id = button.id;
		var name = $('#name'+id).text();
		$('#delName').text(name);
		var delLink = '<?php echo base_url(); ?>user/delete/'+id
		$('#delBtn').attr('href', delLink);
	})
});
</script>