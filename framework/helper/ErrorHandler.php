<?php
require_once dirname(__FILE__) . "/../../config/conf.php";

/**
 *
 */
class ErrorHandler extends App {

	public static function output($error_string) {
		if (APP_DEBUGER) {
			try {
				throw new Exception($error_string, 1);
			} catch (Exception $e) {
				echo $error_string;
			}
		} else {
			try {
				throw new Exception("Oops! There is something wrong or Error", 505);
			} catch (Exception $e) {
				echo ("Oops! There is something wrong or Error");
			}

		}
	}
}