/*global $,categoryListFilterModel,categoryListFilter*/
(function () {
    "use strict";
    categoryListFilter.productList();

    $(".CategoryListHeading .btn-group a").on("click", function () {
        var self = $(this),
            pagingSelected = $(".CategoryListPagination li.active a").text(),
            filterModel = null;
        self.addClass("Selected").siblings().removeClass("Selected");
        filterModel = categoryListFilterModel.filterList();
        categoryListFilter.newProductList(filterModel, pagingSelected);
    });
    $(".BtnFilterList").on("click", function () {
        var pagingSelected = $(".CategoryListPagination li.active a").text(),
            filterModel = categoryListFilterModel.filterList();
        categoryListFilter.newProductList(filterModel, pagingSelected);
    });
    $(document).on("click", ".CategoryListPagination li a", function (e) {
        var self = $(this),
            parentLi = self.parent("li"),
            text = self.text(),
            className = self.attr("class"),
            filterModel = categoryListFilterModel.filterList();

        if (className === undefined) {
            categoryListFilter.newProductList(filterModel, text);
        } else {
            var selectedLi = $(".CategoryListPagination li.active").index(),
                liCount = $(".CategoryListPagination li").length;
            if (self.hasClass("left")) {
                if (selectedLi > 1) {
                    $(".CategoryListPagination li.active").prev("li").find("a").trigger("click");
                }
            } else if (self.hasClass("right")) {
                if (selectedLi + 1 < liCount - 1) {
                    $(".CategoryListPagination li.active").next("li").find("a").trigger("click");
                }
            }
        }
    });
}());