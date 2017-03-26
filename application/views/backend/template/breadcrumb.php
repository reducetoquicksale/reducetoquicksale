<?php 
	global $links; 
	global $calledController, $calledFunction;
	$arrBreadCrumb = array();
	$arrBreadCrumb['base'] = "Dashboard";
	foreach($links as $parent) {
		if(isset($parent["child"])) {
			foreach($parent["child"] as $child1) {
				if(isset($child1["child"])) {
					foreach($child1["child"] as $child2) {
						if(strtolower($child2["function"]) == $calledFunction && strtolower($child2["controller"]) == $calledController) {				
							$arrBreadCrumb['parent'] = $parent["title"]["title"];
							$arrBreadCrumb['child1'] = $child1["title"];
							$arrBreadCrumb['child2'] = $child2["title"];
						}
					}
				} else {
					if(strtolower($child1["function"]) == $calledFunction && strtolower($child1["controller"]) == $calledController) {
						$arrBreadCrumb['parent'] = $parent["title"]["title"];
						$arrBreadCrumb['child1'] = $child1["title"];
					}
				}
			}
		}
	}
	if(isset($breadcrumb)) { $arrBreadCrumb = array_merge($arrBreadCrumb, $breadcrumb); }
	echo "<li>".implode(" &gt ",$arrBreadCrumb)."</li>";
?>