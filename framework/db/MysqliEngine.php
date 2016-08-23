<?php
require_once dirname(__FILE__) . "/../../config/conf.php";

/**
 * @author arifdiyantotmg@gmail.com
 */

class MysqliEngine extends App {
	protected $dbconn;
	private $lastQuery;
	private $sf_errno;
	private $sf_error;
	private $fieldsFetch;

	public function openConnection($host, $user, $pass, $dbname) {
		$this->dbconn = new mysqli($host, $user, $pass, $dbname);
		if ($this->dbconn->connect_errno) {
			return "Failed to connect to MySQL: " . $this->dbconn->connect_error;
		}
	}

	public function query($str_query) {
		$this->lastQuery = $str_query;
		$data = $this->dbconn->query($str_query);

		if ($this->dbconn->errno == 0) {
			$this->fieldsFetch = [];
			$this->fieldsFetch = $data->fetch_fields();
			return $data;
		} else {
			$this->sf_errno = $this->dbconn->errno;
			$this->sf_error = $this->dbconn->error;
			return false;
		}
	}

	public function getFieldsFetch() {
		return $this->fieldsFetch;
	}

	public function getLastQuery() {
		return $this->lastQuery;
	}

	public function cmd($str_query) {
		$this->lastQuery = $str_query;
		$res = $this->dbconn->query($str_query);
		if ($this->dbconn->errno == 0) {
			return true;
		} else {
			$this->sf_errno = $this->dbconn->errno;
			$this->sf_error = $this->dbconn->error;
			return false;
		}
	}

	public function insertDb($table, $arrData) {
		$pre_val = "";
		$bind_val = "";
		$param_type = "";
		$cols = "";
		foreach ($arrData as $k => $v) {
			$pre_val .= ",?";
			$param_type .= 's';
			$cols .= ",$k";
			$$k = $v;
			$bind_val .= ',$' . $k;
		}
		$q = "INSERT INTO $table (" . substr($cols, 1, strlen($cols)) . ") VALUES (" . substr($pre_val, 1, strlen($pre_val)) . ")";

		if ($stmt = $this->dbconn->prepare($q)) {
			$binder = '$stmt->bind_param("' . $param_type . '"' . $bind_val . ');';
			eval($binder);
			$stmt->execute();
			if ($this->dbconn->errno == 0) {
				return true;
			} else {
				$this->sf_errno = $this->dbconn->errno;
				$this->sf_error = $this->dbconn->error;
				return false;
			}
		} else {
			$this->sf_errno = $this->dbconn->errno;
			$this->sf_error = $this->dbconn->error;
			return false;
		}
	}

	public function updateDb($table, $arrData, $where) {
		$pre_val = "";
		$bind_val = "";
		$param_type = "";
		foreach ($arrData as $k => $v) {
			$pre_val .= ",$k=?";
			$param_type .= 's';
			$$k = $v;
			$bind_val .= ',$' . $k;
		}
		$pre_val = substr($pre_val, 1, strlen($pre_val));
		$bind_val = substr($bind_val, 1, strlen($bind_val));
		$q = "UPDATE $table SET $pre_val where 1=1 $where";
		if ($stmt = $this->dbconn->prepare($q)) {
			$binder = '$stmt->bind_param("' . $param_type . '",' . $bind_val . ');';
			eval($binder);
			$stmt->execute();
			if ($this->dbconn->errno == 0) {
				return true;
			} else {
				$this->sf_errno = $this->dbconn->errno;
				$this->sf_error = $this->dbconn->error;
				return false;
			}
		} else {
			$this->sf_errno = $this->dbconn->errno;
			$this->sf_error = $this->dbconn->error;
			return false;
		}
	}

	public function deleteDb($table, $where) {
		$this->lastQuery = "delete from  $table  where 1=1 $where";
		return $this->cmd($this->lastQuery);
	}

	public function selectAssoc($str_query) {
		$data = $this->query($str_query);
		$arr = [];

		while ($row = $data->fetch_assoc()) {
			$arr[] = $row;
		}

		return $arr;
	}

	public function selectPaging($cols, $tableAndwhere, $limit = 10) {
		$aggregate = $this->selectAssoc("select count(*) as jml from $tableAndwhere");
		$rows = $aggregate[0]['jml'];
		$maxpage = round($rows / $limit, 0, PHP_ROUND_HALF_UP);
		$page = Req::request('page', 1);
		$offset = $page <= 0 ? 0 : ($page - 1) * $limit;
		$arr = $this->selectAssoc("select $cols from $tableAndwhere limit $offset,$limit");

		return ['data' => $arr, 'attr' => compact(['maxpage', 'page', 'limit'])];
	}

	public function selectArray($str_query) {
		$data = $this->query($str_query);
		$arr = [];

		while ($row = $data->fetch_array()) {
			$arr[] = $row;
		}

		return $arr;
	}

	public function getErrno() {
		return $this->sf_errno;
	}

	public function getError() {
		return $this->sf_error;
	}
}
?>