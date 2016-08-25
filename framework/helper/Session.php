<?php
require_once dirname(__FILE__) . "/../../config/conf.php";
require_once DIR_M . '/System.php';

/**
 * @uses untuk manage session
 */
if (!isset($_SESSION)) {
	session_start();
}

class Session extends App {
	/**
	 * @var mixed
	 */
	private static $syuser;
	/**
	 * @var mixed
	 */
	private static $strerror;

	/**
	 * @param $userid
	 * @param $pass
	 * @param $rememberme
	 */
	public static function auth($userid, $pass, $rememberme = false) {
		$system = System::model();
		$data = $system->selectAssoc("select * from syuser where userid='$userid'");
		if (count($data) != 1) {
			self::$strerror = "Error, User tidak ditemukan";
			return false;
		} elseif (md5($pass) == $data[0]['pass']) {
			$arr['userid'] = $userid;
			$arr['rememberme'] = $rememberme;
			$arr['login_at'] = date('Y-m-d H:i');
			self::set($arr);
			self::$strerror = "";
			return true;
		} else {
			self::$strerror = "Error, Password tidak ditemukan.";
			return false;

		}
	}
	public static function getError() {
		return self::$strerror;
	}
	/**
	 * @param $arr
	 */
	private static function set($arr) {
		$enc = self::encSession($arr);
		$_SESSION[APP_BASE] = $enc;
		if ($arr['rememberme'] == 1) {
			setcookie(APP_BASE . '_sid', $enc, time() + 60 * 60 * 24 * 100, '/');
		}
	}
	public static function destroy() {
		session_destroy();
		setcookie(APP_BASE . '_sid', '', time() + 60 * 60 * 24 * 100, '/');
	}
	/**
	 * @param $arr
	 */
	private static function encSession($arr) {
		return base64_encode(json_encode($arr));
	}
	/**
	 * @param $encripted_str
	 */
	private static function decSession($encripted_str) {
		return base64_decode($encripted_str);
	}

	/**
	 * @param $session_key
	 * @param $default
	 * @return mixed
	 */
	public static function get($session_key, $default = "") {
		$cookie = isset($_COOKIE[APP_BASE . '_sid']) ? $_COOKIE[APP_BASE . '_sid'] : "";
		if (!isset($_SESSION[APP_BASE]) || $_SESSION[APP_BASE] == "") {
			$_SESSION[APP_BASE] = $cookie;
		}
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
		if (self::get('userid') == '') {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * @param $key
	 */
	public static function user($key) {
		$userid = self::get('userid', '');
		$system = System::model();
		$data = $system->selectAssoc("select * from syuser where userid='$userid'");
		self::$syuser = $data[0];
		return self::$syuser[$key];
	}

	/**
	 * @param $key
	 * @param $str
	 */
	public static function setFlash($key, $str) {
		$_SESSION[APP_BASE . '/' . $key] = base64_encode($str);
		return true;
	}
	/**
	 * @param $key
	 * @param $default
	 */
	public static function getFlash($key, $default = "") {
		return isset($_SESSION[APP_BASE . '/' . $key]) ? base64_decode($_SESSION[APP_BASE . '/' . $key]) : $default;
	}

}