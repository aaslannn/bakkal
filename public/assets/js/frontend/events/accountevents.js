function triggerChangePassword(){
    $("#ReadAddCommentTab").trigger("click");
}

(function () {
    "use strict";

    if (checkpage.check(".AccountSettings"))
    {
        var maskedInputOptions = {
            autoclear: false
        };
        /*$(".KimlikNo").mask("99999999999", maskedInputOptions);*/
        $(".TelefonNo").mask("(999) 999 99 99", maskedInputOptions);
        $(".Dob").mask("99-99-9999", maskedInputOptions);
    }


}());