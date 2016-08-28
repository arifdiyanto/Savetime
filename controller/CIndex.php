<?php
require_once dirname(dirname(__FILE__)) . "/config/conf.php";
require_once DIR_M . "/System.php";

/**
 * @uses function ini harus selalu ada, untuk default route
 */
class CIndex extends Controller {

	private $objSystem;

	function __construct() {
		$this->objSystem = System::model();
	}

	public function index() {
		if (!Session::check()) {
			return View::render("/content/system/login", compact(['page_content', 'left_menu']));
		}
		$pgs = $this->objSystem->selectAssoc("SELECT * FROM symenu where id='" . Req::get('x') . "'");
		if (isset($pgs[0]['url'])) {
			$pg = $pgs[0]['url'];
		} else {
			$pg = "";
		}
		$theme = Req::get('theme') == '' ? "adminlte" : Req::get('theme');
		$left_menu = $this->lteMenu();
		if ($pg == '') {
			$page_content = View::render('/content/frm_default');
		} elseif (!file_exists(DIR_V . '/content/' . $pg . '.php')) {
			$page_content = "<div class='alert alert-warning'><i class='fa fa-warning fa-5x pull-left'></i> <h3>Maaf!</h3><hr>Halaman yang Anda cari belum tersedia. [Ref : " . $pg . "]</div>";
		} else {
			$page_content = View::render("/content/" . $pg);
		}
		return View::render("/layouts/$theme", compact(['page_content', 'left_menu', 'pgs']));
	}

	public function buildScript() {
		$tbl = Req::post('table');
		$cekTable = $this->objSystem->query("show tables like '" . $tbl . "'");

		if (!$cekTable->num_rows > 0) {
			$tables = $this->objSystem->query("show tables");
			$str = "<ol>";
			foreach ($tables as $key => $v) {
				foreach ($v as $key => $value) {
					$str .= "<li>$key : <b class='text-blue pointer' onclick='oGenerate(this.title)' title='$value'>" . $value . "</b></li>";
				}
			}
			$str . "</ol>";
			return "<code>Sorry! Table <b><i>$tbl</i></b> not found</code><br><h4>These are existing tables :</h4>$str";
		} else {
			$data = $this->objSystem->query("select * from $tbl limit 0,1");
			$flds = $this->objSystem->getFieldsFetch();

			return View::render('/content/sfgenerator/sfgenerator_result', compact(['arr', 'flds', 'tbl']));
		}

	}

	public function login() {
		if (Session::auth(Req::post('userid'), Req::post('pass'), Req::post('rememberme'))) {
			return $this->index();
		} else {
			Session::setFlash('error-login', Session::getError());
			return Route::redirect(ROOT);
		}

	}

	public function logout() {
		Session::destroy();
		return Route::redirect(ROOT);
	}

	public function lteMenu() {
		$arr = $this->getArrMenu();
		$karr = [];
		foreach ($arr as $k => $v) {
			$karr[$v['parent']][] = $v;
		}
		$str = "";
		foreach ($karr[0] as $k => $v) {
			$str .= "<li class='treeview menu_item menu_item_" . $v['id'] . "'>
            <a href='#'><i class='" . $v['icon'] . "'></i> <span>" . $v['label'] . "</span>
                <span class='pull-right-container'>
                  <i class='fa fa-angle-left pull-right'></i>
                </span>
            </a>";
			if (isset($karr[$v['id']]) && is_array($karr[$v['id']])) {
				$str .= "<ul class='treeview-menu  menu_item menu_item_" . $v['id'] . "' >";
				foreach ($karr[$v['id']] as $k1 => $v1) {
					$str .= "<li class='menu_item  menu_sub_item_" . $v1['id'] . "' data-id=" . $v1['id'] . "><a href='" . ($v1['url'] == '' ? ROOT : ROOT . '/?x=' . $v1['id']) . "'><i class='" . $v1['icon'] . "'></i> " . $v1['label'] . "</a></li>";
				}
				$str .= "</ul>";
			}
			$str .= "</li>";
		}
		return $str;
	}

	public function getArrMenu() {
		$q = "select * from symenu where isaktif=1";
		return $this->objSystem->selectAssoc($q);
	}
	public function search() {
		$pg = "system/frm_search";
		$allsymenu = $this->objSystem->selectAssoc("SELECT * FROM symenu where isaktif=1");
		$symenu = $this->objSystem->selectAssoc("SELECT * FROM symenu where isaktif=1 and concat(label,note) like '%" . Req::get('q') . "%'");
		$page_content = View::render("/content/" . $pg, compact(['symenu', 'allsymenu']));

		$theme = Req::get('theme') == '' ? "adminlte" : Req::get('theme');
		$pgs[0]['label'] = "Search Page";
		$left_menu = $this->lteMenu();
		return View::render("/layouts/$theme", compact(['page_content', 'left_menu', 'pgs']));
	}

}