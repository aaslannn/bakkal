/*global $,MEApp*/
MEApp.helpers.remainder = (function () {
    "use strict";
    var calculate = function () {
        var remainder = $(".CategoryListWrapper.Thumbnail .ProductWrapper").length % 3;
        if (remainder !== 0) {
            $(".CategoryListWrapper.Thumbnail .ProductWrapper:gt(-" + (remainder + 1) + ")").addClass("noborder");
        } else {
            $(".CategoryListWrapper.Thumbnail .ProductWrapper:gt(-4)").addClass("noborder");
        }
    };
    return {
        calculate: calculate
    };
}(MEApp.helpers.remainder));
var remainder = MEApp.helpers.remainder;