<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Action extends MY_Controller {

	public function Action() {	
		parent::InitBackendSite();
		$this->load->model("M_Action");
	}
	
	public function add() {
		$this->add_edit();
	}
	
	public function edit($id) {
		$this->add_edit(TRUE, $id);
	}
	
	public function add_edit($edit_call = FALSE, $id='') {
		
		$this->return_url = return_url(backendUrl(getActionUrl(UserAction::LISTACTION)));
		$action_data = emptyDBClassArray('dbAction');
		
		if($edit_call) {
			$where = array(dbAction::ID => $id);
			$action_data = $this->M_Action->get_detail($where);
			if($action_data == null) {
				set_message('error', 'Action not found');
				redirect($this->return_url);
			}
		} 

		if(isset($_POST['save'])) {
			$action_data = array_merge($action_data, $_POST);
		}
		
		$this->load->library('form');
		$this->form->config(array('template_path'=>'backend/form_template'));
		
		$field = new FormField();
		$field->type = Form::TEXT;
		$field->name = dbAction::ID;
		$field->label = "Action ID";
		$field->value = &$action_data[dbAction::ID];
		$field->validation = "required";
		$field->attributes = $edit_call ? array("readonly"=> "readonly") : array();
		$this->form->addFormField($field);

		$field = new FormField();
		$field->type = Form::TEXT;
		$field->name = dbAction::NAME;
		$field->label = "Action Name";
		$field->value = &$action_data[dbAction::NAME];
		$field->validation = "required";
		$this->form->addFormField($field);
		
		$field = new FormField();
		$field->type = Form::TEXT;
		$field->name = dbAction::CONTROLLER_NAME;
		$field->label = "Controller Name";
		$field->value = &$action_data[dbAction::CONTROLLER_NAME];
		$field->validation = "required";
		$this->form->addFormField($field);
		
		$field = new FormField();
		$field->type = Form::TEXT;
		$field->name = dbAction::FUNCTION_NAME;
		$field->label = "Function Name";
		$field->value = &$action_data[dbAction::FUNCTION_NAME];
		$field->validation = "required";
		$this->form->addFormField($field);
		
		$res = $this->base_model->get_dataset('dbUI');
		$arrUI = array("" => "Select");
		foreach($res->result_array() as $row){
			$arrUI[$row[dbUI::ID]] = $row[dbUI::NAME];
		}

		$field = new FormField();
		$field->type = Form::SELECT;
		$field->name = dbAction::UI_ID;
		$field->label = "Select UI";
		$field->value = $arrUI;
		$field->attributes = array('checked' => isset($action_data[dbAction::UI_ID]) ? $action_data[dbAction::UI_ID] : "");
		$field->validation = "required";
		$this->form->addFormField($field);
		
		$field = new FormField();
		$field->type = Form::SUBMIT;
		$field->name = "save";
		$field->value = "";
		$field->value = $edit_call ? "Update Action" : "Add Action";
		$field->attributes = array('class' => "btn-primary");
		$this->form->addFormField($field);

		$field = new FormField();
		$field->type = Form::HIDDEN;
		$field->name = "return_url";
		$field->value = $this->return_url;
		$this->form->addFormField($field);
		
		if(isset($_POST['save'])) {
			if($this->form->validateForm()){
				if($edit_call)
					$action_id = $this->M_Action->update($id);
				else
					$action_id = $this->M_Action->add();
				
				if($action_id){
					set_message('success', 'success');
					redirect($this->return_url);
				} else {
					set_message('message', 'message');
				}
			}
		}
		
		$main_data['module'] = 'action';
		$main_data['page_title'] = $edit_call ? 'Update Action' : 'Add Action';
		$this->template->set_title($main_data['page_title']);
		$this->template->load('common/add', $main_data);
	}
	public function manage() {
		//validateActionAccess($this, true);
		$this->load->library('form');
		$this->load->library("datagrid");
		$this->load->model("M_Action");
		$this->load->library('pagination');
		
		$field = new FormField();
		$field->type = Form::CHECKBOX;
		$field->name = "action_id";
		$field->value = array("");
		$field->attributes = array("class"=> "check_uncheck_all");
		$checkbox = $this->form->renderField($field);
		
		// SELECT ALL CHECKBOX
		$this->datagrid->addColumn($checkbox, function($row){
				$field = new FormField();
				$field->type = Form::CHECKBOX;
				$field->name = "action_id[]";
				$field->value = array($row[dbAction::ID]=>"");
				$field->attributes = array("class"=> "check_field");
				
				$label1 = $this->form->renderField($field);
				return $label1;
			}, Datagrid::CALLBACK);

		// ACTIONS
		$this->datagrid->addColumn("Actions", function($row) {
				$html = "";
				$html .= gridEdit(backendUrl(getActionUrlWithID(UserAction::EDITACTION, $row[dbAction::ID])));
				if(validateAction(UserAction::DELACTION)) { 
					$html .= gridDelete($row[dbAction::ID]);
				}
				return $html;  
			}, Datagrid::CALLBACK);
		
		// DATA COLUMNS
		$this->datagrid->addColumn("Action Name", function($row){
				if(validateAction(UserAction::EDITACTION)) { 
					return '<a href="'.backendUrl(getActionUrlWithID(UserAction::EDITACTION, $row[dbAction::ID])).'"><span id="name'.$row[dbAction::ID].'">'.$row[dbAction::NAME].'</span></a>';
				} else {
					return $row[dbAction::NAME];
				}
			}, Datagrid::CALLBACK);
		$this->datagrid->addColumn("Controller", dbAction::CONTROLLER_NAME);
		$this->datagrid->addColumn("Function", dbAction::FUNCTION_NAME);
		$this->datagrid->addColumn("UI", dbUI::NAME);		
		
		// NEED TO SET BASE URL AND PAGE NO URI SEGMENTS
		$config['base_url'] = backendUrl(getActionUrl(UserAction::LISTACTION));
		$config['total_rows'] = $this->M_Action->count_rows();
		$config['attributes'] = array('class' => 'btn btn-default');
		$config['per_page'] = ProjectENUM::ROWS_TO_SHOW;
    	$config['use_page_numbers'] = TRUE;
		$config['reuse_query_string'] = TRUE;
		$config['cur_tag_open'] = '<span class="btn btn-default">';
		$config['cur_tag_close'] = '</span>';
		if($this->uri->segment(4)) {
			$page = ($this->uri->segment(4)) ;
		} else {
			$page = 1;
		}		
		$this->pagination->initialize($config);

		$action_data = $this->M_Action->get_rows('', $config['per_page'], $config['per_page']*($page-1));
		$this->datagrid->setData($action_data);

		$data['module'] = 'action';
		$data['page_title'] = 'Manage Actions';
		$this->template->set_title($data['page_title']);
		$this->template->load("common/pagedlist", $data);
	}

	public function view() {		
		$data['title'] = 'Action Detail';
		$data['module'] = 'action';
		$this->template->load('action/view_action', $data);
	}

	public function status($id, $status) {
		$id = (int) $id;
		$_POST[dbAction::STATUS] = (int) $status;
		if($this->M_Action->update($id))
			set_message('success', 'success');
		else
			set_message('error', 'error');
		redirect(backendUrl("action/manage"));
	}

	public function delete($id) {		
		$id = (int) $id;
		if($this->M_Action->delete($id))
			set_message('success', 'success');
		else
			set_message('error', 'error');
		redirect(backendUrl("action/manage"));
	}
}