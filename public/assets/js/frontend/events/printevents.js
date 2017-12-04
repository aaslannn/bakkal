/*global $*/
(function () {
    "use strict";
    $(document).on("click", ".BtnPrint", function () {
        var printHTML = $("#PrintArea").html(),
            printWindow = window.open("", "My Div", "width=600,height=600,scrollbars");
        printWindow.document.write("<html><head><link rel='stylesheet' href='http://www.meslekatolyem.com/assets/css/print.css'/></head><body>" + printHTML + "</body></html>");
        printWindow.document.close();
        printWindow.focus();
    });
}());