$(document).ready(function() {
    oSetInputValidation();

});

function oSetInputValidation() {
    $('.numeric').keyup(function() {
        this.value = this.value.replace(/[^0-9\.]/g, '');
    });
    $('.letteric').bind('keyup blur', function() {
        var node = $(this);
        node.val(node.val().replace(/[^a-z]/g, ''));
    });
    $('.text-uppercase').keyup(function() {
        this.value = this.value.toUpperCase();
    });
    $('.text-uppercase').focusout(function() {
        this.value = this.value.toUpperCase();
    });
    $('.date').datepicker({
        format: 'yyyy/mm/dd',
        orientation: "auto",
        autoclose: true,
        todayHighlight: true
    });
    $('.date-ym').datepicker({
        format: "yyyy/mm",
        viewMode: "months",
        minViewMode: "months",
        autoclose: true
    });
    $('.date-m').datepicker({
        format: "mm",
        viewMode: "months",
        minViewMode: "months",
        autoclose: true
    });
    $('.date-y').datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years",
        autoclose: true
    });

}

function fNum(a) {
    var x = a.toString().split('.')
    a = x[0]
    b = a.replace(/[^\d]/g, "");

    if (b < -922337203685477 || b > 922337203685477) {
        b = "922337203685477";
    }
    c = "";
    panjang = b.length;
    j = 0;
    for (i = panjang; i > 0; i--) {
        j = j + 1;
        if (((j % 3) == 1) && (j != 1)) {
            c = b.substr(i - 1, 1) + "," + c;
        } else {
            c = b.substr(i - 1, 1) + c;
        }
    }
    if (x[1] == undefined) {
        ret = c;
    } else {
        ret = c + '.' + x[1];
    }
    return ret;
}

function oLoadPagination(selector, fn) {
    $(selector + ' .pagination a').on('click', function(event) {
        event.preventDefault();
        if ($(this).attr('href') != '#') {
            // $("html, body").animate({
            //     scrollTop: 0
            // }, "fast");
            $(selector).load($(this).attr('href'), function() {
                oLoadPagination(selector, fn);
            });
        }
    });
    if (fn) fn();
}

function copyToClipboard(element) {
    var $temp = $("<textarea>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
}
