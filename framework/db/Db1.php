<?php
require_once dirname(dirname(dirname(__FILE__))) . "/config/conf.php";
require_once DIR_F . "/db/MysqliEngine.php";

/**
 * @author arifdiyantotmg@gmail.com
 */
class Db1 extends MysqliEngine {
	/**
	 * @var mixed
	 */
	protected $tblName;
	/**
	 * @var mixed
	 */
	protected $arrFields;

	function __construct() {
		$this->openConnection(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	}

	/**
	 * @return mixed
	 */
	public function getTable() {
		return $this->tblName;
	}

	/**
	 * @return mixed
	 */
	private function getFields() {
		return $this->arrFields;
	}

	public function clearAttributs() {
		$fields = $this->getFields();
		foreach ($fields as $field) {
			unset($this->$field);
		}
	}

	/**
	 * @param $arr
	 */
	public function setAttributs($arr) {
		$fields = $this->getFields();
		foreach ($arr as $k => $v) {
			if (in_array($k, $fields)) {
				$this->$k = $v;
			}
		}
	}

	/**
	 * @return mixed
	 */
	public function save() {
		$fields = $this->getFields();
		$arr = [];
		foreach ($fields as $v) {
			$arr[$v] = $this->$v;
		}
		return $this->insertDb($this->getTable(), $arr);
	}

	/**
	 * @param $where
	 * @return mixed
	 */
	public function update($where) {
		$fields = $this->getFields();
		$arr = [];
		foreach ($fields as $v) {
			$arr[$v] = $this->$v;
		}
		return $this->updateDb($this->getTable(), $arr, $where);
	}

	/**
	 * @param $where
	 * @return mixed
	 */
	public function del($where) {
		return $this->deleteDb($this->getTable(), $where);
	}
}