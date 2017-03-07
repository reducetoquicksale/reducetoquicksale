<?php
class M_Action extends M_Core
{
	function M_Action() { parent::__construct(); }

	function pagedList() {
		$this->use_pagination = TRUE;
		$this->data_only = FALSE;
		if($this->select(DB_Table::ACTION, "*")) {
			$arrAction = array();
			foreach($this->result as $row) {
				$arrAction[] = arrayToClassObj(new DBAction(), $row);
			}
			return $arrAction;
		} else {

		}
	}
}