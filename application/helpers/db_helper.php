<?php

abstract class dbUser{
	const TABLE = 'user';
    const ID = 'id';							// PRIMARY
    const LOGIN_ID = 'user_name';
    const PASSWORD = 'password';
    const EMAIL = 'email';
    const REFERENCE_TYPE = 'ref_type';
    const ROLE_ID = dbRole::ID;
    const LAST_LOGIN = 'last_login_timestamp';
    const STATUS = 'status';
    const IS_SUPER = 'is_super';
    const ADDED_BY_USER = 'added_by';
    const ADD_TIME = 'add_timestamp';
    const UPDATE_BY_USER = 'updated_by';
    const UPDATE_TIME = 'update_timestamp';
	
	/*
	static function dbJoin(){
		$j = array();
		if(class_exists('dbBinary'))
			$j[] = array(dbBinary::TABLE, dbUser::TABLE.".".dbUser::ID."=".dbBinary::TABLE.".".dbBinary::USER_ID);
		return $j;
	}
	*/
}

abstract class dbRole{
    const TABLE = 'role';
    const ID = 'role_id';					// PRIMARY
    const NAME = 'role_name';
}

abstract class dbAction{
    const TABLE = 'action';
	const ID = 'action_id';					// PRIMARY
	const NAME = 'action_name';
	const CONTROLLER_NAME = 'controller';
	const FUNCTION_NAME = 'function';
	const MODULE = 'module';
    const ADDED_BY_USER = 'added_by';
    const ADD_TIME = 'add_timestamp';
    const UPDATE_BY_USER = 'updated_by';
    const UPDATE_TIME = 'update_timestamp';
}

abstract class dbRoleActionMapping{
    const TABLE = 'role_action_mapping';
	const ROLE_ID = dbRole::ID;
	const ACTION_ID = dbAction::ID;
}
