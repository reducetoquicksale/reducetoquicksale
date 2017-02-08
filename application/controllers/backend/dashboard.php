<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function Dashboard() {
		parent::__construct();
		validateUserLogin();
		//$this->load->model('m_role');
	}

	public function index() {
		global $calledController; 
		$data["title"] = $calledController = "Dashboard";

		$oUser = getLoggedUser();
		if($oUser->user_role_id != EMP_ROLE_DRIVER && $oUser->user_ref_type != USER_REF_TYPE_CUSTOMER && $oUser->user_ref_type != USER_REF_TYPE_CARRIER) {
			$arrToolbar = array();
			$arrToolbar[] = array("controller"=>"employee",
									"function"=>"pagedlist",
									"text"=>"Employee List",
									"attributes" => array("class"=>"btn-green")
								);

			$arrToolbar[] = array("controller"=>"Customer",
									"function"=>"pagedlist",
									"text"=>"Customer List",
									"attributes" => array("class"=>"btn-green")
								);


			$arrToolbar[] = array("controller"=>"account",
									"function"=>"Receivables",
									"text"=>"Receivables",
									"attributes" => array("class"=>"btn-green")
								);

			$arrToolbar[] = array("controller"=>"account",
									"function"=>"payables",
									"text"=>"Payables",
									"attributes" => array("class"=>"btn-green")
								);

			$data["buttons"] = $arrToolbar;
			$data["title"] = "Dashboard";
			$this->template->load('dashboard', $data);
		} else {
			if($oUser->user_role_id == EMP_ROLE_DRIVER) {
				$this->driver($data);
			} else if($oUser->user_ref_type == USER_REF_TYPE_CUSTOMER) {
				$this->customer($data);
			} else if($oUser->user_ref_type == USER_REF_TYPE_CARRIER) {
				$this->template->load('dashboard-carrier', $data);
			}
		}
	}

	function driver($data) {
		$oUser = getLoggedUser();
		if(isset($_GET["load_status"])) {
			$data["load_status"] = $load_status = $_GET["load_status"];
		} else {
			$data["load_status"] = $load_status = LOAD_STATUS_ASSIGNED;
		}
		$this->m_core->table = T_LOAD;
		$this->m_core->data_only = FALSE;
		$this->m_core->use_pagination = TRUE;
		$this->m_core->use_join = TRUE;
		$this->m_core->join = "	LEFT JOIN ".T_LOAD_TRACKING." AS LT1 ON LT1.load_ref_id = ".T_LOAD.".load_id AND LT1.load_status = ".LOAD_STATUS_ASSIGNED." 
								LEFT JOIN ".T_LOAD_TRACKING." AS LT2 ON LT2.load_ref_id = ".T_LOAD.".load_id AND LT2.load_status = ".LOAD_STATUS_PICK_UP." 
								LEFT JOIN ".T_LOAD_TRACKING." AS LT3 ON LT3.load_ref_id = ".T_LOAD.".load_id AND LT3.load_status = ".LOAD_STATUS_DELIVERED."
								LEFT JOIN ".T_DISPATCH." AS D1 ON D1.load_ref_id = ".T_LOAD.".load_id AND D1.driver1_id = ".$oUser->user_ref_id."
								LEFT JOIN ".T_SUBREGION." AS FS1 ON FS1.id = D1.driver1_from_state_id
								LEFT JOIN ".T_SUBREGION." AS TS1 ON TS1.id = D1.driver1_to_state_id
								LEFT JOIN ".T_DISPATCH." AS D2 ON D2.load_ref_id = ".T_LOAD.".load_id AND D2.driver2_id = ".$oUser->user_ref_id."
								LEFT JOIN ".T_SUBREGION." AS FS2 ON FS2.id = D2.driver2_from_state_id
								LEFT JOIN ".T_SUBREGION." AS TS2 ON TS2.id = D2.driver2_to_state_id
								LEFT JOIN ".T_DISPATCH." AS D3 ON D3.load_ref_id = ".T_LOAD.".load_id AND D3.driver3_id = ".$oUser->user_ref_id."
								LEFT JOIN ".T_SUBREGION." AS FS3 ON FS3.id = D3.driver3_from_state_id
								LEFT JOIN ".T_SUBREGION." AS TS3 ON TS3.id = D3.driver3_to_state_id
								LEFT JOIN ".T_STOP." AS S1 ON S1.stop_load_ref_id = ".T_LOAD.".load_id AND S1.stop_pn = 1 AND S1.stop_rpn = 0 
								LEFT JOIN ".T_STOP." AS S2 ON S2.stop_load_ref_id = ".T_LOAD.".load_id AND S1.stop_pn = 1 AND S2.stop_pn = 0 ";

		$columns = T_LOAD.".*,
					LT1.loc_date AS assign_date, 
					LT1.loc_time AS assign_time,
					LT2.loc_date AS act_pickup_date, 
					LT2.loc_time AS act_pickup_time,
					LT3.loc_date AS act_drop_date, 
					LT3.loc_time AS act_drop_time,
					D1.driver1_id, D1.driver1_from_city, FS1.name AS driver1_from_state, D1.driver1_to_city, TS1.name AS driver1_to_state,
					D2.driver2_id, D2.driver2_from_city, FS2.name AS driver2_from_state, D2.driver2_to_city, TS2.name AS driver2_to_state,
					D3.driver3_id, D3.driver3_from_city, FS3.name AS driver3_from_state, D3.driver3_to_city, TS3.name AS driver3_to_state,
					S1.stop_date AS pickup_date, S1.stop_time AS pickup_time,
					S2.stop_date AS drop_date, S2.stop_time AS drop_time ";

		if(isset($_GET["filter"]) && $_GET["filter"] != "") {
			$where = array(T_LOAD.".load_id"=>$_GET["filter"]);
		} else if($load_status != LOAD_STATUS_ASSIGNED && $load_status != LOAD_STATUS_DELIVERED) {
			$where = array(T_LOAD.".load_status!"=>LOAD_STATUS_ASSIGNED, T_LOAD.".load_status !"=>LOAD_STATUS_DELIVERED);
		} else {
			$where = array(T_LOAD.".load_status"=>$load_status);
		}	
					
		$this->m_core->filters = " GROUP BY ".T_LOAD.".load_id, D1.driver1_id, D2.driver2_id, D3.driver3_id ";
		$this->m_core->filters .= get_order_filters();

		if($this->m_core->listing($columns, $where)) {
			$data["pagedList"] = $this->m_core->class_data;
			if(isset($_GET["filter"]) && $_GET["filter"] != "") { 
				$data["load_status"] = $this->m_core->class_data[0]["load_status"];
			}
		}
		$this->m_core->filters = "";

		$arrToolbar = array();
		$arrToolbar[] = array("controller"=>"dashboard",
								"function"=>"",
								"text"=>"Newly Assigned Loads",
								"attributes" => array("class"=>"btn-green"),
								"validateLink"=>FALSE
							);

		$arrToolbar[] = array("controller"=>"dashboard",
								"function"=>"",
								"text"=>"In Process",
								"attributes" => array("class"=>"btn-green"),
								"validateLink"=>FALSE,
								"query_string"=>"load_status=".LOAD_STATUS_PICK_UP
							);


		$arrToolbar[] = array("controller"=>"dashboard",
								"function"=>"",
								"text"=>"Delivered Loads",
								"attributes" => array("class"=>"btn-green"),
								"validateLink"=>FALSE,
								"query_string"=>"load_status=".LOAD_STATUS_DELIVERED
							);

		$data["buttons"] = $arrToolbar;
		$this->template->load('dashboard-driver', $data);
	}

	function customer($data) {
		$oUser = getLoggedUser();
		
		$this->m_core->table = T_LOAD;
		$this->m_core->data_only = FALSE;
		$this->m_core->use_pagination = TRUE;
		$this->m_core->use_join = TRUE;
		$this->m_core->join = "	LEFT JOIN ".T_LOAD_TRACKING." AS LT1 ON LT1.load_ref_id = ".T_LOAD.".load_id AND LT1.load_status = ".T_LOAD.".load_status
								LEFT JOIN ".T_SUBREGION." AS LL ON LL.id =  LT1.loc_state_id
								LEFT JOIN ".T_LOAD_TRACKING." AS LT2 ON LT2.load_ref_id = ".T_LOAD.".load_id AND LT2.load_status = ".LOAD_STATUS_PICK_UP." 
								LEFT JOIN ".T_LOAD_TRACKING." AS LT3 ON LT3.load_ref_id = ".T_LOAD.".load_id AND LT3.load_status = ".LOAD_STATUS_DELIVERED."
								LEFT JOIN ".T_STOP." AS S1 ON S1.stop_load_ref_id = ".T_LOAD.".load_id AND S1.stop_pn = 1 AND S1.stop_rpn = 0 
								LEFT JOIN ".T_STOP." AS S2 ON S2.stop_load_ref_id = ".T_LOAD.".load_id AND S1.stop_pn = 1 AND S2.stop_pn = 0  
								LEFT JOIN ".T_LOCATION." AS L1 ON L1.loc_id = S1.stop_loc_id 
								LEFT JOIN ".T_SUBREGION." AS R1 ON R1.id =  L1.loc_state_id 
								LEFT JOIN ".T_REGION." AS ST1 ON ST1.id = R1.region_id 
								LEFT JOIN ".T_LOCATION." AS L2 ON L2.loc_id = S2.stop_loc_id 
								LEFT JOIN ".T_SUBREGION." AS R2 ON R2.id =  L2.loc_state_id 
								LEFT JOIN ".T_REGION." AS ST2 ON ST2.id = R2.region_id ";

		$columns = T_LOAD.".*,
					L1.loc_name AS origin_loc, 
					L1.loc_city AS origin_city,
					CONCAT(R1.name, '(', ST1.iso, ')') AS origin_state, 
					L2.loc_name AS destination_loc, 
					L2.loc_city AS destination_city,
					CONCAT(R2.name, '(', ST2.iso, ')') AS destination_state,
					LT1.loc_city AS last_loc_city,
					LL.name AS last_loc_state,
					LT1.loc_date AS last_loc_date, 
					LT1.loc_time AS last_loc_time,
					LT2.loc_date AS act_pickup_date, 
					LT2.loc_time AS act_pickup_time,
					LT3.loc_date AS act_drop_date, 
					LT3.loc_time AS act_drop_time ";

		
		$where = array();
		$where[] = " load_customer_id = ".$oUser->user_ref_id." ";
		if(isset($_GET["search"])) {
			if(isset($_GET["load_ref_hash"])&& $_GET["load_ref_hash"] != "") {
				$where[] = " ( load_ref_hash = '".$_GET["load_ref_hash"]."' )";
			}
			if(isset($_GET["load_id"])&& $_GET["load_id"] != "") {
				$where[] = " ( load_id = '".$_GET["load_id"]."' )";
			}
			
			if(isset($_GET["load_container_num"])&& $_GET["load_container_num"] != "") {
				$where[] = " ( load_container_num LIKE('".$_GET["load_container_num"]."%') )";
			}

			if(isset($_GET["load_status"])) {
				if($_GET["load_status"] == LOAD_STATUS_DELIVERED) {
					$where[] = " ".T_LOAD.".load_status = ".LOAD_STATUS_DELIVERED." ";
				} else {
					$where[] = " ".T_LOAD.".load_status != ".LOAD_STATUS_DELIVERED." ";
				}
			}

			if(isset($_GET["from_date"]) && $_GET["from_date"]  != "" && isset($_GET["to_date"]) && $_GET["to_date"]  != "") {
				$where[] = " ( LT3.loc_date between ".(strtotime($_GET["from_date"]))." AND ".(strtotime($_GET["to_date"]) + 86399).") ";
			} else if(isset($_GET["from_date"]) && $_GET["from_date"]  != "") {
				$where[] = " ( LT3.loc_date >= ".(strtotime($_GET["from_date"]))." )";
			} else if(isset($_GET["to_date"]) && $_GET["to_date"]  != "") {
				$where[] = " ( LT3.loc_date <= ".(strtotime($_GET["to_date"]) + 86399)." )";
			}
			
		}
		$where = implode(" AND ",$where);
					
		$this->m_core->filters = " GROUP BY ".T_LOAD.".load_id ";
		$this->m_core->filters .= get_order_filters();

		if($this->m_core->listing($columns, $where)) {
			$data["pagedList"] = $this->m_core->class_data;
		}
		$this->m_core->filters = "";
		
		$this->template->add_script("js/jquery-ui/jquery-ui.js");
		$this->template->add_css("js/jquery-ui/jquery-ui.css");
		$this->template->load('dashboard-customer', $data);
	}

	function track_load() {
		if(isset($_GET["load_id"])) {
			extract($_GET);	
		} else {
			redirect("dashboard");
		}
		
		$this->load->model("m_load");
		$this->m_load->data_only = FALSE;
		$this->m_load->use_join = TRUE;
		$this->m_load->join = " LEFT JOIN ".T_SUBREGION." ON ".T_SUBREGION.".id =  ".T_LOAD_TRACKING.".loc_state_id LEFT JOIN ".T_REGION." ON ".T_REGION.".id =  ".T_SUBREGION.".region_id ";
		if($this->m_load->tracking_listing(" concat(".T_SUBREGION.".name, ' (', ".T_REGION.".iso, ')') AS state, ".T_LOAD_TRACKING.".* ", array(T_LOAD_TRACKING.".load_ref_id" => $load_id))) {
			$data["pagedList"] = $this->m_load->class_data;
		}

		$data["title"] = "Load Tracking";
		$this->template->load("track_load", $data);
	}
}