<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template{
	
	private $meta, $head_links, $css_files, $css_files_extra, $css, $script_files, $script_files_extra=array(), $script, $views_to_load, $title;
	private $CI, $config, $config_file_name, $template_to_load, $template_dependencies, $config_file_loaded, $structure_set_by_user;
	
	function __construct(){
		$this->CI =& get_instance();
		$this->config_file_name = "template";
		$this->config_file_loaded = FALSE;
		$this->structure_set_by_user = FALSE;
		$this->title = "";
		$this->meta = array();
		$this->head_links = array();
		$this->css_files = array();
		$this->css_files_extra = array();
		$this->css = "";
		$this->script_files = array();
		$this->script_files_extra = array();
		$this->script = "";
		$this->views_to_load = array();
		$this->config = array(
				'VIEW_FOLDER' => '',
				'TITLE_PREFIX' => '',
				'TITLE_POSTFIX' => '',
				'MINIFY_CSS' => '',
				'MINIFY_SCRIPT' => '',
				'COMPRESSED_FOLDER' => ''
		);
		$this->template_dependencies = array(
				'meta' => 'META',
				'head_links' => 'HEAD_LINK',
				'css_files' => 'CSS_FILES',
				'script_files' => 'SCRIPT_FILES'
		);
	}
	
	public function set_config_file($new_config_file = ""){
		if(is_string($new_config_file) && trim($new_config_file) != "")
			$this->config_file_name = trim($new_config_file);
	}
	
	public function set_structure($views){
		$this->set($views);
		$this->structure_set_by_user = TRUE;
	}
	
	public function set_template($template_to_load=""){
		if(is_string($template_to_load) && trim($template_to_load) != "")
			$this->template_to_load = strtoupper(trim($template_to_load));
	}
	
	public function set_title($title=""){
		$this->title .= $title;
	}
	
	public function add_meta($name, $content=""){
		if(is_array($name)){
			$this->meta = array_merge($this->meta, $name);
		}
		else{
			$this->meta = array($name => $content);
		}
	}
	
	public function add_head_link($rel, $href=""){
		if(is_array($rel)){
			$this->head_links = array_merge($this->head_links, $rel);
		}
		else{
			$this->head_links = array($rel => $href);
		}
	}
	
	public function add_css($href){
		if(is_array($href)){
			$this->css_files_extra = array_merge($this->css_files_extra, $href);
		}
		else{
			$this->css .= $href."\n";
		}
	}
	
	public function add_script($src){
		if(is_array($src)){
			$this->script_files_extra = array_merge($this->script_files_extra, $src);
		}
		else{
			$this->script .= $src."\n";
		}
	}
	
	public function render_meta(){
		$meta = '';
		foreach($this->meta as $name => $content)
			$meta .= '<meta name="'.$name.'" content="'.$content.'">'."\n";
		return $meta;
	}
	
	public function render_head_link(){
		$head_link = '';
		foreach($this->head_links as $rel => $href)
			$head_link .= '<link rel="'.$rel.'" href="'.$href.'">'."\n";
		return $head_link;
	}
	
	public function render_css(){
		$css = '';
		foreach($this->css_files as $href)
			$css .= '<link rel="stylesheet" href="'.$href.'">'."\n";
		if(trim($this->css) != ""){
			$css .= '<style>'."\n";
			$css .= $this->css;
			$css .= '</style>'."\n";
		}
		return $css;
	}
	
	public function render_script(){
		$script = '';
		foreach($this->script_files as $file_name)
			$script .= '<script src="'.$file_name.'"></script>'."\n";
		if(trim($this->script) != ""){
			$script .= '<script type="application/javascript">'."\n";
			$script .= $this->script;
			$script .= '</script>'."\n";
		}
		return $script;
	}
	
	public function load($view_name="", $main_data=array(), $template_to_load=""){
		if(!$this->config_file_loaded)
			$this->load_config_file();
		$this->set_template($template_to_load);
		$this->load_template_dependencies();
		
		$html2 = "";
		
		$index = array_search('[main]', $this->views_to_load);
		if($view_name != ""){
			$this->views_to_load[$index] = $view_name;
		}
		else
			unset($this->views_to_load[$index]);
		
		foreach($this->views_to_load as $view){
			$html2 .= $this->CI->load->view($this->config['VIEW_FOLDER'].'/'.$view, $main_data, TRUE);
		}
		
		$this->merge_css_script();
		$html = $this->render_head_html();
		$html .= $html2;
		$html .= "\n".$this->render_foot_html();
		
		echo $html;
	}
	
	private function load_config_file(){
		$config_file = $this->config_file_name;
		// CHECK IF CONFIG FILE EXIST AND LOAD CONFIG FILE
		if ( file_exists( APPPATH.'config/'.$config_file ) ){
			$config_file = $config_file;
		} else if ( file_exists( APPPATH.'config/'.$config_file.'.php' ) ){
			$config_file = $config_file.'.php';
		} else {
			show_error('Unable to load the config file: ' . 'config/'.$config_file.'.php');
		}
		
		if($this->CI->config->load($config_file)){
			$this->config_file_loaded = TRUE;
		} else {
			show_error('Unable to load the config file: ' . 'config/'.$config_file.'.php');
		}
		
		// LOAD DEFAULT/COMMON CONFIGRATIONS
		foreach($this->config as $index=>$val){
			$new_val = $this->CI->config->item('DEFAULT_'.$index);
			if($new_val != "")
				$this->config[$index] = $new_val;
		}
		
		// LOAD DEFAULT/COMMON TEMPLATE DEPENDENCIES
		foreach($this->template_dependencies as $var_name=>$config_item){
			$new_val = $this->CI->config->item('DEFAULT_'.$config_item);
			if(is_array($new_val))
				$this->$var_name = $new_val;
		}
		
		// SET A DEFAULT TEMPLATE STRUCTURE ONLY IF USER HAS NOT SET STRUCTURE USING 'SET_STRUCTURE' FUNCTION FROM CONTROLLER
		if(!$this->structure_set_by_user){
			$STRUCTURE = $this->CI->config->item('DEFAULT_STRUCTURE');
			if(is_array($STRUCTURE))
				$this->set($STRUCTURE);
				$this->config_file_loaded = TRUE;
		}
	}
	
	private function load_template_dependencies(){
		$templates_available = $this->CI->config->item('TEMPLATES');
		if($this->template_to_load != ""){
			if(in_array($this->template_to_load, $templates_available)){
				$loaded_template = $this->template_to_load;
			}
			else{
				show_error('Template view not correct. Available views are '. implode(',', $templates_available));
			}
		}
		else
			$loaded_template = $this->CI->config->item('DEFAULT_TEMPLATE');
			
			// LOAD DEFAULT/COMMON CONFIGRATIONS
			foreach($this->config as $index=>$val){
				$new_val = $this->CI->config->item($loaded_template.'_'.$index);
				if($new_val != "")
					$this->config[$index] = $new_val;
			}
			
			// LOAD DEFAULT/COMMON TEMPLATE DEPENDENCIES
			foreach($this->template_dependencies as $var_name=>$config_item){
				$new_val = $this->CI->config->item($loaded_template.'_'.$config_item);
				if(is_array($new_val))
					$this->$var_name = array_merge($this->$var_name, $new_val);
			}
			
			// SET A SELECTED TEMPLATE STRUCTURE ONLY IF USER HAS NOT SET STRUCTURE USING 'SET_STRUCTURE' FUNCTION FROM CONTROLLER
			if(!$this->structure_set_by_user){
				$STRUCTURE = $this->CI->config->item($loaded_template.'_STRUCTURE');
				if(is_array($STRUCTURE))
					$this->set($STRUCTURE);
			}
	}
	
	private function set($views){
		if(is_array($views)){
			$this->views_to_load = $views;
		}
		else
			show_error('Template structure should be an array of views to display');
	}
	
	private function render_head_html(){
		$html_head = '<!DOCTYPE html>'."\n";
		$html_head .= '<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->'."\n";
		$html_head .= '<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->'."\n";
		$html_head .= '<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->'."\n";
		$html_head .= '<!--[if (gte IE 9)|!(IE)]><!-->'."\n";
		$html_head .= '<html lang="en"> <!--<![endif]-->'."\n";
		$html_head .= '<head>'."\n";
		$html_head .= $this->render_meta();
		$html_head .= '<title>'.$this->config['TITLE_PREFIX'].$this->title.$this->config['TITLE_POSTFIX'].'</title>'."\n";
		$html_head .= $this->render_head_link();
		$html_head .= $this->render_css();
		$html_head .= '<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->'."\n";
		$html_head .= '<!--[if lt IE 9]>'."\n";
		$html_head .= '<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>'."\n";
		$html_head .= '<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>'."\n";
		$html_head .= '<![endif]-->'."\n";
		$html_head .= '</head>'."\n";
		return $html_head;
	}
	
	private function render_foot_html(){
		$html_head = $this->render_script();
		$html_head .= '</html>'."\n";
		return $html_head;
	}
	
	private function merge_css_script(){
		$this->css_files = array_merge($this->css_files, $this->css_files_extra);
		$this->css_files = array_unique($this->css_files);
		$this->script_files = array_merge($this->script_files, $this->script_files_extra);
		$this->script_files = array_unique($this->script_files);
		unset($this->css_files_extra, $this->script_files_extra);
	}
}