<?php

class base_model extends CI_Model {
	
	public function __construct(){
		// Call the CI_Model constructor
		parent::__construct();
	}
	
	public function check_dependencies($dbClassName){
		if(!class_exists($dbClassName)){
			show_error("'$dbClassName' is not a valid class");
			exit();
		}
	}
	
	public function add($dbClassName){
		$this->check_dependencies($dbClassName);
		$refl = new ReflectionClass($dbClassName);
		$constants = $refl->getConstants();
		$insert_data = array();
		foreach($constants as $name=>$value){
			$post_value = $this->input->post($value);
			if($post_value != '')
				$insert_data[$value] = $this->input->post($value);
		}
		$ret = $this->db->insert($dbClassName::TABLE, $insert_data);
		if($ret)
			return $this->db->insert_id();
		else
			return $ret;
	}
	
	public function update($dbClassName, $primary_id_name, $custom_fields=""){
		//if(intval($user_id) < 1)
		//	return FALSE;
		$this->check_dependencies($dbClassName);
		$refl = new ReflectionClass($dbClassName);
		$constants = $refl->getConstants();
		$insert_data = array();
		foreach($constants as $name=>$value){
			$post_value = $this->input->post($value);
			if($post_value !== NULL){
				if($value != $primary_id_name)
					$insert_data[$value] = $this->input->post($value);
				else
					$primary_id_value = $this->input->post($value);
			}
		}
		if(is_array($custom_fields))
			$insert_data = $custom_fields;
		
		$this->db->where($primary_id_name, $primary_id_value);
		if(count($insert_data) > 0)
			return $this->db->update($dbClassName::TABLE, $insert_data);
	}
	
	public function get_dataset($dbClassName, $where="", $limit="", $start=""){
		$this->check_dependencies($dbClassName);
		if($where != "") { $this->db->where($this->getWhere($where)); }
		if(method_exists($dbClassName,'dbJoin')){
			$joins = $dbClassName::dbJoin();
			if(is_array($joins)){
				foreach($joins as $j){
					if(!isset($j[2]))
						$j[2] = '';
					$this->db->join($j[0], $j[1], $j[2]);
				}
			}
		}
		$this->db->select("*");
		$result = $this->db->get($dbClassName::TABLE, $limit, $start);
		return $result;
	}
	
	public function get_data_array($dbClassName, $where="", $limit="", $start=""){
		$result = $this->get_dataset($dbClassName, $where, $limit, $start);
		return $result->result_array();
	}
	
	public function get_data_object($dbClassName, $where, $limit="", $start=""){
		$result = $this->get_dataset($dbClassName, $where, $limit, $start);
		return $result->result();
	}
	
	public function delete($dbClassName, $primary_id_name) {
		$this->check_dependencies($dbClassName);
		$primary_id_value = $this->input->post($primary_id_name);
		$this->db->where($primary_id_name, $primary_id_value);
		return $this->db->delete($dbClassName::TABLE);
	}

	private function getWhere($where) {
		if(is_array($where)){
			$temp = '';
			$flag = false;
			foreach($where as $coloum => $value){
				if($flag) { $this->sql_part1 .= ' AND '; }
				$temp .= $coloum."=".$this->db->escape($value);
				$flag = true;
			}
			return $temp;
		} elseif(is_string($where) && $where != '') {
			return $where;
		}
	}
}