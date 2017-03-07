<?php if($section == "script") { ?>
	
<?php } if($section == "body") { ?>
	<h3><i class="fa fa-user"></i> <?php echo $title ?></h3>
	<?php echo $this->grid->renderGrid(); ?>
	<?php $this->pagination->links(); ?>
<?php }?>