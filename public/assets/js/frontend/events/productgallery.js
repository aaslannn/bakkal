/*global $*/
(function () {
    "use strict";
    $(document).on("click", ".ProductImageGallery .ImageThumbails a", function () {
        var self = $(this),
            wrapper = self.parents(".ProductImageGallery"),
            imageURL = self.attr("data-image-url");
        wrapper.find(".Loader").show();

        function loadImage(status) {
            wrapper.find(".ImageWrapper").find("img").attr("src", "");
            wrapper.find(".Loader").hide();
            if (status) {
                wrapper.find(".ImageWrapper").find("img").attr("src", imageURL);
            }
        }
        $.ajax({
            "url": imageURL,
            error: function () {
                loadImage(false);
            },
            success: function () {
                loadImage(true);
            }
        });
    });
}());
