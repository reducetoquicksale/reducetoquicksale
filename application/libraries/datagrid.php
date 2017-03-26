<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Datagrid {

	private $arrColumn;			// STORE COLUMN LIST AND DATA TO DISPLAY
	private $arrData;			// STORE DATABASE DATA ROWS
	var $config;				// STORE CONFIGRATION
	
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
	public function addColumn($header_text, $db_column_name="", $field_type = FALSE){
		$column = new stdClass();
		$column->header_text = $header_text;
		$column->db_column_name = $db_column_name;
		$column->field_type = $field_type;
		$this->arrColumn[] = $column;
	}
	
	// SET DATABASE DATA TO DISPLAY IN GRID
	public function setData($data){
		$this->arrData = $data;
	}
	
	public function heading_row(){
		$html = '';
		if($this->config['grid_style'] == Datagrid::TABLE){
			$htmlRowStartTag = '<thead><tr>'."\n";
			$htmlRowEndTag = '</tr></thead>'."\n";
			$htmlColStartTag = '<th>'."\n";
			$htmlColEndTag = '</th>'."\n";
		}
		else{
			$htmlRowStartTag = '<div class="row tr heading">'."\n";
			$htmlRowEndTag = '</div>'."\n";
			$htmlColStartTag = '<div class="colomn th">'."\n";
			$htmlColEndTag = '</div>'."\n";
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
	
	public function data_row($attributes=""){
		$html = '';
		$html .= '<tbody>';
		// SET GRID STYLE : TABLE OR DIV
		if($this->config['grid_style'] == Datagrid::TABLE){
			$htmlRowStartTag = '<tr';
			if(isset($attributes['grid_row']) && is_string($attributes['grid_row']))
				$htmlRowStartTag .= " ".$attributes['grid_row'];
			if(isset($attributes['grid_row']) && is_array($attributes['grid_row'])){
				foreach($attributes['grid_row'] as $atr_n => $atr_v){
					$htmlRowStartTag .= " ".$atr_n.'="'.$atr_v.'"';
				}
			}
			$htmlRowStartTag .= '>'."\n";
			$htmlRowEndTag = '</tr>'."\n";
			$htmlColStartTag = '<td'."\n";
			if(isset($attributes['grid_column']) && is_string($attributes['grid_column']))
				$htmlColStartTag .= " ".$attributes['grid_column'];
			if(isset($attributes['grid_column']) && is_array($attributes['grid_column'])){
				foreach($attributes['grid_column'] as $atr_n => $atr_v){
					$htmlColStartTag .= " ".$atr_n.'="'.$atr_v.'"';
				}
			}
			$htmlColStartTag .= '>'."\n";
			$htmlColEndTag = '</td>'."\n";
		}
		else{
			$htmlRowStartTag = '<div class="row tr data">'."\n";
			$htmlRowEndTag = '</div>'."\n";
			$htmlColStartTag = '<div class="colomn td">'."\n";
			$htmlColEndTag = '</div>'."\n";
		}
		// LOOPING DATABASE ROWS
		foreach($this->arrData as $row_data){
			$html .= $htmlRowStartTag;
			// LOOPING COLUMNS SET IN CONTROLLER
			foreach($this->arrColumn as $val){
				$html .= $htmlColStartTag;
				
				$db_column_name = $val->db_column_name;
				$field_type = $val->field_type;
				// IF CALLBACK AND COLUMN NAME IS TO CALLBACK FUNCTION
				if($field_type == Datagrid::CALLBACK && is_callable($db_column_name)){
					$html .= $db_column_name($row_data);
				}
				// IF DATABASE COLUMN EXISTS THEN PRINT COLUMN VALUE
				else if(is_object($row_data) && isset($row_data->$db_column_name))
					$html .= $row_data->$db_column_name;
				else if(is_array($row_data) && isset($row_data[$db_column_name]))
					$html .= $row_data[$db_column_name];
				
				$html .= $htmlColEndTag;
			}
			$html .= $htmlRowEndTag;
		}
		$html .= '</tbody>';
		return $html;
	}
	
	public function renderGrid($attributes=""){
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
			$htmlStartTag .= '>'."\n";
			$htmlEndTag = '</table>'."\n";
		}
		else{
			$htmlStartTag = '<div ';
			if(isset($attributes['grid']) && is_string($attributes['grid']))
				$htmlStartTag .= " ".$attributes['grid'];
			if(isset($attributes['grid']) && is_array($attributes['grid'])){
				foreach($attributes['grid'] as $atr_n => $atr_v){
					if($atr_n == 'class')
						$atr_v .= ' data-grid';
					$htmlStartTag .= " ".$atr_n.'="'.$atr_v.'"';
				}
			}
			$htmlStartTag .= '>'."\n";
			$htmlEndTag = '</div>'."\n";
		}
		
		$html .= $htmlStartTag;
		$html .= $this->heading_row($attributes);
		$html .= $this->data_row($attributes);
		$html .= $htmlEndTag;
		return $html;
	}
}

?>