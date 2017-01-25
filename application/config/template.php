<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// TEMPLATE STRUCTURE CONSTANT ARRAY
$config['TPL_CONSTANT'] = array('TPL_BLANK' => 'blank', 'TPL_MAIN' => 'structure_main', 'TPL_PRINT' => 'structure_print');


// TEMPLATE HEADING HTML TAGS
$config['TPL_HTML_HEAD'] = '<!DOCTYPE HTML>';
$config['TPL_HTML_HEAD'] .= "\n".'<html>';
$config['TPL_HTML_HEAD'] .= "\n".'<head>';
$config['TPL_HTML_HEAD'] .= "\n".'<meta charset="utf-8">';
$config['TPL_HTML_HEAD'] .= "\n".'<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"></meta>';
$config['TPL_HTML_HEAD'] .= "\n".'<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">';

// TEMPLATE TITLE CONSTANTS
$config['TPL_TITLE_PREFIX'] = '';
$config['TPL_TITLE_POSTFIX'] = ' | '.APPLICATION_TITLE;

// FOLDER NAME IN WHICH THE TEMPLATES FILES ARE
$config['TPL_VIEW_FOLDER'] = 'template';

/*
PATH OF CSS AND SCRIPT FILES TO BE LOADED
IF MORE THAN ONE FILES ARE TO BE INCLUDED THEN USE THEM IN ARRAY
IF SINGLE FILE IS TO BE INCLUDED USE IS AS STRING
*/
$config['TPL_CSS'] = array('css/reset.css', 'css/style.css', 'js/ddlevelsfiles/ddlevelsmenu-base.css', 'js/ddlevelsfiles/ddlevelsmenu-sidebar.css', 'css/structure.css', 'css/form.css');
$config['TPL_SCRIPT'] = array('js/jquery-1.8.2.min.js', 'js/modernizr.custom.js','js/common.js','js/ddlevelsfiles/ddlevelsmenu.js',"js/validate.js");

// DEFAULT VIEW TO BE LOADED IF NO VIEW IS DEFINED DURING CALL
$config['TPL_DEFAULT_VIEW'] = 'TPL_MAIN';

// MINIFY THE AND COMPRESS THE CSS AND SCRIPT FILES
$config['TPL_MINIFY_CSS'] = TRUE;
$config['TPL_MINIFY_SCRIPT'] = TRUE;
$config['TPL_COMPRESSED_FOLDER'] = 'compressed';
?>