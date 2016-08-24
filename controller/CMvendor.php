<?php

require_once dirname(dirname(__FILE__)) . "/config/conf.php";
require_once DIR_M . "/Mvendor.php";

/**
 * @author udin on 24 Aug 2016 16:15
 */
class CMvendor extends Controller {
    private $objMvendor;

    function __construct() {
        $this->objMvendor = Mvendor::model();
    }

    public function index() {
        return '';
    }

    public function getList() {
        $q = Req::post('q');
        $data = $this->objMvendor->selectPaging("*", "mvendor where name like '%" . $q . "%'", 3);
        $pager = View::render('layouts/pager', compact(['data']));
        return View::render('content/mvendor/mvendor_list', compact(['q', 'data', 'pager']));
    }

    public function show() {
        $data = $this->objMvendor->selectAssoc("SELECT * FROM mvendor where id='" . Req::post('id') . "'");
        return json_encode(['data' => $data[0]]);
    }

    public function save() {
        $this->objMvendor->clearAttributs();
        $this->objMvendor->setAttributs(Req::all());
        $this->objMvendor->updated_at = Session::user('userid');
        $this->objMvendor->updated_at = date('Y-m-d H:i:s');
        if (Req::post('crud') == 'c') {
            $this->objMvendor->created_by = Session::user('userid');
            $this->objMvendor->created_at = date('Y-m-d H:i:s');
            if ($this->objMvendor->save()) {
                return "Success";
            } else {
                return ErrorHandler::output("Error : " . $this->objMvendor->getError());
            }
        } else {
            if ($this->objMvendor->update("and id='" . Req::post('id') . "'")) {
                return "Success";
            } else {
                return ErrorHandler::output("Error : " . $this->objMvendor->getError());
            }
        }
    }

    public function del() {
        if ($this->objMvendor->del("and id='" . Req::get('id') . "'")) {
            return "Success";
        } else {
            return ErrorHandler::output("Error : " . $this->objMvendor->getError());
        }
    }

}

