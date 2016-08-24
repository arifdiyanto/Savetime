<?php
$aTbl = ucwords($tbl);
$bTbl = strtolower($tbl);
?>
    <div class="row">
        <div class="col-sm-12">
            <hr>
            <!-- --------------------------------------------------- -->
            <i class="fa fa-copy text-green pointer pull-left" title="Copy to clipboard" onclick="copyToClipboard('pre.sfstructure')"></i>
            <h3 class='pointer text-blue' onclick="$('pre.sfstructure').toggle()">Table Structure : <?=$aTbl?></h3>
            <pre class='more sfstructure'><code>
<?php
$str = "<table class='table table-striped'>
<tr><td>No</td><td>Name</td><td>Table</td><td>Max Len</td><td>Length</td><td>Char Set</td><td>Flags</td><td>Type</td></tr>";
foreach ($flds as $k => $v) {
	$str .= "<tr><td>" . ($k + 1) . "</td>
    <td>" . $v->name . "</td>
    <td>" . $v->table . "</td>
    <td>" . $v->max_length . "</td>
    <td>" . $v->length . "</td>
    <td>" . $v->charsetnr . "</td>
    <td>" . $v->flags . "</td>
    <td>" . $v->type . "</td>
    </tr>";
	$arr[] = $v->name;
}
$str .= "</table>";
echo $str;
?>
</code>
</pre>
            <hr>
            <!-- --------------------------------------------------- -->
            <i class="fa fa-copy text-green pointer pull-left" title="Copy to clipboard" onclick="copyToClipboard('pre.sfmodel')"></i>
            <h3 class='pointer text-blue' onclick="$('pre.sfmodel').toggle()">Model : <i><?=$aTbl?></i></h3>
            <pre class='more sfmodel'><code>
<?php
$var = "";
foreach ($arr as $k => $v) {
	if ($k == 0) {
		$tblkey = $v;
	}
	$var .= "'$v',";
}
$str = "require_once dirname(dirname(__FILE__)) . '/config/conf.php';
require_once DIR_F . '/db/Db1.php';
/**
 * @author " . Session::user('username') . " on " . date('d M Y H:i') . "
 */
class $aTbl extends Db1 {
    public static function model(\$className = __CLASS__) {
        \$obj = new $aTbl();
        \$obj->tblName = '$aTbl';
        \$obj->tblKey = '$tblkey';
        \$obj->arrFields = [$var];
        return \$obj;
    }
}";

echo nl2br(htmlspecialchars($str));
?>
</code>
</pre>
            <hr>
            <!-- --------------------------------------------------- -->
            <i class="fa fa-copy text-green pointer pull-left" title="Copy to clipboard" onclick="copyToClipboard('pre.sfcontroller')"></i>
            <h3 class='pointer text-blue' onclick="$('pre.sfcontroller').toggle()">Controller : <i><?='C' . $aTbl?>.php</i></h3>
            <pre class='more sfcontroller'><code>
<?php
$str = "<?php
require_once dirname(dirname(__FILE__)) . \"/config/conf.php\";
require_once DIR_M . \"/$aTbl.php\";

/**
 * @author " . Session::user('username') . " on " . date('d M Y H:i') . "
 */
class C$aTbl extends Controller {
    private \$obj$aTbl;

    function __construct() {
        \$this->obj$aTbl = $aTbl::model();
    }

    public function index() {
        return '';
    }

