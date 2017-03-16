<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Datagrid {

	private $arrColumn;			// STORE COLUMN LIST AND DATA TO DISPLAY
	private $arrData;			// STORE DATABASE DATA ROWS
	var $config;				// STORE CONFIGRATION
	
	const FORM_FIELD = 'form_field';
	const CALLBACK = 'callback';
	const TABLE = 'table';
	const DIV = 'div';
	
	function __construct(){
		$this->CI =& get_instance();
		$this->arrColumn = array();
		$this->arrData = array();
		$this->config = array(
						'template_file' => '',
						'grid_style' => Datagrid::TABLE
		);
	}
	
	public function config($configrations){
		$this->config = array_replace($this->config, $configrations);
	}
	
	// ADD LIST OF COLUMNS TO DISPLAY IN GRID
	public function addColumn($header_text, $db_column_name="", $form_field = FALSE){
		$column = new stdClass();
		$column->header_text = $header_text;
		$column->db_column_name = $db_column_name;
		$column->form_field = $form_field;
		$this->arrColumn[] = $column;
	}
	
	// SET DATABASE DATA TO DISPLAY IN GRID
	public function setData($model, $function){
		$this->CI->load->model($model);
		$data = $this->CI->$model->$function();
		$this->arrData = $data;
	}
	
	public function heading_row(){
		$html = '';
		if($this->config['grid_style'] == Datagrid::TABLE){
			$htmlRowStartTag = '<thead><tr>';
			$htmlRowEndTag = '</tr></thead>';
			$htmlColStartTag = '<th>';
			$htmlColEndTag = '</th>';
		}
		else{
			$htmlRowStartTag = '<div class="row tr heading">';
			$htmlRowEndTag = '</div>';
			$htmlColStartTag = '<div class="colomn th">';
			$htmlColEndTag = '</div>';
		}
		
		$html .= $htmlRowStartTag;
		foreach($this->arrColumn as $val){
			$html .= $htmlColStartTag;
			$html .= $val->header_text;
			$html .= $htmlColEndTag;
		}
		$html .= $htmlRowEndTag;
		return $html;
	}
	
	public function data_row(){
		$html = '';
		$html .= '<tbody>';
		// SET GRID STYLE : TABLE OR DIV
		if($this->config['grid_style'] == Datagrid::TABLE){
			$htmlRowStartTag = '<tr>';
			$htmlRowEndTag = '</tr>';
			$htmlColStartTag = '<td>';
			$htmlColEndTag = '</td>';
		}
		else{
			$htmlRowStartTag = '<div class="row tr data">';
			$htmlRowEndTag = '</div>';
			$htmlColStartTag = '<div class="colomn td">';
			$htmlColEndTag = '</div>';
		}
		// LOOPING DATABASE ROWS
		foreach($this->arrData as $row_data){
			$html .= $htmlRowStartTag;
			foreach($this->arrColumn as $val){
				$html .= $htmlColStartTag;
				
				$db_column_name = $val->db_column_name;
				$form_field = $val->form_field;
				// IF FORM FIELD AND COLUMN NAME IS TO FORM FIELD OBJECT
				if($form_field == Datagrid::FORM_FIELD && is_object($db_column_name)){
					$field = $db_column_name;
					if(!isset($column_name))
						$column_name = $field->value;
					$field->value = "";
					if(isset($row_data->$column_name))
						$field->value = $row_data->$column_name;
					$html .= $this->CI->form->renderField($field);
				}
				// IF CALLBACK AND COLUMN NAME IS TO CALLBACK FUNCTION
				else if($form_field == Datagrid::CALLBACK && is_callable($db_column_name)){
					$html .= $db_column_name($row_data);
				}
				// IF DATABASE COLUMN EXISTS THEN PRINT COLUMN VALUE
				else if(isset($row_data->$db_column_name))
					$html .= $row_data->$db_column_name;
				
				$html .= $htmlColEndTag;
			}
			$html .= $htmlRowEndTag;
		}
		$html .= '</tbody>';
		return $html;
	}
	
	public function renderGrid($attributes){
		$html = '';
		if($this->config['grid_style'] == Datagrid::TABLE){
			$htmlStartTag = '<table';
			if(isset($attributes['grid']) && is_string($attributes['grid']))
				$htmlStartTag .= " ".$attributes['grid'];
			if(isset($attributes['grid']) && is_array($attributes['grid'])){
				foreach($attributes['grid'] as $atr_n => $atr_v){
					$htmlStartTag .= " ".$atr_n.'="'.$atr_v.'"';
				}
			}
			$htmlStartTag .= '>';
			$htmlEndTag = '</table>';
		}
		else{
			$htmlStartTag = '<div class="data-grid">';
			$htmlEndTag = '</div>';
		}
		
		$html .= $htmlStartTag;
		$html .= $this->heading_row();
		$html .= $this->data_row();
		$html .= $htmlEndTag;
		return $html;
	}
}

?>