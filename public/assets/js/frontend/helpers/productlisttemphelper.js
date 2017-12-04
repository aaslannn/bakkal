/*global $,MEApp,remainder*/
MEApp.helpers.productlisttemphelper = (function () {
    "use strict";

    function createPagination(data, selected) {
        var createLi = function () {
                var li = $("<li>");
                return li;
            },
            createLink = function () {
                var link = $("<a>");
                return link;
            },
            createSpan = function () {
                var span = $("<span>");
                return span;
            },
            loop = 0;
        $(".CategoryListPagination ul").empty();

        function createArrow(direction) {
            var link = createLink(),
                li = createLi(),
                span = createSpan();
            link.attr("href='#'");
            link.addClass(direction);
            span.html("<i class='fa fa-chevron-" + direction + "'></i>");
            span.appendTo(link);
            link.appendTo(li);
            li.appendTo(".CategoryListPagination ul");
        }
        createArrow("left");
        for (loop; loop < data; loop = loop + 1) {
            var link = createLink(),
                li = createLi();
            if (loop === selected - 1) {
                li.addClass("active");
            }
            link.text(loop + 1);
            link.appendTo(li);
            li.appendTo(".CategoryListPagination ul");
        }
        createArrow("right");
    }
    var createHTML = function (data, pagingSelect) {
        var createDiv = function (classname) {
                classname = classname || "";
                var div = $("<div>");
                div.addClass(classname);
                return div;
            },
            createLink = function (classname) {
                classname = classname || "";
                var link = $("<a>");
                link.addClass(classname);
                return link;
            },
            createImg = function (classname) {
                classname = classname || "";
                var img = $("<img/>");
                img.addClass(classname);
                return img;
            },
            createSpan = function (classname) {
                classname = classname || "";
                var span = $("<span>");
                span.addClass(classname);
                return span;
            },
            listData = data.productlist,
            pagingData = data.pagecount;
        $(".CategoryListWrapper>.row").empty();
        $.each(listData, function (i, e) {
            var img = createImg(),
                imageLink = createLink(),
                newWrapper = createSpan("New"),
                productMediaWrapper = createDiv("ProductMediaWrapper"),
                product = createDiv("Product"),
                productWrapper = createDiv("col-md-4 ProductWrapper"),
                productCaption = createDiv("ProductCaption"),
                productCaptionRow = createDiv("row"),
                priceText = createSpan(),
                price = createDiv("price"),
                discountPrice = createSpan("line-through"),
                textRight = createDiv("col-xs-6 text-right"),
                textLeft = createDiv("col-xs-6 text-left"),
                damping = createDiv("Damping"),
                title = createLink();

            img.attr("src", e.image);
            imageLink.attr("href", e.url);
            if (e.newStatus) {
                newWrapper.text("Yeni");
                newWrapper.appendTo(imageLink);
            }
            img.appendTo(imageLink);
            imageLink.appendTo(productMediaWrapper);
            productMediaWrapper.appendTo(product);
            priceText.text(e.price);
            priceText.appendTo(price);

            if (e.discount) {
                damping.text(e.damping);
                damping.appendTo(textRight);
                discountPrice.text(e.discountPrice);
                discountPrice.prependTo(price);
                price.appendTo(textLeft);
                textRight.appendTo(productCaptionRow);
                textLeft.appendTo(productCaptionRow);
                productCaptionRow.appendTo(productCaption);
            } else {
                price.appendTo(productCaption);
            }
            title.text(e.title).attr("url", e.url);
            title.appendTo(productCaption);
            productCaption.appendTo(product);

            product.appendTo(productWrapper);
            productWrapper.appendTo(".CategoryListWrapper>.row");
        });
        createPagination(pagingData, pagingSelect);
        remainder.calculate();
    };
    return {
        createHTML: createHTML
    };
}(MEApp.helpers.productlisttemphelper));
var createProductList = MEApp.helpers.productlisttemphelper;