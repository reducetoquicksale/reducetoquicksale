<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	// TEMPLATE STRUCTURE CONSTANT ARRAY
	$config['TPL_CONSTANT'] = array("TPL_AJAX"=>"ajax");


	// TEMPLATE HEADING HTML TAGS
	$config['TPL_HTML_HEAD'] = '';

	// TEMPLATE TITLE CONSTANTS
	$config['TPL_TITLE_PREFIX'] = '';

	// FOLDER NAME IN WHICH THE TEMPLATES FILES ARE
	$config['TPL_VIEW_FOLDER'] = 'template';

	/*
	PATH OF CSS AND SCRIPT FILES TO BE LOADED
	IF MORE THAN ONE FILES ARE TO BE INCLUDED THEN USE THEM IN ARRAY
	IF SINGLE FILE IS TO BE INCLUDED USE IS AS STRING
	*/
	$config['TPL_CSS'] = array();
	$config['TPL_SCRIPT'] = array();

	// DEFAULT VIEW TO BE LOADED IF NO VIEW IS DEFINED DURING CALL
	$config['TPL_DEFAULT_VIEW'] = 'TPL_AJAX';

	// MINIFY THE AND COMPRESS THE CSS AND SCRIPT FILES
	$config['TPL_MINIFY_CSS'] = TRUE;
	$config['TPL_MINIFY_SCRIPT'] = TRUE;
	$config['TPL_COMPRESSED_FOLDER'] = 'compressed';

?>