<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	// TEMPLATE STRUCTURE CONSTANT ARRAY
	//$config['TPL_CONSTANT'] = array('TPL_BLANK' => 'blank', 'TPL_MAIN' => 'structure_main', 'TPL_PRINT' => 'structure_print');
	$config['TPL_CONSTANT']  = "abstract class TPLFrontend extends TPLFile {
		const BLANK1 = 'blank';
	}";


	// TEMPLATE HEADING HTML TAGS
	$config['TPL_HTML_HEAD'] = '<!DOCTYPE HTML>';
	$config['TPL_HTML_HEAD'] .= "\n".'<html>';
	$config['TPL_HTML_HEAD'] .= "\n".'<head>';
	$config['TPL_HTML_HEAD'] .= "\n".'<meta charset="utf-8">';
	$config['TPL_HTML_HEAD'] .= "\n".'<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"></meta>';
	//$config['TPL_HTML_HEAD'] .= "\n".'<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">';

	// TEMPLATE TITLE CONSTANTS
	$config['TPL_TITLE_PREFIX'] = '';
	$config['TPL_TITLE_POSTFIX'] = ' | '.ProjectENUM::APPLICATION_TITLE;

	// FOLDER NAME IN WHICH THE TEMPLATES FILES ARE
	$config['TPL_FOLDER'] = 'template';

	// FOLDER NAME IN WHICH THE VIEW FILES ARE
	$config['TPL_VIEW_FOLDER'] = '';

	/*
	PATH OF CSS AND SCRIPT FILES TO BE LOADED
	IF MORE THAN ONE FILES ARE TO BE INCLUDED THEN USE THEM IN ARRAY
	IF SINGLE FILE IS TO BE INCLUDED USE IS AS STRING
	*/
	$config['TPL_CSS'] = array("assets/css/bootstrap.css", 
								"assets/css/style.css", 
								"assets/css/font-awesome.css", 
								"assets/css/flaticon.css", 
								"assets/css/et-line-fonts.css", 
								"assets/css/forest-menu.css", 
								"assets/css/animate.min.css", 
								"assets/css/select2.min.css", 
								"assets/css/nouislider.min.css", 
								"assets/css/slider.css", 
								"assets/css/owl.carousel.css", 
								"assets/css/owl.theme.css", 
								"skins/minimal/minimal.css", 
								"assets/css/responsive-media.css", 
								"assets/css/colors/defualt.css", 
								"skins/minimal/minimal.css");

	$config['TPL_SCRIPT'] = array("assets/js/modernizr.js",
									"assets/js/jquery.min.js",
									"assets/js/bootstrap.min.js",
									"assets/js/easing.js",
									"assets/js/forest-megamenu.js",
									"assets/js/jquery.appear.min.js",
									"assets/js/jquery.countTo.js",
									"assets/js/jquery.smoothscroll.js",
									"assets/js/select2.min.js",
									"assets/js/nouislider.all.min.js",
									"assets/js/carousel.min.js",
									"assets/js/slide.js",
									"assets/js/imagesloaded.js",
									"assets/js/isotope.min.js",
									"assets/js/icheck.min.js",
									"assets/js/jquery-migrate.min.js",
									"assets/js/theia-sticky-sidebar.js",
									"assets/js/color-switcher.js",
									"assets/js/custom.js");

	// DEFAULT VIEW TYPE TO BE LOADED IF NO VIEW TYPE IS PASSED DURING CALL
    // NEED TO USER DIRECT VIEW FILE NAME HERE - ENUM NOT SUPPORTED AT THIS TIME
	$config['TPL_DEFAULT_VIEW'] = 'structure_main';

	// MINIFY THE AND COMPRESS THE CSS AND SCRIPT FILES
	$config['TPL_MINIFY_CSS'] = FALSE;
	$config['TPL_MINIFY_SCRIPT'] = TRUE;
	$config['TPL_COMPRESSED_FOLDER'] = 'compressed';

?>

