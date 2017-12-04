/*global $*/
(function () {
    "use strict";
    $(document).on("click", ".SwicthView a", function () {
        var self = $(this),
            thisName = self.attr("data-name"),
            parentWrapper = self.parents(".CategoryListHeading"),
            _token = $('input[name="_token"]').val();

        self.addClass("Selected").siblings().removeClass("Selected");
        parentWrapper.next(".CategoryListWrapper").removeClass("Table Thumbnail").addClass(thisName);

        $.ajax({
            url: '/islem',
            type: 'post',
            data: {catStyle : thisName, _token:_token, islem:'changeCatStyle'},
            dataType: "json",
            beforeSend: function(xhr){
                var token = $('meta[name="csrf_token"]').attr('content');
                if(token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            success: function(data){
               //
            },
        });
    });

    $(".PriceFormat").priceFormat({
        prefix:"",
        //centsSeparator:",",
        centsLimit: 0,
        thousandsSeparator:"."
    });

}());