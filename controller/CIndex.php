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
		$fld = Req::post('fields');

		$arr = explode(',', $fld);
		foreach ($arr as $k => $v) {
			$newStr = trim($v);
			// $newStr = preg_replace("/^[a-zA-Z0-9]+/", '', $newStr);
			$newStr = str_replace('`', '', $newStr);
			$newStr = str_replace("'", '', $newStr);
			$arr[$k] = $newStr;
		}
		return View::render('/content/sfgenerator/sfgenerator_result', compact(['arr', 'tbl']));
	}

	public function login() {
		//ini baru test saja, belum di db kan
		$arr['userid'] = Req::post('userid');
		if (Req::post('pass') == '123') {
			Session::set($arr);
			return $this->index();
		} else {
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
			$str .= "<li class='treeview'>
            <a href='#'><i class='" . $v['icon'] . "'></i> <span>" . $v['label'] . "</span>
                <span class='pull-right-container'>
                  <i class='fa fa-angle-left pull-right'></i>
                </span>
            </a>";
			if (isset($karr[$v['id']]) && is_array($karr[$v['id']])) {
				$str .= "<ul class='treeview-menu' style='display: none;'>";
				foreach ($karr[$v['id']] as $k1 => $v1) {
					$str .= "<li data-id=" . $v1['id'] . "><a href='" . ($v1['url'] == '' ? ROOT : ROOT . '/?x=' . $v1['id']) . "'><i class='" . $v1['icon'] . "'></i> " . $v1['label'] . "</a></li>";
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

}