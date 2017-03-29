<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*abstract class BasicEnum {
    private static $constCacheArray = NULL;

    private static function getConstants() {
        if (self::$constCacheArray == NULL) { self::$constCacheArray = []; }
        $calledClass = get_called_class();
        if (!array_key_exists($calledClass, self::$constCacheArray)) {
            $reflect = new ReflectionClass($calledClass);
            self::$constCacheArray[$calledClass] = $reflect->getConstants();
        }
        return self::$constCacheArray[$calledClass];
    }

    public static function isValidName($name, $strict = false) {
        $constants = self::getConstants();
        if ($strict) { return array_key_exists($name, $constants); }
        $keys = array_map('strtolower', array_keys($constants));
        return in_array(strtolower($name), $keys);
    }

    public static function isValidValue($value) {
        $values = array_values(self::getConstants());
        return in_array($value, $values, $strict);
    }
}*/

/**************** Project ENUMS******************************/

abstract class ProjectENUM {
    const APPLICATION_TITLE = "Reduce To Quick Sale";
    const USER_SESSION_NAME = "ReduceToQuickSale";
    const CURRENCY_SIGN = "$";
    const ROWS_TO_SHOW = 10;
	const RETURN_URL = "return_url";
}

/**************** User Interface ENUMS *************************/

abstract class UI {
    const BACKEND = 1;
    const FRONTEND = 2;
}

/**************** Messages Type ENUMS *************************/

abstract class MessageType {
    const ERROR = "error";
    const WARNING = "warning";
    const SUCCESS = "success";
    const INFO = "information";
}

/**************** User Type ENUMS *************************/

abstract class UserType {
    const ADMIN = 1;
	const ENDUSER = 2;
	const ANNONYMOUS = 3;
}

/**************** User Role ENUMS *************************/

abstract class UserRole {
    const ADMIN = 1;
	const ENDUSER = 2;	
	const ANNONYMOUS = 3;
}

/**************** User Action ENUMS *************************/

abstract class UserAction {
	const NONE = 0;

    const SIGNIN	= 3301;
	const SIGNUP	= 3302;
	const DASHBOARD = 3303;
	const LOGOUT	= 3304;

	const ADDACTION		= 3401;
	const EDITACTION	= 3402;
	const LISTACTION	= 3403;
	const DELACTION		= 3404;

	const ADDROLE		= 3501;
	const EDITROLE		= 3502;
	const LISTROLE		= 3503;
	const DELROLE		= 3504;
}

/**************** URL ENUMS *************************/

abstract class URL {
	const BACKEND = "backend";
}