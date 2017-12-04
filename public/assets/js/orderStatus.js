
var left_side_width = 220; //Sidebar width in pixels

$(function() {
    "use strict";

    $(document).on("change", ".orderStatus", function () {
        var id = $(this).attr("data-id");
        var durum = $(this).val();
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: '/admin/changeStatus',
            type: 'post',
            data: {id : id, durum : durum, _token:_token},
            dataType: "html",
            beforeSend: function(xhr){
                var token = $('meta[name="csrf_token"]').attr('content');
                if(token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            success: function(data){
                alert(data);
            },
            error: function(){
                alert('Bir hata oluştu. Daha sonra tekrar deneyiniz.');
            }
        });
    });
});