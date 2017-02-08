<?php 
	global $links, $calledController, $calledFunction;
	/*
	$parentLink = NULL;
	$arrLinks = array();
	foreach($links as $parent) {
		if(isset($parent["child"])) {
			foreach($parent["child"] as $child1) {
				if(isset($child1["child"])) {
					foreach($child1["child"] as $child2) {
						if(strtolower($child2["controller"]) == $calledController) {							
							$parentLink = $parent["title"]["title"];
							$arrLinks = $parent["child"];
						}
					}
				} else {
					if(strtolower($child1["controller"]) == $calledController) {
						$parentLink = $parent["title"]["title"];
						$arrLinks = $parent["child"];
					}
				}
			}
		} else {
			$parentLink = $calledController;
		}
	}
	*/
?>
<script type="text/javascript">
ddlevelsmenu.setup("dropdown", "sidebar") //ddlevelsmenu.setup("mainmenuid", "topbar|sidebar")
</script>
<div id="navigation">
	<div id="small-logo">
    	Logo
    </div>
	<h3>Main Menu</h3>
	<div class="menu-wrapper">
		<ul class="box markermenu" id="dropdown">
			<li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-tachometer fa-2x"></i><br />Dashboard</a></li>
			<?php 
				foreach($links as $link) {
					$flag = FALSE;				
					if($link["controller"] == "#") {
						if(isset($link["child"])) {
							foreach($link["child"] as $child) {
								if($child["controller"] == "#") {
									if(isset($child["child"])) {
										foreach($child["child"] as $c) {
											$flag = validateUserAccess($c["controller"],$c["function"]);
											if($flag == TRUE) {	break; }
										}
									}
								} else {
									$flag = validateUserAccess($child["controller"],$child["function"]);
									if($flag == TRUE) { break; }
								}
							}
						}
					} else {
						$flag = validateUserAccess($link["controller"],$link["function"]);
					}
					
					if($flag == TRUE) {
						if($link["controller"] == "#") {
							echo '<li>';
							echo getLink($link, TRUE);
							if(isset($link["child"])) {
								echo '<ul id="'.$link['title']['title'].'" class="ddsubmenustyle blackwhite">';
								foreach($link["child"] as $child) {
									if(($temp = getLink($child, TRUE)) != "") { echo "<li>".$temp; }
									if(isset($child["child"])) {
										$tFlag = FALSE;
										foreach($child["child"] as $c) {
											if(validateUserAccess($c["controller"],$c["function"])) {
												if($tFlag == FALSE) {
													echo "<ul>";
													$tFlag = TRUE;
												}
												echo getLink($c);
											}
										}
										if($tFlag == TRUE) {
											echo "</ul>";
										}
									}
									if($temp != "") { echo "</li>"; }
								}
								echo "</ul>";
							}
							echo "</li>";
						} else {
							echo getLink($link);
						}
					}
				}
			?>
		</ul>
	</div>
</div>