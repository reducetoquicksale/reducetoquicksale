<?php
class M_Core extends CI_Model 
{	
	public $CI;
    var $insert_id, $data_only, $result, $message, $sql, $error_code, $error_message, $join, $use_join, $filters, $use_pagination;

    function __construct(){
		$this->CI = &get_instance();
        $this->insert_id = 0;
		$this->data_only = false;
        $this->result = NULL;
        $this->message = "";
		$this->sql = NULL;
		$this->error_code = 0;
		$this->error_message = "";
		$this->join = "";
		$this->use_join = false;
		$this->filters = "";
		$this->use_pagination = false;
	}

	function insert($table_name, array $data){
		if(is_array($data)){
			if($this->db->insert($table_name, $data)){
				$this->insert_id = $this->db->insert_id();
				$this->message = "".$table_name." added";
				return true;
			} else{
				$this->message = "Error Adding ".$table_name."";
				return false;
			}
		} else {
			$this->message = "Invalid Data";
			return false;
		}
	}

	function update($table_name, array $data, $where = ''){
		if(is_array($data)){
			$this->db->set($data);
			if($where != null) { $this->db->where($where); }
            if($this->db->update($table_name)){
                $this->message = "".$table_name." Updated";
                return true;
            } else {
                $this->message = "Error Updating ".$table_name."";
                return false;
            }
		} else {
            $this->message = "Invalid Data";
            return false;
        }
    }

    function delete($table_name, $where = null) {
        if($where != null) { $this->db->where($where); }
        if($this->db->update($table_name)){
            $this->message = "".$table_name." deleted";
            return true;
        } else {
            $this->message = "Error deleting ".$table_name."";
            return false;
        }
    }

	function select($table_name, $coloum = NULL, $where = '') {
		if($coloum == NULL || $coloum == '') { $coloum = '*'; }
		
		$this->sql = "SELECT $coloum FROM ".$table_name;		
		if($this->use_join) { $this->sql .= " ".$this->join." "; }
		
		if(is_array($where)){
			$this->sql_part1 = '';
			$flag = false;
			foreach($where as $coloum => $value){
				if($flag) { $this->sql_part1 .= ' AND '; }
				$this->sql_part1 .= $coloum."=".$this->db->escape($value);
				$flag = true;
			}
			$this->sql .= " WHERE $this->sql_part1";
		} elseif(is_string($where) && $where != '') {
			$this->sql .= " WHERE $where";
		}

		$this->sql .= " ".$this->filters." ";

		if($this->use_pagination){
			$this->load->library("pagination");
			$res = $this->db->query($this->sql);
			$num_rows = $res->num_rows();
			
			$limit = $this->pagination->limit($num_rows);
			$this->sql .= $limit;
		}

		$res = $this->db->query($this->sql);
		$CI = &get_instance();
		if($res->num_rows() == 1 && $this->data_only){
			$this->result = $res->row_array();
			return true;
		} elseif($res->num_rows() > 0){			
			$this->result = $res->result_array();
			return true;
		} else {
			$this->message = "Sorry! No Record Found";
			return false;
		}
	} 

    function execute(string $sql){
        if($this->db->query($sql)){
            $this->message = "Query Executed Successfully";
            return true;
        } else {
            $this->message = "Opps ! Some resultbase error accoured";
            return false;
        }
    }

	function getAll($table_name, array $where = NULL) {
        if(empty($where)) {
			 $query = $query = $this->db->get($table_name);
		} else {
			$query = $query = $this->db->get_where($table_name, $where);
		}

        if($query->num_rows() > 0){
            $this->result = $query->result_object();
            return true;
        } else{
            $this->message = "Sorry! No Record Found";
            return false;
        }
    }

    function get(string $sql) {
        $query = $this->db->query($sql);
        if($query->num_rows() > 0){
            $this->result = $query->result_object();
            return true;
        } else{
            $this->message = "Sorry! No Record Found";
            return false;
        }
    }

    function get_single_row($sql) {
        $query = $this->db->query($sql);
        if($query->num_rows() > 0) {
            $this->result = $query->row_array();
            return true;
        } else{
            $this->message = "Sorry! No Record Found";
            return false;
        }
    }
}