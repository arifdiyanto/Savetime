<?php
// error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_WARNING);
session_start();
if (isset($_SERVER['HTTPS']) ? $_SERVER['HTTPS'] : '' == 'on') {
	$http = "https://";
} else {
	$http = "http://";
}
if ($_SERVER['SERVER_PORT'] == 80) {
	$ip = $_SERVER['SERVER_NAME'];
} else {
	$ip = $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'];
}
// $folder = "/" . trim(dirname(dirname(htmlspecialchars(substr(dirname(__FILE__), strlen($_SERVER['DOCUMENT_ROOT']))))));
$folder = substr(dirname(dirname(dirname(__FILE__))), strlen($_SERVER['DOCUMENT_ROOT']));
define('ROOT', $http . $ip . "/" . $folder);
define('HTTP_SERVER', ROOT);
define('APP_BASE', $folder == "" ? "sf" : $folder);

define('HTTP_A', HTTP_SERVER . "/assets");
define('HTTP_C', HTTP_SERVER . "/controller");
define('HTTP_F', HTTP_SERVER . "/framework");
define('HTTP_M', HTTP_SERVER . "/model");
define('HTTP_V', HTTP_SERVER . "/view");

define('DIR_A', dirname(dirname(dirname(__FILE__))) . "/assets");
define('DIR_C', dirname(dirname(dirname(__FILE__))) . "/controller");
define('DIR_F', dirname(dirname(dirname(__FILE__))) . "/framework");
define('DIR_M', dirname(dirname(dirname(__FILE__))) . "/model");
define('DIR_V', dirname(dirname(dirname(__FILE__))) . "/view");

//class loader
require_once DIR_F . '/core/App.php';
require_once DIR_F . '/core/Route.php';
require_once DIR_F . '/core/Controller.php';
require_once DIR_F . '/core/Model.php';
require_once DIR_F . "/helper/ErrorHandler.php";
require_once DIR_F . "/helper/Req.php";
require_once DIR_F . "/helper/Session.php";
require_once DIR_F . "/helper/View.php";
?>