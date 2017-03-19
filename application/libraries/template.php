<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template{
	
	private $meta, $head_links, $css_files, $css, $script_files, $script, $views_to_load, $title;
	private $CI, $config, $template_to_load;
	
	function __construct(){
		$this->CI =& get_instance();
		$this->meta = array();
		$this->head_links = array();
		$this->css_files = array();
		$this->css = "";
		$this->script_files = array();
		$this->script = "";
		$this->views_to_load = array();
		$this->title = "";
	}
	
	private function load_config(){
		$config_file = 'template';
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
		
		$this->config['VIEW_FOLDER'] =  $this->CI->config->item($loaded_template.'_VIEW_FOLDER');
		$this->config['TITLE_PREFIX'] =  $this->CI->config->item($loaded_template.'_TITLE_PREFIX');
		$this->config['TITLE_POSTFIX'] =  $this->CI->config->item($loaded_template.'_TITLE_POSTFIX');
		$this->config['MINIFY_CSS'] =  $this->CI->config->item($loaded_template.'_MINIFY_CSS');
		$this->config['MINIFY_SCRIPT'] =  $this->CI->config->item($loaded_template.'_MINIFY_SCRIPT');
		$this->config['COMPRESSED_FOLDER'] =  $this->CI->config->item($loaded_template.'_COMPRESSED_FOLDER');
		
		$META = $this->CI->config->item($loaded_template.'_META');
		if(is_array($META))
			$this->add_meta($META);
		$HEAD_LINK = $this->CI->config->item($loaded_template.'_HEAD_LINK');
		if(is_array($HEAD_LINK))
			$this->add_head_link($HEAD_LINK);
		$CSS_FILES = $this->CI->config->item($loaded_template.'_CSS_FILES');
		if(is_array($CSS_FILES))
			$this->add_css($CSS_FILES);
		$SCRIPT_FILES = $this->CI->config->item($loaded_template.'_SCRIPT_FILES');
		if(is_array($SCRIPT_FILES))
			$this->add_script($SCRIPT_FILES);
		$STRUCTURE = $this->CI->config->item($loaded_template.'_STRUCTURE');
		if(is_array($STRUCTURE))
			$this->set($STRUCTURE);
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
			$this->css_files = array_merge($this->css_files, $href);
		}
		else{
			$this->css .= $href."\n";
		}
	}
	
	public function add_script($src){
		if(is_array($src)){
			$this->script_files = array_merge($this->script_files, $src);
		}
		else{
			$this->script .= $src."\n";
		}
	}
	
	public function set_title($title=""){
		$this->title .= $title;
	}
	
	public function set($views){
		if(is_array($views)){
			$this->views_to_load = array_merge($this->views_to_load, $views);
		}
		else{
			$this->views_to_load = array($name => $content);
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
		$html_head .= '</head>'."\n";
		return $html_head;
	}
	
	private function render_foot_html(){
		$html_head = $this->render_script();
		$html_head .= '</html>'."\n";
		return $html_head;
	}
	
	public function view($view_name="", $main_data=array(), $template_to_load=""){
		if(is_string($template_to_load) && trim($template_to_load) != "")
			$this->template_to_load = strtoupper(trim($template_to_load));
			
		$this->load_config();
		
		$html2 = "";
		
		$index = array_search('[main]', $this->views_to_load);
		if($view_name != ""){
			$this->views_to_load[$index] = $view_name;
		}
		else
			unset($this->views_to_load[$index]);
		
		foreach($this->views_to_load as $view){
			$html2 .= $this->CI->load->view($view, $main_data, TRUE);
		}
		
		$html = $this->render_head_html();
		$html .= $html2;
		$html .= "\n".$this->render_foot_html();
		
		echo $html;
	}
}