<div id="left-bar">
    <?php include_once('sidebar.php'); ?>
</div>
<div id="right-bar">
	<?php include_once('header.php'); ?>
    <div id="content">
    	<ul class="vertical-box" id="breadcrumb">
			<?php include_once('breadcrumb.php'); ?>
        </ul>
		<div class="pageheading">
			<h1><?php if(isset($title)) { echo $title; } ?></h1>
			<?php global $calledController, $calledFunction;
				$temp = $calledController.(trim($calledFunction) == "" ? "" : "-#".$calledFunction); if($calledController !="") { ?>
				<span class="help"><a target="_blank" href="<?php echo base_url("init/help#".strtolower($temp));?>">Help</a></span>
			<?php } ?>
            
        	<?php if(isset($arrToolbar)) { generateToolbar($arrToolbar); } ?>
			<?php if(isset($arrFilter)) { generateToolbar($arrFilter); } ?>
		</div>
		<?php get_message(); ?>
    	<?php if(isset($section_main)) echo $section_main; ?>
	</div>	
	<div id="dialog_container"></div>
    <div id="footer">
		<?php include_once("footer.php"); ?>
    </div>
</div>