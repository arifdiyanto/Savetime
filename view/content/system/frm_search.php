<div class="">
    <form action="<?=ROOT?>/CIndex/search" method="get" class="form-inline text-right">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search..." value="<?=Req::get('q')?>">
            <span class="input-group-btn">
                <button type="submit" name="search-btn" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
    </form>
</div>
<ul class="list-group">
<?php
$arr = [];
foreach ($allsymenu as $k => $v) {
	$arr[$v['id']] = $v;
}

$str = "";
foreach ($symenu as $k => $v) {
	$str .= "<li class='list-group-item'>
	<a href='" . ROOT . "/?x=" . $v['id'] . "'>
	<h4 class='text-blue'><b><i class='" . $v['icon'] . "'></i> " .
		(isset($arr[$v['parent']]['label']) ? $arr[$v['parent']]['label'] . ' &raquo; ' : '') . $v['label'] . "</b></h4>
	<div class=''>" . $v['note'] . "</div>
	<div class='text-green'>URL : " . ROOT . '/' . $v['note'] . "</div>
	</li>";
}
echo $str;
?>
</ul>
