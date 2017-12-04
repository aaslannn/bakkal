/*global $*/
(function () {
    "use strict";
    $(document).on("click", ".panel-heading a", function () {
        var self = $(this);
        $(".panel-title").removeClass("Opened");
        self.parents(".panel-title").toggleClass("Opened");
    });
}());