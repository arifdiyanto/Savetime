<div class="meToolbar form-inline text-right">
    <div class="pull-left text-blue text-bold">Data Sample</div>
    <button class="btn btn-sm btn-success meDiv meFrm" onclick="oSave();" title="Save"><i class="fa fa-save"></i></button>
    <button class="btn btn-sm btn-danger meDiv meFrm" onclick="oDel();" title="Delete"><i class="fa fa-trash-o"></i></button>
    <button class="btn btn-sm btn-default meDiv meList" onclick="oNew();" title="New"><i class="fa fa-file-o"></i></button>
    <button class="btn btn-sm btn-default meDiv meFrm" onclick="meShow('meList')" title="Close"><i class="fa fa-times"></i></button>
    <div class="input-group meDiv meList">
        <input id="q" type="text" class="form-control input-sm" placeholder="Search">
        <span class="input-group-addon pointer" onclick="oSearch();"><i class="fa fa-search pointer"></i></span>
    </div>
</div>
<br>
<div class="meDiv meList">
    <div id="datalist"></div>
</div>
<div class="meDiv meFrm">
    <form id='frm' method='POST' action='<?=ROOT?>/CSyuser/save'>

<label>userid</label><input type='text' id='userid' name='userid' class='form-control input-sm clear' value='' placeholder=''>
<input type='hidden' id='crud' name='crud' value='c' placeholder=''>

<label>username</label><input type='text' id='username' name='username' class='form-control input-sm clear' value='' placeholder=''>

<label>pass</label><input type='text' id='pass' name='pass' class='form-control input-sm clear' value='' placeholder=''>

<label>email</label><input type='text' id='email' name='email' class='form-control input-sm clear' value='' placeholder=''>

<label>phone</label><input type='text' id='phone' name='phone' class='form-control input-sm clear' value='' placeholder=''>

<label>url_img</label><input type='text' id='url_img' name='url_img' class='form-control input-sm clear' value='' placeholder=''>

<label>gender</label><input type='text' id='gender' name='gender' class='form-control input-sm clear' value='' placeholder=''>

<label>address</label><input type='text' id='address' name='address' class='form-control input-sm clear' value='' placeholder=''>

<label>token</label><input type='text' id='token' name='token' class='form-control input-sm clear' value='' placeholder=''>

<label>attr</label><input type='text' id='attr' name='attr' class='form-control input-sm clear' value='' placeholder=''>

<label>isactive</label><input type='text' id='isactive' name='isactive' class='form-control input-sm clear' value='' placeholder=''>

<label>created_by</label><input type='text' id='created_by' name='created_by' class='form-control input-sm clear' value='' placeholder=''>

<label>updated_by</label><input type='text' id='updated_by' name='updated_by' class='form-control input-sm clear' value='' placeholder=''>

<label>created_at</label><input type='text' id='created_at' name='created_at' class='form-control input-sm clear' value='' placeholder=''>

<label>updated_at</label><input type='text' id='updated_at' name='updated_at' class='form-control input-sm clear' value='' placeholder=''>

</form>
</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    oSearch();
});

function meShow(meId) {
    $(".meDiv").hide();
    $("." + meId).show();
}

function oNew() {
    meShow('meFrm');
    $("#crud").val('c');
    $(".clear").val('');
}

function oSearch() {
    meShow('meList');
    $.post("<?=ROOT . '/CSyuser/getList';?>", {
        q: $("#q").val()
    }, function(data) {
        $("#datalist").html(data);
        $("#crud").val('c');
    });
}

function oShow(id) {
    meShow('meFrm');
    $.post("<?=ROOT . '/CSyuser/show';?>", {
        id: id
    }, function(data) {
        var obj = JSON.parse(data);
        oNew();
        $.each(obj.data, function(index, item) {
            $("#" + index).val(item);
        });
        $("#crud").val('u');
    });
}

function oDel() {
    var id=$("#userid").val();
    swal({
            title: "Yakin hapus?",
            text: "Anda akan menghapus data!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, hapus!",
            closeOnConfirm: true
        },
        function() {
            var $btn = $('#btn-del').button('loading');
            $.ajax({
                url: "<?=ROOT . '/CSyuser/del';?>?id=" + id,
                success: function(data) {
                    $btn.button('reset');
                    var patt = /Error|Kesalahan|Alert/g;
                    var result = patt.test(data);
                    if (result === false) {
                        swal('',data,'success');
                        oSearch();
                    } else {
                        swal('',data,'error');
                    }
                    return false;
                },
                error: function(data) {
                    swal('',data.status,"error");
                }
            });
        });
}

function oSave() {
    $(".textError").removeClass("textError");
    var cek = true;
    var x = $(".must");
    x.each(function(index) {
        if ($(x[index]).val().trim() === "") {
            cek = false;
            $(x[index]).addClass("textError");
        }
    });
    if (cek === false) {
        swal('', 'Data tidak lengkap!', 'error');
        return false;
    }
    var formdata = new FormData();
    $.each($('#frm').serializeArray(), function(a, b) {
        formdata.append(b.name, b.value);
    });
    var $btn = $('#btn-save').button('loading');
    $.ajax({
        url: $("#frm").attr('action'),
        data: formdata,
        processData: false,
        contentType: false,
        enctype: 'multipart/form-data',
        type: 'POST',
        beforeSend: function() {
            // add event or loading animation
        },
        success: function(data) {
            $btn.button('reset');
            var patt = /Error|error|Kesalahan|Alert/g;
            var result = patt.test(data);
            if (result === false) {
                swal('',data,'success');
                oSearch();
            } else {
                swal('', data, 'error');
            }
            return false;
        },
        error: function(e) {
            $btn.button('reset');
            swal('', data, 'error');
        }
    });
    return false;
}
</script>
