<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	// TEMPLATE STRUCTURE CONSTANT ARRAY
	//$config['TPL_CONSTANT'] = array('TPL_BLANK' => 'blank', 'TPL_MAIN' => 'structure_main', 'TPL_PRINT' => 'structure_print');
    $config['TPL_CONSTANT']  = "abstract class TPLBackend extends TPLFile {
		const BLANK1 = 'blank';
	}";


	// TEMPLATE HEADING HTML TAGS
	$config['TPL_HTML_HEAD'] = '<!DOCTYPE HTML>';
	$config['TPL_HTML_HEAD'] .= "\n".'<html>';
	$config['TPL_HTML_HEAD'] .= "\n".'<head>';
	$config['TPL_HTML_HEAD'] .= "\n".'<meta charset="utf-8">';
	$config['TPL_HTML_HEAD'] .= "\n".'<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"></meta>';
	$config['TPL_HTML_HEAD'] .= "\n".'<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
';

	// TEMPLATE TITLE CONSTANTS
	$config['TPL_TITLE_PREFIX'] = '';
	$config['TPL_TITLE_POSTFIX'] = ' | '.ProjectENUM::APPLICATION_TITLE;

	// FOLDER NAME IN WHICH THE TEMPLATES FILES ARE
	$config['TPL_FOLDER'] = 'template-backend';

	// FOLDER NAME IN WHICH THE VIEW FILES ARE
	$config['TPL_VIEW_FOLDER'] = 'backend';

	/*
	PATH OF CSS AND SCRIPT FILES TO BE LOADED
	IF MORE THAN ONE FILES ARE TO BE INCLUDED THEN USE THEM IN ARRAY
	IF SINGLE FILE IS TO BE INCLUDED USE IS AS STRING
	*/
	$config['TPL_CSS'] = array( 
						"assets/backend/css/bootstrap.css", 
						"assets/backend/font-awesome/css/font-awesome.css", 
						"assets/backend/css/style.css",
						"assets/backend/css/style-responsive.css"
	);
	$config['TPL_SCRIPT'] = array(
						"assets/backend/js/jquery.js",
						'assets/backend/js/jquery-1.8.3.min.js',
						"assets/backend/js/bootstrap.min.js"
	);

	// DEFAULT VIEW TYPE TO BE LOADED IF NO VIEW TYPE IS PASSED DURING CALL
    // NEED TO USER DIRECT VIEW FILE NAME HERE - ENUM NOT SUPPORTED AT THIS TIME
	$config['TPL_DEFAULT_VIEW'] = 'structure_main';

	// MINIFY THE AND COMPRESS THE CSS AND SCRIPT FILES
	$config['TPL_MINIFY_CSS'] = FALSE;
	$config['TPL_MINIFY_SCRIPT'] = FALSE;
	$config['TPL_COMPRESSED_FOLDER'] = 'compressed';

?>