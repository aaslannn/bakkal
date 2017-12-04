/*global $*/
(function () {
    "use strict";
    $(document).on("click", ".AddFavorite", function () {
        var id = $(this).attr("data-id");
        var _token = $('input[name="_token"]').val();
        var uId = $('#uId').val();
        //$('.AddFavoriteText').html('Favori Listenize Ekleniyor..');

        $.ajax({
            url: '/islem',
            type: 'post',
            data: {id : id, uId : uId, _token:_token, islem:'addFavorite'},
            dataType: "html",
            beforeSend: function(xhr){
                var token = $('meta[name="csrf_token"]').attr('content');
                if(token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            success: function(data){
                $('.AddFavoriteText').html(data);
            },
            error: function(){
                alert('Bir hata oluştu. Daha sonra tekrar deneyiniz.');
            }
        });

    });
}());