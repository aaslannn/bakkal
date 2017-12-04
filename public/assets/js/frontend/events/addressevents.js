/*global $*/
(function () {
    "use strict";
    var maskedInputOptions = {
        autoclear: false
    };
    $("#addressForm").validate();
    /*$(".KimlikNo").mask("99999999999", maskedInputOptions);*/
    $(".TelefonNo").mask("(999) 999 99 99", maskedInputOptions);

}());
