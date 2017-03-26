<?php
class M_Action extends CI_Model
{
	function __construct() { parent::__construct(); }

	public function add(){
		$user = getLoggedUser();
		$u_id = dbUser::ID;
		$_POST[dbAction::ADD_TIME] = time();
		$_POST[dbAction::ADDED_BY_USER] = $user->$u_id;
		$user_id = $this->base_model->add('dbAction');
		if($user_id != FALSE){
			return $user_id;
		}
		else
			return FALSE;
	}
	
	public function update($id){
		if(intval($id) < 1)
			return FALSE;
		$user = getLoggedUser();
		$u_id = dbUser::ID;
		$_POST[dbAction::ID] = $id;
		$_POST[dbAction::UPDATE_TIME] = time();
		$_POST[dbAction::UPDATE_BY_USER] = $user->$u_id;
		return $this->base_model->update('dbAction', dbAction::ID);
	}
	
	public function get_rows($where="", $limit="", $start=""){
		//$result = $this->base_model->get_dataset('dbAction', $where, $limit, $start);
		//$result = $this->base_model->get_data_object('dbAction', $where, $limit, $start);
		$result = $this->base_model->get_data_array('dbAction', $where, $limit, $start);
		return $result;
	}
	
	public function count_rows($where=""){
		$result = $this->base_model->get_dataset('dbAction', $where);
		$total_rows = $result->num_rows();
		return $total_rows;
	}
	
	public function delete($user_id){
		if(intval($user_id) < 1)
			return FALSE;
		$_POST[dbAction::ID] = $user_id;
		//$_POST[dbAction::IS_SUPER] = "!=1";
		$this->db->where(dbAction::IS_SUPER." !=", 1);
		return $this->base_model->delete('dbAction', dbAction::ID);
	}
}