/*global $,MEApp,createProductList,categoryFilterServices*/
MEApp.controllers.categoryListFilter = (function () {
    "use strict";
    var pagingSelect = 1;
    var productListCallBack = function (data) {
        createProductList.createHTML(data, pagingSelect);
    };
    var productList = function () {
        categoryFilterServices.newProductFilter("getProducts", productListCallBack);
    };
    var newProductList = function (filterModel, selected) {
        pagingSelect = selected;
        console.log(filterModel);
        /*filterType = filterType + ".json";
        console.log(filterType);
        categoryFilterServices.newProductFilter(filterType, productListCallBack);*/
        categoryFilterServices.newProductFilter("product.json", productListCallBack);
    };
    return {
        productList: productList,
        newProductList: newProductList
    };
}(MEApp.controllers.categoryListFilter));
var categoryListFilter = MEApp.controllers.categoryListFilter;