    public function getList() {
        \$q = Req::post('q');
        \$data = \$this->obj" . $aTbl . "->selectPaging(\"*\", \"$bTbl where " . $tblkey . " like '%\" . \$q . \"%'\", 3);
        \$pager = View::render('layouts/pager', compact(['data']));
        return View::render('content/$bTbl/" . $bTbl . "_list', compact(['q', 'data', 'pager']));
    }

    public function show() {
        \$data = \$this->obj" . $aTbl . "->selectAssoc(\"SELECT * FROM $bTbl where $tblkey='\" . Req::post('id') . \"'\");
        return json_encode(['data' => \$data[0]]);
    }

    public function save() {
        \$this->obj" . $aTbl . "->clearAttributs();
        \$this->obj" . $aTbl . "->setAttributs(Req::all());
        \$this->obj" . $aTbl . "->updated_at = Session::user('userid');
        \$this->obj" . $aTbl . "->updated_at = date('Y-m-d H:i:s');
        if (Req::post('crud') == 'c') {
            \$this->obj" . $aTbl . "->created_by = Session::user('userid');
            \$this->obj" . $aTbl . "->created_at = date('Y-m-d H:i:s');
            if (\$this->obj" . $aTbl . "->save()) {
                return \"Success\";
            } else {
                return ErrorHandler::output(\"Error : \" . \$this->obj" . $aTbl . "->getError());
            }
        } else {
            if (\$this->obj" . $aTbl . "->update(\"and $tblkey='\" . Req::post('$tblkey') . \"'\")) {
                return \"Success\";
            } else {
                return ErrorHandler::output(\"Error : \" . \$this->obj" . $aTbl . "->getError());
            }
        }
    }

    public function del() {
        if (\$this->obj" . $aTbl . "->del(\"and $tblkey='\" . Req::get('id') . \"'\")) {
            return \"Success\";
        } else {
            return ErrorHandler::output(\"Error : \" . \$this->obj" . $aTbl . "->getError());
        }
    }

}";

echo nl2br(htmlspecialchars($str));
?>
</code>
</pre>
            <hr>
            <!-- --------------------------------------------------- -->
            <i class="fa fa-copy text-green pointer pull-left" title="Copy to clipboard" onclick="copyToClipboard('pre.sfpage')"></i>
            <h3 class='pointer text-blue' onclick="$('pre.sfpage').toggle()">Page : <i><?='frm_' . $bTbl?>.php</i></h3>
            <pre class='more sfpage'><code>
<?php
$str = "<div class=\"meToolbar form-inline text-right\">
    <button class=\"btn btn-sm btn-success meDiv meFrm\" onclick=\"oSave();\" title=\"Save\"><i class=\"fa fa-save\"></i></button>
    <button class=\"btn btn-sm btn-danger meDiv meFrm\" onclick=\"oDel();\" title=\"Delete\"><i class=\"fa fa-trash-o\"></i></button>
    <button class=\"btn btn-sm btn-default meDiv meList\" onclick=\"oNew();\" title=\"New\"><i class=\"fa fa-file-o\"></i></button>
    <button class=\"btn btn-sm btn-default meDiv meFrm\" onclick=\"meShow('meList')\" title=\"Close\"><i class=\"fa fa-times\"></i></button>
    <div class=\"input-group meDiv meList\">
        <input id=\"q\" type=\"text\" class=\"form-control input-sm\" placeholder=\"Search\">
        <span class=\"input-group-addon pointer\" onclick=\"oSearch();\"><i class=\"fa fa-search pointer\"></i></span>
    </div>
</div>
<br>
<div class=\"meDiv meList\">
    <div class=\"box box-widget\">
        <div class=\"box-body\">
            <div id=\"list1\"></div>
        </div>
    </div>
</div>
<div class=\"meDiv meFrm\">
    <!-- ------------------------------------------------------------------------ -->
    <!-- Copy kan script form disini -->
    <!-- ------------------------------------------------------------------------ -->
</div>
    <!-- ------------------------------------------------------------------------ -->
    <!-- Copy kan script javascript disini -->
    <!-- ------------------------------------------------------------------------ -->";
echo nl2br(htmlspecialchars($str));
?>
</code>
</pre>
            <hr>
            <!-- --------------------------------------------------- -->
            <i class="fa fa-copy text-green pointer pull-left" title="Copy to clipboard" onclick="copyToClipboard('pre.sfform')"></i>
            <h3 class='pointer text-blue' onclick="$('pre.sfform').toggle()">.. Form :  <i>(include into page)</i></h3>
            <pre class='more sfform'><code>
<?php
$str = "<div class='box box-widget'><div class='box-body'>\n<form id='frm' method='POST' action='<?=ROOT?>/C$aTbl/save'>\n<input type='hidden' id='crud' name='crud' value='c'>\n";
foreach ($arr as $k => $v) {
	$str .= "<label>$v</label><input type='text' id='$v' name='$v' class='form-control input-sm clear' value='' placeholder=''>\n";
}
$str .= "</form>\n</div></div>";
echo nl2br(htmlspecialchars($str));
?>
</code>
</pre>
            <hr>
            <!-- --------------------------------------------------- -->
            <i class="fa fa-copy text-green pointer pull-left" title="Copy to clipboard" onclick="copyToClipboard('pre.sfjs')"></i>
            <h3 class='pointer text-blue' onclick="$('pre.sfjs').toggle()">.. Javascript <i>(include into page)</i></h3>
            <pre class='more sfjs'><code>
<?php
$str = "<script type=\"text/javascript\">
\$(document).ready(function() {
    oSearch();
});

function meShow(meId) {
    \$(\".meDiv\").hide();
    \$(\".\" + meId).show();
}

function oNew() {
    meShow('meFrm');
    \$(\"#crud\").val('c');
    \$(\".clear\").val('');
}

function oSearch() {
    meShow('meList');
    \$('#list1').html(\"<i class='fa fa-spin fa-spinner'></i>\");
    \$('#list1').load(\"<?=ROOT . '/C$aTbl/getList'?>?q=\" + \$(\"#q\").val(), function() {
        oLoadPagination(\"#list1\");
        \$('#q').on(\"keydown\", function(e) {
            if (e.keyCode == 13)
                oSearch(id);
        });
    });
}

function oShow(id) {
    meShow('meFrm');
    \$.post(\"<?=ROOT . '/C$aTbl/show';?>\", {
        id: id
    }, function(data) {
        var obj = JSON.parse(data);
        oNew();
        \$.each(obj.data, function(index, item) {
            \$(\"#\" + index).val(item);
        });
        \$(\"#crud\").val('u');
    });
}

function oDel() {
    var id = \$(\"#$tblkey\").val();

    swal({
            title: \"Are you sure?\",
            text: \"You will delete this data!\",
            type: \"warning\",
            showCancelButton: true,
            confirmButtonColor: \"#DD6B55\",
            confirmButtonText: \"Yes, delete it!\",
            closeOnConfirm: true
        },
        function() {
            var \$btn = \$('#btn-del').button('loading');
            \$.ajax({
                url: \"<?=ROOT . '/C$aTbl/del';?>?id=\" + id,
                success: function(data) {
                    \$btn.button('reset');
                    var patt = /Error|Kesalahan|Alert/g;
                    var result = patt.test(data);
                    if (result === false) {
                        oSearch();
                    } else {
                        swal('', data, error);
                    }
                    return false;
                },
                error: function(data) {
                    swal('', data.status, \"error\");
                }
            });
        });
}

function oSave() {
    \$(\".textError\").removeClass(\"textError\");
    var cek = true;
    var x = \$(\".must\");
    x.each(function(index) {
        if (\$(x[index]).val().trim() === \"\") {
            cek = false;
            \$(x[index]).addClass(\"textError\");
        }
    });
    if (cek === false) {
        swal('', 'Data tidak lengkap!', 'error');
        return false;
    }
    var formdata = new FormData();
    \$.each(\$('#frm').serializeArray(), function(a, b) {
        formdata.append(b.name, b.value);
    });
    var \$btn = \$('#btn-save').button('loading');
    \$.ajax({
        url: \$(\"#frm\").attr('action'),
        data: formdata,
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        type: 'POST',
        beforeSend: function() {
        },
        success: function(data) {
            \$btn.button('reset');
            var patt = /Error|error|Kesalahan|Alert/g;
            var result = patt.test(data);
            if (result === false) {
                oSearch();
            } else {
                swal('', data, 'error');
            }
            return false;
        },
        error: function(e) {
            \$btn.button('reset');
            swal('', data, 'error');
        }
    });
    return false;
}
</script>";
echo nl2br(htmlspecialchars($str));
?>
</code>
</pre>
            <hr>
            <!-- --------------------------------------------------- -->
            <i class="fa fa-copy text-green pointer pull-left" title="Copy to clipboard" onclick="copyToClipboard('pre.sftable')"></i>
            <h3 class='pointer text-blue' onclick="$('pre.sftable').toggle()">Datatable : <i><?=$bTbl . '_list'?>.php</i></h3>
            <pre class='more sftable'><code>
<?php
$str = "<?=(\$q == '' ? '' : \"Anda mencari <code>\$q</code>\")?>
        <?php
        if (!isset(\$data['data'][0])):
            echo \"<div class='text-red'>Data tidak ditemukan</div>\";
        else:
        ?>
        <table class=\"table table-condensed table-bordered table-hover table-striped pointer\">
            <thead>
                <tr>
                    <?php
                    \$i=0;
                    foreach (\$data['data'][0] as \$k => \$v):
                        if (\$i == 0) {
                            \$pk = \$v;
                        }
                        echo \"<th>\$k</th>\";
                        $i++;
                    endforeach
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach (\$data['data'] as \$k => \$v): ?>
                <tr class=\"pointer\" onclick=\"oShow('<?=\$v['\$pk']?>')\">
                    <?php foreach (\$v as \$key => \$value): ?>
                    <td>
                        <?=\$value?>
                    </td>
                    <?php endforeach;?>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
        <?php endif?>
        <?=\$pager?>
";
echo nl2br(htmlspecialchars($str));
?>
</code>
</pre>
            <hr>
            <!-- --------------------------------------------------- -->
            <i class="fa fa-copy text-green pointer pull-left" title="Copy to clipboard" onclick="copyToClipboard('pre.sfparam')"></i>
            <h3 class='pointer text-blue' onclick="$('pre.sfparam').toggle()">Set Parameter</h3>
            <pre class='more sfparam'><code>
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
    <script type="text/javascript">
    $(document).ready(function() {
        $(".more").hide();
    });
    </script>
