<?php
 
abstract class dbBase {
    const ADDED_BY_USER = 'added_by';
    const ADD_TIME = 'add_timestamp';
    const UPDATE_BY_USER = 'updated_by';
    const UPDATE_TIME = 'update_timestamp';	
	const STATUS = 'status';
}

abstract class dbUser extends dbBase {
	const TABLE = 'user';
    const ID = 'id';							// PRIMARY
    const LOGIN_ID = 'user_name';
    const PASSWORD = 'password';
    const EMAIL = 'email';
    const REFERENCE_TYPE = 'ref_type';
    const ROLE_ID = dbRole::ID;
    const LAST_LOGIN = 'last_login_timestamp';
    const IS_SUPER = 'is_super';
}

abstract class dbRole extends dbBase {
    const TABLE = 'role';
    const ID = 'role_id';					// PRIMARY
    const NAME = 'role_name';
}

class dbAction extends dbBase {
    const TABLE = 'action';
	const ID = 'action_id';					// PRIMARY
	const NAME = 'action_name';
	const CONTROLLER_NAME = 'controller';
	const FUNCTION_NAME = 'function';
	const UI_ID = 'ui_id';

	static function dbJoin(){
		$j = array();
		$j[] = array(dbUI::TABLE, dbAction::TABLE.".".dbAction::UI_ID."=".dbUI::TABLE.".".dbUI::ID);
		return $j;
	}
}

abstract class dbRoleActionMapping extends dbBase {
    const TABLE = 'role_action_mapping';
	const ROLE_ID = dbRole::ID;
	const ACTION_ID = dbAction::ID;
}


class dbUI extends dbBase {
    const TABLE = 'userinterface';
    const ID = 'ui_id';					// PRIMARY
    const NAME = 'name';
	const URL = 'url';
}