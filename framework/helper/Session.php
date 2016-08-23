<?php
require_once dirname(__FILE__) . "/../../config/conf.php";

/**
 * @uses untuk manage session
 */
if (!isset($_SESSION)) {
	session_start();
}

class Session extends App {

	public static function set($arr) {
		$enc = self::encSession($arr);
		$_SESSION[APP_BASE] = $enc;
	}
	public static function destroy() {
		session_destroy();
	}
	private static function encSession($arr) {
		return base64_encode(json_encode($arr));
	}
	private static function decSession($encripted_str) {
		return base64_decode($encripted_str);
	}

	public static function get($session_key, $default = "") {
		$raw_session = $_SESSION[APP_BASE];
		$json_session = self::decSession($raw_session);
		$arr_session = json_decode($json_session, 1);
		if (isset($arr_session[$session_key])) {
			return $arr_session[$session_key];
		} else {
			return $default;
		}
	}

	public static function check() {
		if (!isset($_SESSION[APP_BASE]) || $_SESSION[APP_BASE] == '') {
			return false;
		} else {
			return true;
		}
	}

}