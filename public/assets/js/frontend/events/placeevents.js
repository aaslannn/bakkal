/*global $*/
(function () {
    "use strict";

    $(document).on("change", "#country", function () {
        var country = $('#country').val();
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url: '/islem',
            type: 'post',
            data: {country : country, _token:_token, islem:'getCity'},
            dataType: "json",
            beforeSend: function(xhr){
                var token = $('meta[name="csrf_token"]').attr('content');
                if(token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            success: function(data){
                $('#city').html('');
                $('#city').append($("<option></option>").attr("value",0).text("Seçiniz.."));
                $.each(data, function(key,value){
                    $('#city').append($("<option></option>").attr("value",key).text(value));
                });
            },
            error: function(){
                alert('Bir hata oluştu. Daha sonra tekrar deneyiniz.');
            }
        });
    });

}());