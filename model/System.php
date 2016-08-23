<?php
require_once dirname(dirname(__FILE__)) . "/config/conf.php";
require_once DIR_F . "/db/Db1.php";
/**
 * @author arifdiyantotmg@gmail.com
 */
class System extends Db1 {

	public static function model($className = __CLASS__) {
		$obj = new System();
		$obj->tblName = "";
		$obj->arrFields = [];
		return $obj;
	}
}