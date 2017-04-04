<?php

class m_user extends CI_Model {
	public function __construct(){
		// Call the CI_Model constructor
		parent::__construct();
	}
	
	public function authentication($a=""){
		$loginid = $this->input->post(dbUser::LOGIN_ID);
		if($loginid != ''){
			$this->db->where(dbUser::LOGIN_ID, $loginid);
		}
		else{
			$loginid = $this->input->post(dbUser::EMAIL);
			$this->db->where(dbUser::EMAIL, $loginid);
		}
		$password = sha1($this->input->post(dbUser::PASSWORD));
		$this->db->where(dbUser::PASSWORD, $password);
		$this->db->where(dbUser::STATUS, '1');
		$fields = dbUser::ID.', '.dbUser::LOGIN_ID.', '.dbUser::EMAIL.', '.dbUser::REFERENCE_TYPE.', '.dbUser::ROLE_ID.', '.dbUser::STATUS.', '.dbUser::IS_SUPER;
		$this->db->select($fields);
		$res = $this->db->get(dbUser::TABLE);
		$row_count = $res->num_rows();
		if($row_count > 0){
			$row = $res->row();
			$this->session->set_userdata(ProjectENUM::USER_SESSION_NAME, serialize($row));
			return TRUE;
		}
		else{
			return FALSE;
		}
	}

	public function user_id_exists($value=''){
		//$this->db->reset_query();
		//$value = $this->input->post($FieldName);
		$this->db->where(dbUser::LOGIN_ID, $value);
		$res = $this->db->get(T_USER);
		$row_count = $res->num_rows();
		//$this->db->select($fields);
		if($row_count > 0){
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	public function email_check(){
		$email = $this->input->post('email');
		$this->db->where('user_email', $email);
		if($this->db->count_all_results(T_USER, FALSE)){
			return FALSE;
		}
		else{
			return TRUE;
		}
	}
	
	public function add(){
		$user = getLoggedUser();
		$u_id = dbUser::ID;
		$_POST[dbUser::ADD_TIME] = time();
		$_POST[dbUser::ADDED_BY_USER] = $user->$u_id;
		$_POST[dbUser::PASSWORD] = sha1($this->input->post(dbUser::PASSWORD));
		$user_id = $this->base_model->add('dbUser');
		if($user_id != FALSE){
			return $user_id;
		}
		else
			return FALSE;
	}
	
	public function update($user_id){
		if(intval($user_id) < 1)
			return FALSE;
		$user = getLoggedUser();
		$id = dbUser::ID;
		$_POST[dbUser::ID] = $user_id;
		$_POST[dbUser::UPDATE_TIME] = time();
		$_POST[dbUser::UPDATE_BY_USER] = $user->$id;
		return $this->base_model->update('dbUser', dbUser::ID);
	}
	
	public function get_rows($where="", $limit="", $start=""){
		$result = $this->base_model->get_data_array('dbUser', $where, $limit, $start);
		return $result;
	}
	
	public function count_rows(){
		$result = $this->base_model->get_dataset('dbAction');
		$total_rows = $result->num_rows();
		return $total_rows;
	}
	
	public function delete($user_id){
		if(intval($user_id) < 1)
			return FALSE;
		$_POST[dbUser::ID] = $user_id;
		//$_POST[dbUser::IS_SUPER] = "!=1";
		$this->db->where(dbUser::IS_SUPER." !=", 1);
		return $this->base_model->delete('dbUser', dbUser::ID);
	}
}