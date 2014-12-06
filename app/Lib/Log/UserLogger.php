<?php

App::uses('CakeLogInterface', 'Log');
App::uses('ClassRegistry', 'Utility');

class UserLogger {
    public static $log = null;

    public static function write($message) {
    	if (!self::$log) {
        	self::$log = ClassRegistry::init("UserLog");
        }

        self::$log->save($message);
    }
}