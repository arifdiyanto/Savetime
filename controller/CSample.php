<?php
require_once dirname(dirname(__FILE__)) . "/config/conf.php";
require_once DIR_M . "/MSample.php";

/**
 *
 */
class CSample extends Controller {
	private $objSample;

	function __construct() {
		$this->objSample = MSample::model();
	}

	public function index() {
		return '';
	}

	public function getList() {
		$q = Req::post('q');
		$data = $this->objSample->selectPaging("*", "sample where nama like '%" . $q . "%'", 3);
		$pager = View::render('layouts/pager', compact(['data']));
		return View::render('content/sample/sample_list', compact(['q', 'data', 'pager']));
	}

	public function show() {
		$data = $this->objSample->selectAssoc("SELECT * FROM sample where kode='" . Req::post('id') . "'");
		return json_encode(['data' => $data[0]]);
	}

	public function save() {
		$this->objSample->clearAttributs();
		$this->objSample->setAttributs(Req::all());
		$this->objSample->created_date = date('Y-m-d H:i:s');
		if (Req::post('crud') == 'c') {
			if ($this->objSample->save()) {
				return "Success";
			} else {
				return ErrorHandler::output("Error : " . $this->objSample->getError());
			}
		} else {
			if ($this->objSample->update("and kode='" . Req::post('kode') . "'")) {
				return "Success";
			} else {
				return ErrorHandler::output("Error : " . $this->objSample->getError());
			}
		}
	}

	public function del() {
		if ($this->objSample->del("and kode='" . Req::get('id') . "'")) {
			return "Success";
		} else {
			return ErrorHandler::output("Error : " . $this->objSample->getError());
		}
	}

	public function testPaging() {
		$q = Req::post('q');
		$arr = $this->objSample->selectPaging("SELECT * FROM sample where nama like '%" . $q . "%'", 2);
		$data = $arr['data'];
		return View::render('content/sample/sample_list', compact(['q', 'data']));
	}

}
