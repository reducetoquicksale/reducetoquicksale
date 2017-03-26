<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// TEMPLATE STRUCTURE CONSTANT ARRAY
$config['TEMPLATES'] = array('MAIN', 'BLANK', 'PRINT');

// DEFAULT VIEW TO BE LOADED IF NO VIEW IS DEFINED DURING CALL
$config['DEFAULT_TEMPLATE'] = 'MAIN';


// TEMPLATE CONFIGRATIONS FOR MAIN
$config['DEFAULT_VIEW_FOLDER'] = 'frontend';
$config['DEFAULT_TITLE_PREFIX'] = '';
$config['DEFAULT_TITLE_POSTFIX'] = ' | '.ProjectENUM::APPLICATION_TITLE;
$config['DEFAULT_META'] = array(
					'viewport' => 'width=device-width, initial-scale=1, maximum-scale=1'
				);
$config['DEFAULT_HEAD_LINK'] = array(
					'icon' => 'images/favicons/favicon.ico',
					'apple-touch-icon' => 'images/favicons/apple-touch-icon.png'
				);
$config['DEFAULT_CSS_FILES'] = array( 
					base_url("assets/css/bootstrap.css"), 
					base_url("assets/font-awesome/css/font-awesome.css"), 
					base_url("assets/css/style.css")
);
$config['DEFAULT_SCRIPT_FILES'] = array(
					base_url("assets/js/jquery.min.js"),
					base_url("assets/js/bootstrap.min.js")
);
$config['DEFAULT_STRUCTURE'] = array(
					'[main]'
				);

$config['DEFAULT_MINIFY_CSS'] = FALSE;
$config['DEFAULT_MINIFY_SCRIPT'] = FALSE;
$config['DEFAULT_COMPRESSED_FOLDER'] = 'compressed';


// TEMPLATE CONFIGRATIONS FOR MAIN
$config['MAIN_CSS_FILES'] = array(
		base_url("assets/css/flaticon.css"),
		base_url('assets/css/et-line-fonts.css'),
		base_url('assets/css/forest-menu.css'),
		base_url('assets/css/animate.min.css'),
		base_url('assets/css/select2.min.css'),
		base_url('assets/css/responsive-media.css'),
		base_url('assets/css/colors/defualt.css')
);
$config['MAIN_SCRIPT_FILES'] = array(
					base_url("assets/js/easing.js"),
					base_url('assets/js/forest-megamenu.js'),
					base_url('assets/js/jquery.appear.min.js'),
					base_url('assets/js/jquery.smoothscroll.js'),
					base_url('assets/js/select2.min.js'),
					base_url('assets/js/custom.js')
);
$config['MAIN_STRUCTURE'] = array(
		'template/html_head',
		'common/homepage_banner',
		'template/main_content_area',
		'[main]',
		'template/html_foot'
	);



// TEMPLATE CONFIGRATIONS FOR BLANK
?>