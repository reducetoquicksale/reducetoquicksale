<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//global $transaction_type, $property_type, $area_unit, $amenities, $age_of_construction, $time_of_possession;

class Global_variables{
	
	public $user_ref_type, $emp_type, $emp_legal_status, $status, $state, $insurance_type, $equipment_type, $load_type, $load_commodity, $load_status, $invoice_status, $links, $transaction_type;

	public $ref_account, $financial_account, $taxline_mapping, $arrDefRefAccounts;
	
	function __construct(){

		/**************** User Refference Types ************************/

		define("USER_REF_TYPE_ADMIN", 1);
		define("USER_REF_TYPE_EMPLOYEE", 2);
		define("USER_REF_TYPE_CUSTOMER", 3);
		define("USER_REF_TYPE_CARRIER", 4);

		define("EMP_ROLE_DRIVER", 3);
		define("EMP_ROLE_DISPATCHER", 5);
		
		define("REF_TYPE_EQUIPMENT", 21);
		define("REF_TYPE_ACCOUNT", 22);

		$this->user_ref_type = array(USER_REF_TYPE_ADMIN => "Admin",
									USER_REF_TYPE_EMPLOYEE => "Employee",
									USER_REF_TYPE_CUSTOMER => "Customer",
									USER_REF_TYPE_CARRIER => "Carrier" );

		/**************** User Refference Types Ends ********************/

		/**************** Employee Types ************************/

		define("EMPLOYEE_TYPE_W2", 1);
		define("EMPLOYEE_TYPE_CONTRACTOR", 2);
		define("EMPLOYEE_TYPE_PARTTIME", 3);

		$this->emp_type = array(EMPLOYEE_TYPE_W2 => "W2",
									EMPLOYEE_TYPE_CONTRACTOR => "Contractor (1099)",
									EMPLOYEE_TYPE_PARTTIME => "Part Time");

		/**************** Employee Types Ends************************/

		/**************** Employee Legal Status ************************/

		define("EMPLOYEE_LEGAL_STATUS_CITIZEN", 1);
		define("EMPLOYEE_LEGAL_STATUS_RESIDENT", 2);
		define("EMPLOYEE_LEGAL_STATUS_WORK_PERMIT", 3);

		$this->emp_legal_status = array(EMPLOYEE_LEGAL_STATUS_CITIZEN => "Citizen",
									EMPLOYEE_LEGAL_STATUS_RESIDENT => "Resident Alien",
									EMPLOYEE_LEGAL_STATUS_WORK_PERMIT => "Work Permit");

		/**************** Employee Legal Status Ends************************/

		/**************** Status ************************/

		define("STATUS_ENABLE", 1);
		define("STATUS_DISABLE", 0);

		$this->status = array(STATUS_ENABLE => "Active",
									STATUS_DISABLE => "Deactive");

		/**************** Status Ends************************/

		/**************** Status ************************/

		define("STATE_ASSIGNED", 1);
		define("STATE_UNASSIGNED", 0);

		$this->state = array(STATE_ASSIGNED => "Assigned",
									STATE_UNASSIGNED => "Unassigned");

		/**************** Status Ends************************/

		/**************** Insurance Types ************************/

		define("INSURANE_TYPE_LIABILITY", 1);
		define("INSURANE_TYPE_CARGO", 2);
		define("INSURANE_TYPE_GENERAL", 3);
		define("INSURANE_TYPE_WORKMAN", 4);
		define("INSURANE_TYPE_PHYSICAL", 5);

		$this->insurance_type = array(INSURANE_TYPE_LIABILITY => "Liability Insurance",
									INSURANE_TYPE_CARGO => "Cargo Insurance",
									INSURANE_TYPE_GENERAL => "General Liability Insurance",
									INSURANE_TYPE_WORKMAN => "Workman Comp. Insurance",
									INSURANE_TYPE_PHYSICAL => "Physical Insurance");

		/**************** Insurance Types Ends ********************/

		/**************** Equipment Types ************************/

		define("EQUIPMENT_TYPE_TRACTOR", 1);
		define("EQUIPMENT_TYPE_TRAILOR", 2);		

		$this->equipment_type = array(EQUIPMENT_TYPE_TRACTOR => "Tractor",
									EQUIPMENT_TYPE_TRAILOR => "Trailor");

		/**************** Equipment Types Ends ********************/

		/**************** Load Types ************************/

		define("LOAD_TYPE_REFER", 1);
		define("LOAD_TYPE_CONTAINER", 2);
		/*define("LOAD_TYPE_VAN", 3);
		define("LOAD_TYPE_FLATBED", 4);
		define("LOAD_TYPE_OTHER", 5);*/

		$this->load_type = array(LOAD_TYPE_REFER => "Refer",
									LOAD_TYPE_CONTAINER => "Container"/*,
									LOAD_TYPE_VAN => "Van",
									LOAD_TYPE_FLATBED => "Flatbed",
									LOAD_TYPE_OTHER => "Other"*/);

		/**************** Load Types Ends ********************/

		/**************** Load Commodities ************************/

		define("LOAD_COMODITY_CHILLED", 1);
		define("LOAD_COMODITY_DRY", 2);
		define("LOAD_COMODITY_FROZEN", 3);
		define("LOAD_COMODITY_PRODUCE", 4);
		define("LOAD_COMODITY_OTHER", 5);

		$this->load_commodity = array(LOAD_COMODITY_DRY => "Dry",
									LOAD_COMODITY_CHILLED => "Chilled",
									LOAD_COMODITY_FROZEN => "Frozen",
									LOAD_COMODITY_PRODUCE => "Produce",
									LOAD_COMODITY_OTHER => "Other");

		/**************** Load Commodities Ends ********************/

		/**************** Load Status ************************/

		define("LOAD_STATUS_UNASSIGNED", 1);
		define("LOAD_STATUS_ASSIGNED", 2);
		define("LOAD_STATUS_PICK_UP", 3);
		define("LOAD_STATUS_EN_ROUTE", 4);
		define("LOAD_STATUS_DROPPED", 5);
		define("LOAD_STATUS_EMPTY", 6);
		define("LOAD_STATUS_LOADED", 7);
		define("LOAD_STATUS_DELIVERED", 8);

		$this->load_status = array(LOAD_STATUS_UNASSIGNED => "Unassigned",
									LOAD_STATUS_ASSIGNED => "Assigned",
									LOAD_STATUS_PICK_UP => "Pick Up",
									LOAD_STATUS_EN_ROUTE => "En-Route",
									LOAD_STATUS_DROPPED => "Dropped",
									LOAD_STATUS_EMPTY => "Empty",
									LOAD_STATUS_LOADED => "Loaded",
									LOAD_STATUS_DELIVERED => "Delivered");

		/**************** Load Status Ends ********************/

		/**************** Invoice Status ************************/

		define("INVOICE_STATUS_OPEN", 0);
		define("INVOICE_STATUS_CLOSE", 1);

		$this->invoice_status = array(INVOICE_STATUS_OPEN => "Open",
									INVOICE_STATUS_CLOSE => "Close");

		/**************** Invoice Status Ends ********************/
		
		define("ADDRESS_TYPE_HOME", 1);
		define("ADDRESS_TYPE_CARRIER_PAYMENT", 2);

		define("LOC_TYPE_BILL_ONLY", 1);
		define("LOC_TYPE_SHIP_ONLY", 2);
		define("LOC_TYPE_BILL_SHIP", 3);

		/******************************************************************************/

			$this->links[] = array(""); 

		/******************************************************************************/

		define("TRANSACTION_TYPE_ENTRY", 0);
		define("TRANSACTION_TYPE_CREDIT", 1);
		define("TRANSACTION_TYPE_DEBIT", 2);

		define("TRANSACTION_MODE_RECEIVABLE", 1);
		define("TRANSACTION_MODE_PAYABLE", 2);

		define("TRANSACTION_FOR_CUSTOMER", 1);
		define("TRANSACTION_FOR_CARRIER", 2);
		define("TRANSACTION_FOR_EMPLOYEE", 3);
		define("TRANSACTION_FOR_TRIP_EXPENSES", 4);
		define("TRANSACTION_FOR_OTHER_PAYABLES", 5);
		define("TRANSACTION_FOR_CHASSIES_RENT", 6);

		$this->transaction_type = array(TRANSACTION_TYPE_ENTRY => "New Entry",
										TRANSACTION_TYPE_CREDIT => "Credit",
										TRANSACTION_TYPE_DEBIT => "Debit");

		define("TRANSACTION_PAGE_LIMIT", 20);



		/*define("ACCOUNT_TYPE_INCOME",				1);
		define("ACCOUNT_TYPE_EXPENSE",				2);
		define("ACCOUNT_TYPE_FIXED_ASSET",			3);
		define("ACCOUNT_TYPE_LOAN",					5);
		define("ACCOUNT_TYPE_CREDIT_CARD",			6);
		define("ACCOUNT_TYPE_EQUITY",				7);
		define("ACCOUNT_TYPE_ACCOUNT_RECEIVABLE",	8);
		define("ACCOUNT_TYPE_OTHER_CURRENT_ASSET",	9);
		define("ACCOUNT_TYPE_OTHER_ASSET",			10);
		define("ACCOUNT_TYPE_ACCOUNT_PAYABLE",		11);
		define("ACCOUNT_TYPE_OTHER_CURRENT_LIABILITY", 12);
		define("ACCOUNT_TYPE_LONG_TERM_LIABILITY",	13);
		define("ACCOUNT_TYPE_COST_OF_GOODS_SOLD",	14);
		define("ACCOUNT_TYPE_OTHER_INCOME",			15);
		define("ACCOUNT_TYPE_OTHER_EXPENSE",		16);

		$this->ref_account = array(	ACCOUNT_TYPE_INCOME					=> "Income",
									ACCOUNT_TYPE_EXPENSE				=> "Expense",
									ACCOUNT_TYPE_FIXED_ASSET			=> "Fixed Asset",
									ACCOUNT_TYPE_LOAN					=> "Loan",
									ACCOUNT_TYPE_CREDIT_CARD			=> "Credit Card",
									ACCOUNT_TYPE_EQUITY					=> "Equity",
									ACCOUNT_TYPE_ACCOUNT_RECEIVABLE		=> "Account Receivable",
									ACCOUNT_TYPE_OTHER_CURRENT_ASSET	=> "Other Current Asset",
									ACCOUNT_TYPE_OTHER_ASSET			=> "Other Asset",
									ACCOUNT_TYPE_ACCOUNT_PAYABLE		=> "Account Payable",
									ACCOUNT_TYPE_OTHER_CURRENT_LIABILITY=> "Other Current Liability",
									ACCOUNT_TYPE_LONG_TERM_LIABILITY	=> "Long Term Liability",
									ACCOUNT_TYPE_COST_OF_GOODS_SOLD		=> "Cost of Goods Sold",
									ACCOUNT_TYPE_OTHER_INCOME			=> "Other Income",
									ACCOUNT_TYPE_OTHER_EXPENSE			=> "Other Expense" );*/

		$this->ref_account = array();
		
		if(getLoggedUser() != "") {
			$CI = & get_instance();
			$CI->load->database();
			$CI->load->model("m_core");
			$CI->m_core->table = T_REF_ACCOUNT_TYPE;
			$CI->m_core->data_only = FALSE;
			$CI->m_core->use_join = FALSE;
			$CI->m_core->use_pagination = FALSE;
			if($CI->m_core->listing(NULL)){
				foreach($CI->m_core->class_data AS $temp) {
					$this->ref_account[$temp["id"]] = $temp["title"];
				}
			}
		}

		define("ACCOUNT_TYPE_BANK",					4);
		define("ACCOUNT_TYPE_VENDOR",				17);
		define("ACCOUNT_TYPE_CUSTOMER",				18);
		define("ACCOUNT_TYPE_EMPLOYEE",				19);
		define("ACCOUNT_TYPE_OTHERS",				20);
		
		$this->financial_account = array( ACCOUNT_TYPE_VENDOR			=> "Carrier",
									ACCOUNT_TYPE_CUSTOMER				=> "Customer",
									ACCOUNT_TYPE_EMPLOYEE				=> "Driver",
									ACCOUNT_TYPE_OTHERS					=> "Others");

		define("TAXLINE_MAPPING_UNASSIGNED", 0);
		$this->taxline_mapping = array(TAXLINE_MAPPING_UNASSIGNED => "Unassigned");

		define("ACCOUNT_TOLL_EXPENSES",  10);
		define("ACCOUNT_FUEL_EXPENSES",  11);
		define("ACCOUNT_OTHER_EXPENSES", 12);
		define("ACCOUNT_CHASSIS_RENT",   13);

		$this->arrDefRefAccounts = array(ACCOUNT_TOLL_EXPENSES, ACCOUNT_FUEL_EXPENSES, ACCOUNT_OTHER_EXPENSES, ACCOUNT_CHASSIS_RENT);
	}
	
	function get_global_variable($name)
	{
		return $$name;	
	}
}