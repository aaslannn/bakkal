/*global $,console*/
var HorizontalSlider = function () {
    "use strict";
    var container, wrapper, item, itemCount, resetWrapper, wrapperMoveLast, init, prevEvent, nextEvent, checkAction = 0;

    resetWrapper = function () {
        wrapper.css({
            "left": -(item.width() * itemCount)
        });
        container.find(".SliderItem").removeClass("active");
        container.find(".SliderItem:nth-child(" + (itemCount + 1) + ")").addClass("active");
    };

    wrapperMoveLast = function () {
        wrapper.css({
            "left": -(wrapper.width() - (item.width() * (itemCount * 2)))
        });
        container.find(".SliderItem").removeClass("active");
        container.find(".SliderItem:nth-last-child(" + (itemCount * 2) + ")").addClass("active");
    };

    prevEvent = function () {
        var prevBtn = container.find(".SliderControls").find("a.prev");


        prevBtn.on("click", function () {
            if (checkAction === 0) {
                checkAction = 1;
                var wrapperPosition = wrapper.position();
                wrapper.animate({
                    "left": wrapperPosition.left + item.width()
                }, function () {
                    wrapperPosition = wrapper.position();
                    if (wrapperPosition.left === 0) {
                        wrapperMoveLast();
                    } else {
                        container.find(".active").prev(".SliderItem").addClass("active").siblings().removeClass("active");
                    }
                    checkAction = 0;
                });
            }

            return false;
        });
    };

    nextEvent = function () {
        var nextBtn = container.find(".SliderControls").find("a.next");
        nextBtn.on("click", function () {
            if (checkAction === 0) {
                checkAction = 1;
                var wrapperPosition = wrapper.position();
                wrapper.stop().animate({
                    "left": wrapperPosition.left - item.width()
                }, function () {
                    wrapperPosition = wrapper.position();
                    if (wrapperPosition.left === -(wrapper.width() - (item.width() * itemCount))) {
                        resetWrapper();
                    } else {
                        container.find(".active").next(".SliderItem").addClass("active").siblings().removeClass("active");
                    }
                    checkAction = 0;
                });
            }

            return false;
        });
    };

    init = function (cnt, showncount) {
        container = $(cnt);

        itemCount = showncount || 3;

        var itemLength = 0,
            itemRealLenght = container.find(".SliderItem").length,
            wrapperHeight = 0;

        wrapper = container.find(".HorizontalSliderWrapper");
        item = container.find(".SliderItem");

        function cloneItems() {
            var cloneFirstElements = wrapper.find(".SliderItem:lt(" + itemCount + ")").clone(),
                cloneLastElements = wrapper.find(".SliderItem:gt(-" + (itemCount + 1) + ")").clone();
            container.find(".HorizontalSliderWrapper").find(".SliderItem:first-child").addClass("active");
            if (itemRealLenght > showncount) {
                cloneFirstElements.appendTo(wrapper);
                cloneLastElements.prependTo(wrapper);
            }

            item = container.find(".SliderItem");
            itemLength = item.length;
        }
        cloneItems();




        function resizeItems() {
            var containerWidth = container.width(),
                activeItem = container.find(".SliderItem.active").index();
            item.width(containerWidth / itemCount);

            wrapper.width(itemLength * item.width());

            wrapperHeight = item.height();

            container.css({
                "min-height": wrapperHeight
            });

            container.find(".SliderControls").css({
                "margin-top": wrapperHeight
            });
            if (itemRealLenght > itemCount) {
                wrapper.css({
                    "left": -(item.width() * activeItem)
                });
            }

        }
        $(window).resize(function () {
            resizeItems();
        });

        resizeItems();
        if (itemRealLenght > itemCount) {
            resetWrapper();
        }

        if (itemRealLenght > itemCount) {
            prevEvent();
            nextEvent();
        } else {
            $(".SliderControls").css({
                "visibility": "hidden"
            });
        }

    };

    return {
        init: init
    };
};