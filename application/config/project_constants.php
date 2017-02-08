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
}

/**************** Database Tables ENUMS******************************/

abstract class DB_Table {
	const ACTION = "action";
	const ROLE = "role";
	const ROLE_ACTION = "role_action_mapping";
    const BUSINESS = "business";
    const USER = "user";
    const ADDRESS = "address";
}

/**************** Messages Type ENUMS *************************/

abstract class MessageType {
    const ERROR = 0;
    const WARNING = 1;
    const SUCCESS = 2;
    const INFO = 3;
}

/**************** User Type ENUMS *************************/

abstract class UserType {
    const ADMIN = 1;
	const ENDUSER = 2;
}

/**************** User Role ENUMS *************************/

abstract class UserRole {
	const ANNONYMOUS = 3;
    const ADMIN = 1;
	const ENDUSER = 2;
}

/**************** User Action ENUMS *************************/

abstract class UserAction {
	const NONE = 0;
    const SIGNIN = 3301;
	const SIGNUP = 3302;
}

/**************** URL ENUMS *************************/

abstract class URL {
	const BACKEND = "backend";
}