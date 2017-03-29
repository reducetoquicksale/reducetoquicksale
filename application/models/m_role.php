<?php
class M_Role extends M_Core {	

	var $role_id, $role_name;
	function __construct() {
		parent::__construct();
		$role_id = 0;
		$role_name = NULL;
	}

	function getActions() {
		$arrAction = array();
		if($this->getAll(dbAction::TABLE)) {
			foreach($this->result as $row) { $arrAction[$row->action_id] = $row; }
		}
		return $arrAction;
	}

	function getRoles() {
		$arrRole = array();
		if($this->getAll(dbRole::TABLE)) {
			foreach($this->result as $row) { $arrRole[] = $row; }
		}
		return $arrRole;
	}	

	function getRoleActions() {
		$arrAction = array();
		if($this->getAll(dbRoleActionMapping::TABLE, array("role_id" => $this->role_id))) {
			foreach($this->result as $row) { $arrAction[$row->action_id] = $row; }
		}
		return $arrAction;
	}

	/*function add($data){
		if(is_array($data)){
			$sql_part1 = '';
			$sql_part2 = '';
			$flag = false;
			foreach($data as $coloum => $value){
				if($flag){
					$sql_part1 .= ', ';
					$sql_part2 .= ', ';
				}
				$sql_part1 .= $coloum;
				$sql_part2 .= $this->db->escape($value);
				$flag = true;
			}
		}
		$sql = "INSERT INTO ".T_ROLE."($sql_part1) VALUES($sql_part2)";
		
		if($this->db->simple_query($sql)){
			$this->role_id = $this->db->insert_id();
			$this->message = "Role added";
			return true;
		}
		else{
			$this->message = "Error Adding Role";
			return false;
		}
	}

	function update($new_value){
		if(is_array($new_value)){
			$sql_part1 = '';
			$flag = false;
			foreach($new_value as $coloum => $value){
				if($flag){
					$sql_part1 .= ', ';
				}
				$sql_part1 .= $coloum."=".$this->db->escape($value);
				$flag = true;
			}
		}
		$sql = "UPDATE ".T_ROLE." SET $sql_part1 WHERE role_id=".$this->db->escape($this->role_id);
		if($this->db->simple_query($sql)){
			$this->message = "Role Updated";
			return true;
		}
		else{
			$this->message = "Error Updating Role";
			return false;
		}
	}

	function listing($coloum = NULL, $where = '', $table = T_ROLE){
		if($coloum == NULL || $coloum == ''){
			$coloum = '*';
		}
		$sql = "SELECT $coloum FROM ".$table;
		
		if($this->use_join){			
			$sql .= $this->join;
		}
		
		if(is_array($where)){
			$sql_part1 = '';
			$flag = false;
			foreach($where as $coloum => $value){
				if($flag){
					$sql_part1 .= ' AND ';
				}
				$sql_part1 .= $coloum."=".$this->db->escape($value);
				$flag = true;
			}
			$sql .= " WHERE $sql_part1";
		}
		else if(is_string($where) && $where != '') {
			$sql .= " WHERE $where";
		}
		$sql .= " ".$this->filters." ";
		if($this->use_pagination){
			$this->load->library("pagination");
			$res = $this->db->query($sql);
			$num_rows = $res->num_rows();
			
			$limit = $this->pagination->limit($num_rows);
			$sql .= $limit;
		}
		$res = $this->db->query($sql);
		$CI = &get_instance();
		if($res->num_rows() == 1 && $this->data_only){
			$this->class_data = $res->row_array();
			return true;
		}
		else if($res->num_rows() > 0){			
			$this->class_data = $res->result_array();
			return true;
		}
		else{
			$this->message = "Sorry! No Record Found";
			return false;
		}
	}
	
	function delete($role_id){
		$sql = "DELETE FROM ".T_ROLE." WHERE role_id IN(".$role_id.")";
		if($this->db->simple_query($sql)){
			$this->message = "Role deleted";
			return true;
		}
		else{
			$this->message = "Error Deleting Role";
			return false;
		}
	}*/
	
}