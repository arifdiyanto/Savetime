<?php
require_once dirname(__FILE__) . "/../../config/conf.php";
require_once DIR_F . '/helper/ErrorHandler.php';
/**
 * @uses untuk mengatur view
 */
class View extends App {

	function __construct() {

	}

	public static function render($filename, $arrVariable = []) {
		$full_path = DIR_V . "/" . $filename . ".php";
		if (!file_exists($full_path)) {
			return ErrorHandler::output("Error : file $full_path not found");
		} else {
			ob_start();
			extract($arrVariable);
			include $full_path;
			$content = ob_get_contents();
			ob_get_clean();
			return $content;
		}

	}
}