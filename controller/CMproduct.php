
<?php
require_once dirname(dirname(__FILE__)) . "/config/conf.php";
require_once DIR_M . "/Mproduct.php";

/**
 * @author Arif Diyanto on 31 Aug 2016 07:28
 */
class CMproduct extends Controller {
    private $objMproduct;

    function __construct() {
        $this->objMproduct = Mproduct::model();
    }

    public function index() {
        return '';
    }

    public function getList() {
        $q = Req::post('q');
        $data = $this->objMproduct->selectPaging("*", "mproduct where pro_id like '%" . $q . "%'", 3);
        $pager = View::render('layouts/pager', compact(['data']));
        return View::render('content/mproduct/mproduct_list', compact(['q', 'data', 'pager']));
    }

    public function show() {
        $data = $this->objMproduct->selectAssoc("SELECT * FROM mproduct where pro_id='" . Req::post('id') . "'");
        return json_encode(['data' => $data[0]]);
    }

    public function save() {
        $this->objMproduct->clearAttributs();
        $this->objMproduct->setAttributs(Req::all());
        $this->objMproduct->updated_at = Session::user('userid');
        $this->objMproduct->updated_at = date('Y-m-d H:i:s');
        if (Req::post('crud') == 'c') {
            $this->objMproduct->created_by = Session::user('userid');
            $this->objMproduct->created_at = date('Y-m-d H:i:s');
            if ($this->objMproduct->save()) {
                return "Success";
            } else {
                return ErrorHandler::output("Error : " . $this->objMproduct->getError());
            }
        } else {
            if ($this->objMproduct->update("and pro_id='" . Req::post('pro_id') . "'")) {
                return "Success";
            } else {
                return ErrorHandler::output("Error : " . $this->objMproduct->getError());
            }
        }
    }

    public function del() {
        if ($this->objMproduct->del("and pro_id='" . Req::get('id') . "'")) {
            return "Success";
        } else {
            return ErrorHandler::output("Error : " . $this->objMproduct->getError());
        }
    }

}
