<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class gridColumn {
		var $name, $DBfield, $sortOrder;

		function __construct($name, $DBfield = "", $sortOrder = null) {
			$this->name = $name;
			$this->DBfield = $DBfield;
			$this->sortOrder = $sortOrder;
		}
	}

	class Grid {

		var $showCheckbox, $showLinks;
		private $arrColumn, $arrData, $id_field, $arrAction;
		function __construct(){
			$this->CI =& get_instance();
			$this->arrColumn = array();
			$this->arrData = array();
			$this->id_field = "";
			$this->showCheckbox = TRUE;
			$this->showLinks = TRUE;
			$this->arrAction  = array();
		}

		public function addColumn(gridColumn $column){
			$this->arrColumn[] = $column;
		}

		public function setData($data){
			$this->arrData = $data;
		}

		public function setID_field($id_field){
			$this->id_field = $id_field;
		}

		public function getID_field(){
			return $this->id_field;
		}

		public function addAction(Array $arrAction){
			$this->arrAction = array_merge($this->arrAction, $arrAction);
		}

		public function getAction(){
			return $this->arrAction;
		}

		public function renderGrid() {
			$data['showCheckbox']	= $this->showCheckbox;
			$data['showLinks']		= $this->showLinks;
			$data['id_field']		= $this->getID_field();
			$data['arrColumn']		= $this->arrColumn;
			$data['arrData']		= $this->arrData;
			$this->CI->template->load("grid", $data, TPLFile::BLANK);
		}
	}

?>