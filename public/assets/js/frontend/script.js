/*global $,checkpage,HorizontalSlider,remainder,raiting*/
(function () {
    "use strict";
    /*slider autoplay*/
    if (checkpage.check(".HomePage")) {
        $("#BestSelling,#HeroCarousel").carousel();
        var DiscountProduct = new HorizontalSlider();
        imagesLoaded($("#DiscountProduct"), function () {
            DiscountProduct.init("#DiscountProduct", 4);
        });
    }
    if (checkpage.check(".CategoryList")) {
        remainder.calculate();
    }

    if(checkpage.check(".LoginContainer")){
        $("#loginform").validate();
    }

}());