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
		if($edit_call){
			$where = dbAction::ID."='$id'";
			$rows = $this->M_Action->count_rows($where);
			if($rows < 1){
				set_message('error', 'Action not found');
				redirect(base_url(URL::BACKEND.'/action/manage'));
			}
			$res = $this->M_Action->get_rows($where);
			$action_data = $res[0];
		}
		
		$this->load->library('form');
		$this->form->config(array('template_path'=>'backend/form_template'));
		
		$field = new stdClass();
		$field->type = Form::TEXT;
		$field->name = dbAction::NAME;
		$field->label = "Action Name";
		if($edit_call){
			$field->attributes = array("readonly"=> "readonly");
			$field->value = $action_data[dbAction::NAME];
		}
		$field->validation = "required";
		$this->form->addFormField($field);
		
		$field = new stdClass();
		$field->type = Form::TEXT;
		$field->name = dbAction::CONTROLLER_NAME;
		$field->label = "Controller Name";
		if($edit_call){
			$field->value = $action_data[dbAction::CONTROLLER_NAME];
		}
		$field->validation = "required";
		$this->form->addFormField($field);
		
		$field = new stdClass();
		$field->type = Form::TEXT;
		$field->name = dbAction::FUNCTION_NAME;
		$field->label = "Function Name";
		if($edit_call){
			$field->value = $action_data[dbAction::FUNCTION_NAME];
		}
		$field->validation = "required";
		$this->form->addFormField($field);
		
		$field = new stdClass();
		$field->type = Form::TEXT;
		$field->name = dbAction::MODULE;
		$field->label = "Module";
		if($edit_call){
			$field->value = $action_data[dbAction::MODULE];
		}
		$field->validation = "required";
		$this->form->addFormField($field);
		
		$field = new stdClass();
		$field->type = Form::SUBMIT;
		$field->name = "save";
		$field->value = "Add Action";
		if($edit_call){
			$field->value = "Update Action";
		}
		$field->attributes = array(
								'class' => "btn-primary"
							);
		$this->form->addFormField($field);
		
		if(isset($_POST['save'])){
			if($this->form->validateForm()){
				if($edit_call)
					$action_id = $this->M_Action->update($id);
				else
					$action_id = $this->M_Action->add();
				if($action_id){
					set_message('success', 'success');
					redirect(backendUrl("action/add"));
				}
				else{
					set_message('message', 'message');
				}
			}
		}
		
		$main_data['module'] = 'action';
		$main_data['page_title'] = 'Add Action';
		if($edit_call)
			$main_data['page_title'] = 'Update Action';
		$this->template->set_title($main_data['page_title']);
		$this->template->load('common/add', $main_data);
	}
	public function manage() {
		//validateActionAccess($this, true);
		$this->load->library('form');
		$this->load->library("datagrid");
		$this->load->model("M_Action");
		
		$field = new stdClass();
		$field->type = Form::CHECKBOX;
		$field->name = "action_id";
		$field->value = array(1=>"");
		$field->attributes = array("class"=> "check_uncheck_all");
		$checkbox = $this->form->renderField($field);
		
		// SELECT ALL CHECKBOX
		$this->datagrid->addColumn($checkbox, function($row){
				$field = new stdClass();
				$field->type = Form::CHECKBOX;
				$field->name = "action_id[]";
				$field->value = array($row[dbAction::ID]=>"");
				$field->attributes = array("class"=> "check_field");
				
				$label1 = $this->form->renderField($field);
				return $label1;
			}, Datagrid::CALLBACK);
		// DATA COLUMNS
		$this->datagrid->addColumn("Action Name", function($row){
				return '<a href="'.base_url().'"><span id="name'.$row[dbAction::ID].'">'.$row[dbAction::NAME].'</span></a>';
			}, Datagrid::CALLBACK);
		$this->datagrid->addColumn("Controller", dbAction::CONTROLLER_NAME);
		$this->datagrid->addColumn("Function", dbAction::FUNCTION_NAME);
		// ACTIONS
		$this->datagrid->addColumn("Actions", function($row){
				$html = "";
				$html .= ' <a class="btn btn-success btn-xs" href="'.backendUrl('action/edit/'.$row[dbAction::ID]).'" title="Edit"><i class="fa fa-pencil "></i></a>';
				$html .= ' <button class="btn btn-danger btn-xs" title="Delete" data-toggle="modal" data-target="#deleteModal" id="'.$row[dbAction::ID].'"><span data-href="action/delete"><i class="fa fa-trash-o "></i></span></button>';
				return $html;
			}, Datagrid::CALLBACK);
		
		$total_rows = $this->M_Action->count_rows();
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
		$action_data = $this->M_Action->get_rows('', $config['per_page'], $config['per_page']*($page-1));
		
		$this->pagination->initialize($config);
		$this->datagrid->setData($action_data);

		$data['module'] = 'action';
		$data['page_title'] = 'Manage Actions';
		$this->template->set_title($data['page_title']);
		$this->template->load("common/pagedlist", $data);
	}

	public function view() {
		validateActionAccess($this, true);
		
		$data['title'] = 'Action Detail';
		$data['module'] = 'action';
		$this->template->load('action/view_action', $data);
	}

	public function status($id, $status) {
		validateActionAccess($this, true);
		
		$id = (int) $id;
		$_POST[dbAction::STATUS] = (int) $status;
		if($this->M_Action->update($id))
			set_message('success', 'success');
		else
			set_message('error', 'error');
		redirect(backendUrl("action/manage"));
	}

	public function delete($id) {
		validateActionAccess($this, true);
		
		$id = (int) $id;
		if($this->M_Action->delete($id))
			set_message('success', 'success');
		else
			set_message('error', 'error');
		redirect(backendUrl("action/manage"));
	}
}