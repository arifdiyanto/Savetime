<script type="text/javascript">
$("#document").ready(function() {
    // $(".clear").val('');
});

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
            $("#div1").html(data);
            return false;
        },
        error: function(e) {
            $btn.button('reset');
        }
    });
    return false;
}
</script>
<form id="frm" method="POST" action="CIndex/buildScript">
    <label>Table Name</label>
    <input type="text" name="table" class="form-control input-sm must clear">
    <label>Raw Fields</label><code>Pisahkan dengan koma</code>
    <textarea name="fields" class="form-control input-sm must clear" rows="5" placeholder="Contoh : `kode`,`nama`,`created_date`">
    </textarea><br>
    <button type="button" id="btn-save" class="btn btn-sm btn-default" onclick="oSave();"><i class="fa fa-flash"></i> Generate</button>
</form>
<div class="" id="div1"></div>
