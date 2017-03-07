<?php if($section == "script") { ?>
	
<?php } if($section == "body") { ?>
	
	<div class="row mt">
		<div class="col-md-12">
			<div class="content-panel">
				<table class="table table-striped table-advance table-hover">
					<thead>
						<tr>
							<?php if($showCheckbox) { ?>
								<th><?php $checkbox = new form_field(FieldType::CHECKBOX, "selectAll"); echo $checkbox->render_field(); ?></th>
							<?php } ?>
							<?php if($showLinks) { ?>
								<th><?php $checkbox = new form_field(FieldType::CHECKBOX, "selectAll"); //echo $checkbox->render_field(); ?></th>
							<?php } ?>

							<?php foreach($arrColumn as $column) { ?>
								<th><a href="#"><?php echo $column->name; ?></a></th>
							<?php } ?>
						</tr>
					</thead>
					
					<tbody>
						<?php foreach($arrData as $row) { ?>
							<tr>
								<?php if($showCheckbox) { ?>
									<th><?php $checkbox = new form_field(FieldType::CHECKBOX, $id_field."[]", $row->$id_field); echo $checkbox->render_field(); ?></th>
								<?php } ?>
								<?php if($showLinks) { ?>
									<th><?php $checkbox = new form_field(FieldType::CHECKBOX, "selectAll"); //echo $checkbox->render_field(); ?></th>
								<?php } ?>
								
								<?php foreach($arrColumn as $column) { 
									$temp = $column->DBfield; 
									if(!empty($temp)) { echo "<th>".$row->$temp."</th>"; } 
								} ?>
								<!-- <button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>
								<button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
								<button class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button> -->
							</tr>
						<?php  } ?>
					</tbody>
				</table>
			</div><!-- /content-panel -->
		</div><!-- /col-md-12 -->
	</div>

<?php }?>