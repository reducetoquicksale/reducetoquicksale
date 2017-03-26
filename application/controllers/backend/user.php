<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller {

	public function User() {
		parent::InitBackendSite();
		$this->load->model('m_user');
	}
	
	public function add() {
		$this->add_edit();
	}
	
	public function edit($id) {
		$this->add_edit(TRUE, $id);
	}
	
	public function add_edit($edit_call = FALSE, $id='') {
		if($edit_call){
			$where = dbUser::ID."='$id'";
			$rows = $this->m_user->count_rows($where);
			if($rows < 1){
				set_message('error', 'User not found');
				redirect(base_url(URL::BACKEND.'/user/manage'));
			}
			$rows = $this->m_user->get_rows($where);
			$user_data = $rows[0];
		}
		
		$this->load->library('form');
		$this->form->config(array('template_path'=>'backend/form_template'));
		
		$field = new stdClass();
		$field->type = Form::TEXT;
		$field->name = dbUser::LOGIN_ID;
		$field->label = "User Name";
		if($edit_call){
			$field->attributes = array("readonly"=> "readonly");
			$field->value = $user_data[dbUser::LOGIN_ID];
		}
		else
			$field->validation = "required|is_unique[".dbUser::TABLE.".".dbUser::LOGIN_ID."]";
		$this->form_validation->set_message('is_unique', 'User Name already exist');
		$this->form->addFormField($field);
		
		if(!$edit_call){
		$field = new stdClass();
		$field->type = Form::PASSWORD;
		$field->name = dbUser::PASSWORD;
		$field->label = "Password";
		$field->validation = "required";
		$this->form->addFormField($field);
		}
		
		$field = new stdClass();
		$field->type = Form::TEXT;
		$field->name = dbUser::EMAIL;
		$field->label = "Email";
		if($edit_call){
			$field->value = $user_data[dbUser::EMAIL];
		}
		$field->validation = "required|valid_email";
		$this->form->addFormField($field);
		
		$field = new stdClass();
		$field->type = Form::RADIO;
		$field->name = dbUser::REFERENCE_TYPE;
		$field->label = "Reference Type";
		$field->value = array(1=>"Admin", 2=>"User");
		$field->attributes = array('checked' => 2);
		if($edit_call){
			$field->attributes = array('checked' => $user_data[dbUser::REFERENCE_TYPE]);
		}
		$this->form->addFormField($field);
		
		$res = $this->base_model->get_dataset('dbRole');
		$roles = array();
		foreach($res->result_array() as $row){
			$roles[$row[dbRole::ID]] = $row[dbRole::NAME];
		}
		
		$field = new stdClass();
		$field->type = Form::SELECT;
		$field->name = dbUser::ROLE_ID;
		$field->label = "Select Role";
		$field->value = $roles;
		if($edit_call){
			$field->attributes = array('checked' => $user_data[dbUser::ROLE_ID]);
		}
		$this->form->addFormField($field);
		
		$field = new stdClass();
		$field->type = Form::RADIO;
		$field->name = dbUser::STATUS;
		$field->label = "Status";
		$field->value = array(1=>"Active", 0=>"Inactive");
		$field->attributes = array('checked' => 1);
		if($edit_call){
			$field->attributes = array('checked' => $user_data[dbUser::STATUS]);
		}
		$this->form->addFormField($field);
		
		$field = new stdClass();
		$field->type = Form::SUBMIT;
		$field->name = "save";
		$field->value = "Add User";
		if($edit_call){
			$field->value = "Update User";
		}
		$field->attributes = array(
								'class' => "btn-primary"
							);
		$this->form->addFormField($field);
		
		if(isset($_POST['save'])){
			if($this->form->validateForm()){
				if($edit_call)
					$user_id = $this->m_user->update($id);
				else
					$user_id = $this->m_user->add();
				if($user_id){
					set_message('success', 'success');
					redirect(backendUrl("user/add"));
				}
				else{
					set_message('message', 'message');
				}
			}
		}
		
		$main_data['module'] = 'user';
		$main_data['page_title'] = 'Add User';
		if($edit_call)
			$main_data['page_title'] = 'Update User';
		$this->template->set_title($main_data['page_title']);
		$this->template->load('common/add', $main_data);
	}

	public function manage() {
		validateUserAccess($this, true);
		$this->load->library('form');
		$this->load->library("datagrid");
		$this->load->model("m_user");
		
		$field = new stdClass();
		$field->type = Form::CHECKBOX;
		$field->name = "user_id";
		$field->value = array(1=>"");
		$field->attributes = array("class"=> "check_uncheck_all");
		
		$label1 = $this->form->renderField($field);
		
		$this->datagrid->addColumn($label1, function($row){
				$field = new stdClass();
				$field->type = Form::CHECKBOX;
				$field->name = "user_id[]";
				$field->value = array($row[dbUser::ID]=>"");
				$field->attributes = array("class"=> "check_field");
				
				$label1 = $this->form->renderField($field);
				return $label1;
			}, Datagrid::CALLBACK);
		$this->datagrid->addColumn("Status", function($row){
				$href = "";
				if($row[dbUser::STATUS] == 1){
					if($row[dbUser::IS_SUPER] != 1)
						$href = ' href="'.backendUrl('user/status/'.$row[dbUser::ID].'/0').'" title="Set Inactive"';
					return '<a class="label label-success label-mini"'.$href.'>Active</a>';
				}
				else{
					if($row[dbUser::IS_SUPER] != 1)
						$href = ' href="'.backendUrl('user/status/'.$row[dbUser::ID].'/1').'" title="Set Active"';
					return '<a class="label label-warning label-mini"'.$href.'>In-Active</a>';
				}
			}, Datagrid::CALLBACK);
		$this->datagrid->addColumn("User Name", function($row){
				return '<a href="'.base_url().'"><span id="name'.$row[dbUser::ID].'">'.$row[dbUser::LOGIN_ID].'</span></a>';
			}, Datagrid::CALLBACK);
		$this->datagrid->addColumn("Email", "email");
		$this->datagrid->addColumn("Actions", function($row){
				$html = "";
				$html .= ' <a class="btn btn-success btn-xs" href="'.backendUrl('user/edit/'.$row[dbUser::ID]).'" title="Edit"><i class="fa fa-pencil "></i></a>';
				if($row[dbUser::IS_SUPER] != 1){
					$html .= ' <button class="btn btn-danger btn-xs" title="Delete" data-toggle="modal" data-target="#deleteModal" id="'.$row[dbUser::ID].'"><i class="fa fa-trash-o "></i></button>';
				}
				return $html;
			}, Datagrid::CALLBACK);
		
		$total_rows = $this->m_user->count_rows();
		$this->load->library('pagination');
		
		// NEED TO SET BASE URL AND PAGE NO URI SEGMENTS
		$config['base_url'] = base_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3));
		$config['total_rows'] = $total_rows;
		$config['attributes'] = array('class' => 'btn btn-default');
		$config['per_page'] = ProjectENUM::ROWS_TO_SHOW;
    	$config['use_page_numbers'] = TRUE;
		$config['reuse_query_string'] = TRUE;
		$config['cur_tag_open'] = '<span class="btn btn-default">';
		$config['cur_tag_close'] = '</span>';
		if($this->uri->segment(4)){
			$page = ($this->uri->segment(4)) ;
		}
		else{
			$page = 1;
		}
		$user_data = $this->m_user->get_rows('', $config['per_page'], $config['per_page']*($page-1));
		
		$this->pagination->initialize($config);
		$this->datagrid->setData($user_data);

		$data['module'] = 'user';
		$data['page_title'] = 'Manage Users';
		$this->template->set_title($data['page_title']);
		$this->template->load("common/pagedlist", $data);
	}

	public function view() {
		validateUserAccess($this, true);
		
		$data['title'] = 'User Detail';
		$data['module'] = 'user';
		$this->template->load('user/view_user', $data);
	}

	public function status($id, $status) {
		validateUserAccess($this, true);
		
		$id = (int) $id;
		$_POST[dbUser::STATUS] = (int) $status;
		if($this->m_user->update($id))
			set_message('success', 'success');
		else
			set_message('error', 'error');
		redirect(backendUrl("user/manage"));
	}

	public function delete($id) {
		validateUserAccess($this, true);
		
		$id = (int) $id;
		if($this->m_user->delete($id))
			set_message('success', 'success');
		else
			set_message('error', 'error');
		redirect(backendUrl("user/manage"));
	}
}