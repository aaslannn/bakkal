/*global $,MEApp*/
MEApp.helpers.raiting = (function () {
    "use strict";
    var rate = function (container, onClickFunction) {
        var selfIndex = 0,
            rate = 0;

        container = $(container);

        container.find("a").on("mouseenter", function () {
            var self = $(this);
            selfIndex = self.index();
            container.find("a").removeClass("Selected");
            container.find("a:lt(" + (selfIndex + 1) + ")").addClass("Selected");
        });
        
        container.on("click", function () {
            rate = (selfIndex + 1);
            if ($.isFunction(onClickFunction)) {
                onClickFunction(rate);
            }
        });

        container.on("mouseleave", function () {
            container.find("a").removeClass("Selected");
            if (rate > 0) {
                container.find("a:lt(" + rate + ")").addClass("Selected");
            }
        });
    };
    return {
        rate: rate
    };
}(MEApp.helpers.raiting));
var raiting = MEApp.helpers.raiting;
