<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// TEMPLATE STRUCTURE CONSTANT ARRAY
$config['TEMPLATES'] = array('MAIN', 'BLANK', 'PRINT');

// DEFAULT VIEW TO BE LOADED IF NO VIEW IS DEFINED DURING CALL
$config['DEFAULT_TEMPLATE'] = 'MAIN';

// TEMPLATE CONFIGRATIONS FOR MAIN
$config['MAIN_VIEW_FOLDER'] = 'backend';
$config['MAIN_TITLE_PREFIX'] = '';
$config['MAIN_TITLE_POSTFIX'] = ' | '.ProjectENUM::APPLICATION_TITLE;
$config['MAIN_META'] = array(
					'viewport' => 'width=device-width, initial-scale=1, maximum-scale=1'
				);
$config['MAIN_HEAD_LINK'] = array(
					'icon' => 'images/favicons/favicon.ico',
					'apple-touch-icon' => 'images/favicons/apple-touch-icon.png'
				);
$config['MAIN_CSS_FILES'] = array( 
					base_url("assets/backend/css/bootstrap.css"), 
					base_url("assets/backend/font-awesome/css/font-awesome.css"), 
					base_url("assets/backend/css/style.css"),
					base_url("assets/backend/css/style-responsive.css")
);
$config['MAIN_SCRIPT_FILES'] = array(
					base_url("assets/backend/js/jquery.js"),
					base_url('assets/backend/js/jquery-1.8.3.min.js'),
					base_url("assets/backend/js/bootstrap.min.js"),
					base_url("assets/backend/js/jquery.dcjqaccordion.2.7.js"),
					base_url('assets/backend/js/jquery.scrollTo.min.js'),
					base_url('assets/backend/js/jquery.nicescroll.js'),
					base_url('assets/backend/js/jquery.sparkline.js'),
					base_url('assets/backend/js/common-scripts.js'),
					base_url('assets/backend/js/gritter/js/jquery.gritter.js'),
					base_url('assets/backend/js/gritter-conf.js'),
					base_url('assets/backend/js/sparkline-chart.js'),
					base_url('assets/backend/js/zabuto_calendar.js')
);
$config['MAIN_STRUCTURE'] = array(
					'template_backend/html_head',
					'[main]',
					'template_backend/html_foot'
				);

$config['MAIN_MINIFY_CSS'] = FALSE;
$config['MAIN_MINIFY_SCRIPT'] = FALSE;
$config['MAIN_COMPRESSED_FOLDER'] = 'compressed';

?>