<?php
class M_Core
{	
    private $CI;
    var $insert_id, $result, $message, $sql;


    function __construct(){
        $this->CI = new CI_Model();

        $this->insert_id = 0;
        $this->result = NULL;
        $this->message = "";
		$this->sql = NULL;
	}

	function insert($table_name, array $data){
		if(is_array($data)){
			if($this->CI->db->insert($table_name, $data)){
				$this->insert_id = $this->CI->db->insert_id();
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
			$this->CI->db->set($data);
			if($where != null) { $this->CI->db->where($where); }
            if($this->CI->db->update($table_name)){
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
        if($where != null) { $this->CI->db->where($where); }
        if($this->CI->db->update($table_name)){
            $this->message = "".$table_name." deleted";
            return true;
        } else {
            $this->message = "Error deleting ".$table_name."";
            return false;
        }
    }

    function execute(string $sql){
        if($this->CI->db->query($sql)){
            $this->message = "Query Executed Successfully";
            return true;
        } else {
            $this->message = "Opps ! Some resultbase error accoured";
            return false;
        }
    }

	function getAll($table_name, array $where = NULL) {
        if(empty($where)) {
			 $query = $query = $this->CI->db->get($table_name);
		} else {
			$query = $query = $this->CI->db->get_where($table_name, $where);
		}

        if($query->num_rows() > 0){
            $this->result = $query->result_array();
            return true;
        } else{
            $this->message = "Sorry! No Record Found";
            return false;
        }
    }

    function get(string $sql) {
        $query = $this->CI->db->query($sql);
        if($query->num_rows() > 0){
            $this->result = $query->result_array();
            return true;
        } else{
            $this->message = "Sorry! No Record Found";
            return false;
        }
    }

    function get_single_row($sql) {
        $query = $this->CI->db->query($sql);
        if($query->num_rows() > 0) {
            $this->class_data = $query->row_array();
            return true;
        } else{
            $this->message = "Sorry! No Record Found";
            return false;
        }
    }
}