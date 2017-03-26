<?php $this->template->add_script("
$(document).ready(function(e) {
	$('#deleteModal').on('show.bs.modal', function (e) {
		var button = e.relatedTarget;
		var id = button.id;
		var name = $('#name'+id).text();
		var name = $('#name'+id).text();
		$('#delName').text(name);
		var delLink = '".base_url().URL::BACKEND . "/user/delete/'+id
		$('#delBtn').attr('href', delLink);
	})
    
    $('.check_uncheck_all').click(function(){
    	var checked_val = $(this).attr('checked');
        if(checked_val == 'checked')
        	$('.check_field').attr('checked', true);
        else
        	$('.check_field').attr('checked', false);
    });
});
") ?>
<!-- Modal -->
						<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						  <div class="modal-dialog">
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						        <h4 class="modal-title" id="myModalLabel">Delete</h4>
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
<!-- Modal Ends -->

          	<h3><i class="fa fa-user"></i> <?php echo $page_title; ?>
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
	                  	  <hr>
                          <?php 
						  
		$grid_attributes['grid'] = array(
									'class'=>'table table-striped table-advance table-hover'
								);
		$grid_attributes['grid_row'] = '';
		$grid_attributes['grid_column'] = '';
		
		echo $this->datagrid->renderGrid($grid_attributes);
						  ?>
                          <div align="center">
                          <div class="btn-group">
                          <?php echo $this->pagination->create_links(); ?>
                          </div>
                          </div>
                      </div><!-- /content-panel -->
                  </div><!-- /col-md-12 -->
              </div><!-- /row -->
