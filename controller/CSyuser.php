<?php
require_once dirname(dirname(__FILE__)) . "/config/conf.php";
require_once DIR_M . "/Syuser.php";

/**
 *
 */
class CSyuser extends Controller {
	private $objUser;

	function __construct() {
		$this->objUser = Syuser::model();
	}

	public function index() {
		return '';
	}

	public function getList() {
		$q = Req::post('q');
                $query="SELECT * FROM ".$this->objUser->getTable()." where userid like '%" . $q . "%'";
		$data = $this->objUser->selectAssoc($query);
		return View::render('content/user/user_list', compact(['q', 'data']));
	}

	public function show() {
		$data = $this->objUser->selectAssoc("SELECT * FROM ".$this->objUser->getTable()." where userid='" . Req::post('id') . "'");
		return json_encode(['data' => $data[0]]);
	}

	public function save() {
		$this->objUser->clearAttributs();
		$this->objUser->setAttributs(Req::all());
		$this->objUser->created_date = date('Y-m-d H:i:s');
		if (Req::post('crud') == 'c') {
			if ($this->objUser->save()) {
				return "Success";
			} else {
				return ErrorHandler::output("Error : " . $this->objUser->getError());
			}
		} else {
			if ($this->objUser->update("and userid='" . Req::post('userid') . "'")) {
				return "Success";
			} else {
				return ErrorHandler::output("Error : " . $this->objUser->getError());
			}
		}
	}

	public function del() {
		if ($this->objUser->del("and userid='" . Req::request('id') . "'")) {
			return "Success";
		} else {
			return ErrorHandler::output("Error : " . $this->objUser->getError());
		}
	}

	public function testPaging() {
		$q = Req::post('q');
		$arr = $this->objUser->selectPaging("SELECT * FROM sample where nama like '%" . $q . "%'", 2);
		$data = $arr['data'];
		return View::render('content/sample/sample_list', compact(['q', 'data']));
	}

}
