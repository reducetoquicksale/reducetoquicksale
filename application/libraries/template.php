<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template{
	
	var $title_prefix, $title_postfix, $template_file_folder, $css, $script, $html_head, $default_template_view, $compressed_folder; 
	var $CI, $config_file_loaded = FALSE;
	var $returnHtml = FALSE;

	function __construct(){
		$this->CI =& get_instance();
		$this->load_config('template', true);
	}
	
	public function load($view, $data = NULL, $template = NULL){
		if(!$this->config_file_loaded){
			show_error('Template configration file not loaded');
		}
		
		if($template == NULL || $template == ''){
			$template = $this->default_template_view;
		}
		
		if(is_string($data) && trim($data) == ''){
			$data = NULL;
		}
		if(is_string($view) && trim($view) == ''){
			$view = NULL;
		}
		if(is_array($view)){
			$html = $this->init_view_array($view, $data, $template);
		}
		else{
			$html = $this->init($view, $data, $template);
		}

		if($this->returnHtml == FALSE)
			echo $html;
		else
			return $html;
    }
	
	public function load_config($config_file = '', $constructer_call = false){
		
		if ( file_exists( APPPATH.'config/'.$config_file ) ){
			$config_file = $config_file;
		} else if ( file_exists( APPPATH.'config/'.$config_file.'.php' ) ){
			$config_file = $config_file.'.php';
		} else {
			if($constructer_call == true)
				return;
			else
				show_error('Unable to load the config file: ' . 'config/'.$config_file.'.php');
		}

		if($this->CI->config->load($config_file)){
			$this->config_file_loaded = TRUE;
		} else {
			show_error('Unable to load the config file: ' . 'config/'.$config_file.'.php');
		}		
		
		foreach($this->CI->config->item('TPL_CONSTANT') as $index => $value){
			define($index, $value);
		}
		
		$this->html_head = $this->CI->config->item('TPL_HTML_HEAD');
		$this->title_prefix = $this->CI->config->item('TPL_TITLE_PREFIX');
		$this->title_postfix = $this->CI->config->item('TPL_TITLE_POSTFIX');
		$this->template_file_folder = $this->CI->config->item('TPL_VIEW_FOLDER');
		$this->css = $this->CI->config->item('TPL_CSS');
		$this->script = $this->CI->config->item('TPL_SCRIPT');
		$this->default_template_view = constant($this->CI->config->item("TPL_DEFAULT_VIEW"));
		$this->compressed_folder = $this->CI->config->item('COMPRESSED_FOLDER');
		$this->minify_css = $this->CI->config->item('MINIFY_CSS');
		$this->minify_script = $this->CI->config->item('MINIFY_SCRIPT');
	}
	
	private function init($view, $data, $template){
		$head = array();
		$page_end = array();
		
		if ( ! is_null( $view ) ){
			if ( file_exists( APPPATH.'views/'.$view ) ){
				$view_path = $view;
			}
			else if ( file_exists( APPPATH.'views/'.$view.'.php' ) ){
				$view_path = $view.'.php';
			}
			else{
				show_error('Unable to load the requested file: ' . $view.'.php');
			}
			
			$temp_array = $data;
			$temp_array['section'] = 'script';
			$script = $this->CI->load->view($view_path, $temp_array, true);
			$temp_array['section'] = 'body';
			$body = $this->CI->load->view($view_path, $temp_array, true);
			
			if ( is_null($data) ){
				$data['section_main'] = $body;
				$data['view_script'] = $script;
			}
			else if ( is_array($data) ){
				$data['section_main'] = $body;
				$data['view_script'] = $script;
			}
			else if ( is_object($data) ){
				$data->section_main = $body;
				$data->view_script = $script;
			}
		}
		else{
			if ( is_null($data) ){
				$data['section_main'] = '';
			}
			else if(is_string($data)){
				$data['section_main'] = $data;
			}
		}
		
		$html = $this->tpl_head($data);
		$html .= $this->tpl_body($data, $template);
		$html .= $this->tpl_page_end();
		return $html;
	}
	
	private function init_view_array($view, $data, $template){
		ksort($view);
		$this->CI =& get_instance();
		$head['title'] = $data['title'];
		
		$head['view_script'] = '';
		$body['section_main'] = '';
		foreach($view as $view_data){
			if(is_array($view_data)){
				// LOAD DATA OF CURRENT VIEW IN TEMP ARRAY
				$temp_array = array();
				if(array_key_exists('data', $view_data)){
					$temp_array = $view_data['data'];
				}
				// LOAD SCRIPT FROM FROM THE VIEW
				$head['view_script'] .= $this->CI->load->view($view_data['view'], array_merge((array)$temp_array, array("section" => "script")), true);
				
				// LOAD VIEW ONE BY ONE ACCORDING TO THE SECTION WITH CORRESPONDING DATA
				//$abc = array_merge((array)$temp_array, array("section" => "body"));
				//print_r($abc);
				if(array_key_exists('section', $view_data)){
					if(array_key_exists($view_data['section'], $body))
						$body[$view_data['section']] .= $this->CI->load->view($view_data['view'], array_merge((array)$temp_array, array("section" => "body")), true);
					else
						$body[$view_data['section']] = $this->CI->load->view($view_data['view'], array_merge((array)$temp_array, array("section" => "body")), true);
				}
				// IF NO SECTION IS DEFINED THEN LOAD VIEW IN MAIN SECTION
				else{
					$body['section_main'] .= $this->CI->load->view($view_data['view'], array_merge((array)$temp_array, array("section" => "body")), true);
				}
				$this->CI->load->clear_cache_var();
			}
		}
		
		$html = $this->tpl_head($head);
		$html .= $this->tpl_body($body, $template);
		$html .= $this->tpl_page_end();
		return $html;
	}

    private function tpl_head($head_array){
		$html_head = $this->html_head;
		$html_head .= "\n".'<title>';
		if(isset($this->title_prefix))
			$html_head .= $this->title_prefix;
		if(array_key_exists('title', $head_array))
			$html_head .= $head_array['title'];
		if(isset($this->title_postfix))
			$html_head .= $this->title_postfix;
		$html_head .= '</title>';
		
		if($this->minify_css){
			$this->minify_css();
		}
		if(is_array($this->css)){
			foreach($this->css as $css_file){
				$html_head .= "\n".'<link href="'.base_url().$css_file.'" rel="stylesheet" type="text/css" />';
			}
		}
		else if(is_string($this->css) && $this->css != ''){
			$html_head .= "\n".'<link href="'.base_url().$this->css.'" rel="stylesheet" type="text/css" />';
		}
		
		if($this->minify_script){
			$this->minify_script();
		}
		if(is_array($this->script)){
			foreach($this->script as $script_file){
				$html_head .= "\n".'<script type="text/javascript" src="'.base_url().$script_file.'"></script>';
			}
		}
		else if(is_string($this->script) && $this->script != ''){
			$html_head .= "\n".'<script type="text/javascript" src="'.base_url().$this->script.'"></script>';
		}
		if(array_key_exists('view_script', $head_array) && trim($head_array['view_script']) != ''){
			$html_head .= "\n".'<script type="text/javascript">';
			$html_head .= "\n".$head_array['view_script'];
			$html_head .= "\n".'</script>';
		}
		$html_head .= "\n".'</head>';
		return $html_head;
    }
	
	private function tpl_body($body_array, $template){
		$body_html = "\n".'<body>';
		$body_html .= "\n".$this->CI->load->view($this->template_file_folder.'/'.$template, $body_array, true);
		$body_html .= "\n".'</body>';
		return $body_html;
    }
	
	private function tpl_page_end(){
		$html_page_end = '';
		$html_page_end .= "\n".'</html>';
		return $html_page_end;
	}
	
	public function add_script($file){
		if(is_string($this->script)){
			if(is_string($file)){
				$this->script = array($this->script, $file);
			}
			if(is_array($file)){
				$this->script = array_merge(array($this->script), $file);
			}
		}
		else if(is_array($this->script)){
			if(is_string($file)){
				$this->script = array_merge($this->script, array($file));
			}
			if(is_array($file)){
				$this->script = array_merge($this->script, $file);
			}
		}
		else{
			$this->script = $file;
		}
	}
	
	public function add_css($file){
		if(is_string($this->css)){
			if(is_string($file)){
				$this->css = array($this->css, $file);
			}
			if(is_array($file)){
				$this->css = array_merge(array($this->css), $file);
			}
		}
		else if(is_array($this->css)){
			if(is_string($file)){
				$this->css = array_merge($this->css, array($file));
			}
			if(is_array($file)){
				$this->css = array_merge($this->css, $file);
			}
		}
		else{
			$this->css = $file;
		}
	}
	
	function minify_script(){
		global $application_folder;
		
		$compressed_file_name = '';
		if(is_array($this->script)){
			foreach($this->script as $script){
				$arr_script = explode("/", $script);
				$compressed_file_name .= end($arr_script);
			}
		} else if(is_string($this->script) && $this->script != ''){
			$compressed_file_name = $this->script;
		}
		
		if($compressed_file_name != ''){
			$compressed_file_name = md5($compressed_file_name);
			
			$folder_path = $application_folder."../".$this->compressed_folder."/";
			if(!is_dir($folder_path)){
				mkdir($folder_path);
			}
			
			if (!file_exists($compressed_folder_path.$compressed_file_name.".js")){
				require_once($application_folder.'/third_party/jsmin.php');
				$file_content = "";
				if(is_array($this->script)){
					foreach($this->script as $file) {
						$file_content .= JSMin::minify(file_get_contents($file));
					}
				} else {
					$file_content .= JSMin::minify(file_get_contents($this->script));
				}
				$this->script = $compressed_file_name;
				file_put_contents($compressed_folder_path.$compressed_file_name.".js", $file_content);
				return TRUE;
			}
		}
	}
	
	function minify_css(){
		global $application_folder;
		
		// CREATE COMPRESSED FILE NAME
		$compressed_file_name = '';
		if(is_array($this->css)){
			foreach($this->css as $css){
				$arr_css = explode("/", $css);
				$compressed_file_name .= end($arr_css);
			}
		} else if(is_string($this->css) && $this->css != ''){
			$compressed_file_name = $this->css;
		}
		
		if($compressed_file_name != ''){
			$compressed_file_name = md5($compressed_file_name);
			
			// CHECK IF COMPRESSED FOLDER EXISTS IF NOT THEN CREATE NEW FOLDER
			$folder_path = $application_folder."../".$this->compressed_folder."/";
			if(!is_dir($folder_path)){
				mkdir($folder_path);
			}
			
			if (!file_exists($compressed_folder_path.$compressed_file_name.".css")){
				require_once($application_folder.'/third_party/cssmin.php');
				$file_content = "";
				if(is_array($this->css)){
					foreach($this->css as $file) {
						$file_content .= JSMin::minify(file_get_contents($file));
					}
				} else {
					$file_content .= JSMin::minify(file_get_contents($this->css));
				}
				$this->css = $compressed_file_name;
				file_put_contents($compressed_folder_path.$compressed_file_name.".css", $file_content);
				return TRUE;
			}
		}
	}

	function ajax_view($view, $data, $template = NULL){

		if(!$this->config_file_loaded){
			show_error('Template configration file not loaded');
		}
		
		if($template == NULL || $template == ''){
			$template = $this->default_template_view;
		}
		
		if(is_string($data) && trim($data) == ''){
			$data = NULL;
		}
		if(is_string($view) && trim($view) == ''){
			$view = NULL;
		}
		
		if ( ! is_null( $view ) ){
			if ( file_exists( APPPATH.'views/'.$view ) ){
				$view_path = $view;
			}
			else if ( file_exists( APPPATH.'views/'.$view.'.php' ) ){
				$view_path = $view.'.php';
			}
			else{
				show_error('Unable to load the requested file: ' . $view.'.php');
			}
			
			$temp_array = $data;
			$temp_array['section'] = 'script';
			$script = $this->CI->load->view($view_path, $temp_array, true);
			$temp_array['section'] = 'body';
			$body = $this->CI->load->view($view_path, $temp_array, true);
			
			if ( is_null($data) ){
				$data['section_main'] = $body;
				$data['view_script'] = $script;
			}
			else if ( is_array($data) ){
				$data['section_main'] = $body;
				$data['view_script'] = $script;
			}
			else if ( is_object($data) ){
				$data->section_main = $body;
				$data->view_script = $script;
			}
		}
		else{
			if ( is_null($data) ){
				$data['section_main'] = '';
			}
			else if(is_string($data)){
				$data['section_main'] = $data;
			}
		} 

		$html= "";
		if($this->minify_css){
			$this->minify_css();
		}
		if(is_array($this->css)){
			foreach($this->css as $css_file){
				$html .= "\n".'<link href="'.base_url().$css_file.'" rel="stylesheet" type="text/css" />';
			}
		}
		else if(is_string($this->css) && $this->css != ''){
			$html .= "\n".'<link href="'.base_url().$this->css.'" rel="stylesheet" type="text/css" />';
		}
		
		if($this->minify_script){
			$this->minify_script();
		}
		if(is_array($this->script)){
			foreach($this->script as $script_file){
				$html .= "\n".'<script type="text/javascript" src="'.base_url().$script_file.'"></script>';
			}
		}
		else if(is_string($this->script) && $this->script != ''){
			$html .= "\n".'<script type="text/javascript" src="'.base_url().$this->script.'"></script>';
		}
		if(array_key_exists('view_script', $data) && trim($data['view_script']) != ''){
			$html .= "\n".'<script type="text/javascript">';
			$html .= "\n".$data['view_script'];
			$html .= "\n".'</script>';
		}
		
		$html .= "\n".$this->CI->load->view($this->template_file_folder.'/'.$template, $data, true);
		echo json_encode($html);
	}
}

?>