<?php
require_once dirname(__FILE__) . "/../../config/conf.php";
/**
 *
 */
class Req extends App {

	function __construct() {
		# code...
	}

	/**
	 * @param $id
	 * @param $def
	 * @return mixed
	 */
	public static function get($id, $def = "") {
		if (isset($_GET[$id])) {
			return filter_input(INPUT_GET, $id);
		} else {
			return $def;
		}

	}

	/**
	 * @param $id
	 * @param $def
	 * @return mixed
	 */
	public static function post($id, $def = "") {
		if (isset($_POST[$id])) {
			return filter_input(INPUT_POST, $id);
		} else {
			return $def;
		}
	}

	/**
	 * @param $id
	 * @param $def
	 * @return mixed
	 */
	public static function server($id, $def = "") {
		if (isset($_SERVER[$id])) {
			return filter_input(INPUT_SERVER, $id);
		} else {
			return $def;
		}
	}

	/**
	 * @param $id
	 * @param $def
	 * @return mixed
	 */
	public static function cookie($id, $def = "") {
		if (isset($_COOKIE[$id])) {
			return filter_input(INPUT_COOKIE, $id);
		} else {
			return $def;
		}
	}

	/**
	 * @param $id
	 * @param array $def
	 * @return mixed
	 */
	public static function request($id, $def = []) {
		if (isset($_GET[$id])) {
			return $_REQUEST[$id];
		} else {
			return $def;
		}
	}
	/**
	 * @return mixed
	 */
	public static function all() {
		return $_REQUEST;
	}
}
