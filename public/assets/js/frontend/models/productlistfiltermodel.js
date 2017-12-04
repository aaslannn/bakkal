/*global $,MEApp,createProductList,categoryFilterServices*/
MEApp.models.categoryListFilterModel = (function () {
    "use strict";

    function filterList() {
        var filterData = {},
            brandARR = [],
            orderBy = $(".CategoryListHeading .btn-group a.Selected").attr("data-filter") || null,
            pagingStatus = parseInt($(".CategoryListPagination li.active a").text(), 10);
        filterData.orderBy = orderBy;
        filterData.pagingStatus = pagingStatus;
        $(".Brands input[name='brands']").each(function (i, e) {
            if ($(e).prop("checked")) {
                brandARR.push(e.value);
            }
        });
        filterData.brands = brandARR;
        $(".AdditionalFilters input[type='checkbox']").each(function (i, e) {
            var thisName = $(e).attr("name");
            if ($(e).prop("checked")) {
                filterData[thisName] = 1;
            } else {
                filterData[thisName] = 0;
            }
        });
        $(".PriceRange input[type='text']").each(function (i, e) {
            var thisName = $(e).attr("name");
            filterData[thisName] = $(e).val() || null;
        });
        return filterData;
    }
    return {
        filterList: filterList
    };
}(MEApp.models.categoryListFilterModel));
var categoryListFilterModel = MEApp.models.categoryListFilterModel;