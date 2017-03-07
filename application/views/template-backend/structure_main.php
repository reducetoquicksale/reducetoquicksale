<section id="container" >
	<div class="header-wrapper"><?php include_once('header.php'); ?></div>
	<div class="sidebar-wrapper"><?php include_once('sidebar.php'); ?></div>

	<!--main content start-->
	<section id="main-content">
		<section class="wrapper">
			<?php if(isset($section_main)) echo $section_main; ?>
		</section>
	</section>
	<!--main content end-->

	<div class="footer-wrapper"><?php include_once('footer.php'); ?></div>
</section>