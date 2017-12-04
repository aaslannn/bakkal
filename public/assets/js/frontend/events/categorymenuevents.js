/*global $*/
(function () {
    "use strict";
    /*body takes css class(noscroll) when CategoryMenuCover visible*/
    $(document).on("mouseenter", ".ProductMenu a", function () {
        $(".CategoryList").removeClass("open");
        $("body").removeClass("NoScroll");
    })
    document.addEventListener("click", function () {
        if ($(".CategoryList").hasClass("open")) {
            $("body").addClass("NoScroll");
        } else {
            $("body").removeClass("NoScroll");
        }
    });
}());