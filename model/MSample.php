<?php
require_once dirname(dirname(__FILE__)) . "/config/conf.php";
require_once DIR_F . "/db/Db1.php";
/**
 * @author arifdiyantotmg@gmail.com
 */
class MSample extends Db1 {

	public static function model($className = __CLASS__) {
		$obj = new MSample();
		$obj->tblName = "sample";
		$obj->arrFields = ['kode', 'nama', 'created_date'];
		return $obj;
	}
}