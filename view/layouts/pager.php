<?php
//build href
$requests = "";
foreach (Req::all() as $k => $v) {
	if ($k != 'route') {
		$requests .= "&$k=$v";
	}
}
$href = ROOT . "/" . Req::request('route') . "?" . $requests;

//build pager
extract($data['attr']);

$from = ($page - 2 <= 1) ? 1 : ($page - 2);
$to = ($page + 2 >= $maxpage) ? $maxpage : ($page + 2);
$prev = ($page - 1 <= 1) ? 1 : ($page - 1);
$next = ($page + 1 >= $maxpage) ? $maxpage : ($page + 1);

$strpager = "";
$strprev = "<li class='disabled'><span>«</span></li>";
$strnext = "<li class='disabled'><span>»</span></li>";
for ($i = $from; $i <= $to; $i++) {
	if ($i == $page) {
		$strpager .= "<li class='active'><span>$i</span></li>";
	} elseif ($i == $prev) {
		$strprev = "<li><a href='$href&page=$i' rel='prev'>«</a></li>";
		$strpager .= "<li><a href='$href&page=$i'>$i</a></li>";
	} elseif ($i == $next) {
		$strnext = "<li><a href='$href&page=$i' rel='prev'>»</a></li>";
		$strpager .= "<li><a href='$href&page=$i'>$i</a></li>";
	} else {
		$strpager .= "<li><a href='$href&page=$i'>$i</a></li>";
	}
}
if ($from == 1) {
	$strMin = "";
} else {
	$strMin = "<li><a href='$href&page=1'>1</a></li><li><span>..</span></li>";
}
if ($to == $maxpage) {
	$strMax = "";
} else {
	$strMax = "<li><span>..</span></li><li><a href='$href&page=$maxpage'>$maxpage</a></li>";
}
// display pager
if ($maxpage <= 1) {
	//tdk perlu pakai paging
} else {
	echo "<ul class='pagination'>
	$strprev
	$strMin
	$strpager
	$strMax
	$strnext
	</ul>";
}
?>
