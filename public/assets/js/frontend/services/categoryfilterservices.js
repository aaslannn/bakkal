/*global $,MEApp*/
MEApp.services.categoryFilter = (function () {
    "use strict";

    var newProductFilter = function (url, callBackFunction) {
        $.ajax({
            "url": rootURL + url,
            "dataType": "json",
            success: function (data) {
                if ($.isFunction(callBackFunction)) {
                    callBackFunction(data);
                }
            },
            error: function (xhr, status, error) {
                console.log("not loaded");
                console.log("xhr", xhr);
                console.log("status", status);
                console.log("error", error);
            }
        });
    };

    return {
        newProductFilter: newProductFilter
    };
}(MEApp.services.categoryFilter));
var categoryFilterServices = MEApp.services.categoryFilter;