<div class="row">
    <div class="col-sm-12">
        <hr>
        <h3>Form</h3>
        <pre><code>
<?php
$aTbl = ucwords($tbl);
$str = "<form id='frm' method='POST' action='<?=ROOT?>/C$aTbl/save'>\n";
foreach ($arr as $k => $v) {
	$str .= "<label>$v</label><input type='text' id='$v' name='$v' class='form-control input-sm clear' value='' placeholder=''>\n";
}
$str .= "</form>";
echo nl2br(htmlspecialchars($str));
?>
</code>
</pre>

<hr>
        <h3>Set Paramter</h3>
        <pre><code>
<?php
$str = "";
foreach ($arr as $k => $v) {
	$str .= "\$this->obj$aTbl->$v=Req::post('$v');\n";
}
echo nl2br(htmlspecialchars($str));
?>
</code>
</pre>
    </div>
</div>
