<?php
require_once dirname(__FILE__) . "/../../config/conf.php";

/**
 *
 */
class Route extends App {
	private static $ctrl;
	private static $fn;
	private static $pg;

	function __construct() {

	}

	public static function process() {
		$url = explode('/', preg_replace('/^(\/)/', '', Req::get('route')));
		if (isset($url[0]) && !$url[0] == '') {
			self::$ctrl = $url[0];
		} else {
			self::$ctrl = 'CIndex';
		}
		if (isset($url[1]) && !$url[1] == '') {
			self::$fn = $url[1];
		} else {
			self::$fn = 'index';
		}
	}

	public static function getController() {
		self::process();
		return self::$ctrl;
	}

	public static function getFunction() {
		self::process();
		return self::$fn;
	}

	private function newController() {
		self::process();
		return new self::$ctrl;
	}

	public function redirect($url) {
		return "<script>window.location = '$url';</script>";
	}

	public static function go() {
		self::process();
		if (!file_exists(DIR_C . '/' . Route::getController() . ".php")) {
			ErrorHandler::output("Function  " . Route::getFunction() . " in " . Route::getController() . " unreachable.");
		} else {
			require_once DIR_C . '/' . Route::getController() . ".php";
			self::process();
			$theCtrl = new self::$ctrl();
			$theFn = self::$fn;
			if (!method_exists($theCtrl, Route::getFunction())):
				die("Error : function " . Route::getFunction() . " not defined ");
			else:
				echo $theCtrl->$theFn();
			endif;
		}
	}
}
