/*global $*/
(function () {
    "use strict";

    if (checkpage.check(".ProductDetail")) {

        //refresh cart script at product page start
        $(function () {
            $.ajax({
                url: '/islem',
                type: 'post',
                data: {islem:'getCartCount'},
                dataType: "html",
                beforeSend: function(xhr){
                    var token = $('meta[name="csrf_token"]').attr('content');
                    if(token) {
                        return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                success: function(data){
                    $('.badge').html(data);
                }
            });
        });

        $(document).on("click", "#CartButton", function () {
            addToCart();
        });

        $(document).on("click", "#OrderNow", function () {
            addToCart("/sepet");
        });
    }

    if (checkpage.check(".MyCart")) {

        $(".QuantityLimit").keyup(function(){
            var qty =  $(this).val();
            var id = $(this).attr('id');
            var pId = $(this).data('pid');
            $.ajax({
                url: '/islem',
                type: 'post',
                data: {qty : qty, pId : pId, id : id, islem:'stockControl'},
                dataType: "json",
                beforeSend: function(xhr){
                    var token = $('meta[name="csrf_token"]').attr('content');
                    if(token) {
                        return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                success: function(data){
                    if(data.qty)
                    {
                        $('#'+data.id).val(data.qty);
                    }

                },
                error: function(){
                    alert('Bir hata oluştu. Daha sonra tekrar deneyiniz.');
                }
            });
        });



        $(document).on("click", "#addProCode", function () {
            var indKod = $('#code').val();
            var exCode = $('input[name="indCode"]').val();
            var lang = $('input[name="lang"]').val();
            if(indKod == '')
            {
                if(lang == 'tr')
                    $('.PromoCodeResult').html('<div class="alert alert-warning alert-dismissable margin5"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Lütfen geçerli bir indirim kodu giriniz.</div>');
                else
                    $('.PromoCodeResult').html('<div class="alert alert-warning alert-dismissable margin5"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Please enter a valid promo code.</div>');
                return false;
            }
            if(exCode != '')
            {
                if(lang == 'tr')
                    $('.PromoCodeResult').html('<div class="alert alert-success alert-dismissable margin5"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Promosyon kodunuz eklenmiştir. İndiriminiz uygulanacaktır.</div>');
                else
                    $('.PromoCodeResult').html('<div class="alert alert-success alert-dismissable margin5"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Promotion Code has already been added. Discount will be applied.</div>');
                return false;
            }

            var topTutar = $('input[name="topTutar"]').val();
            var topHvlTutar = $('input[name="topHvlTutar"]').val();
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: '/islem',
                type: 'post',
                data: {indKod : indKod, topTutar : topTutar, topHvlTutar : topHvlTutar, _token:_token, islem:'addDisCode'},
                dataType: "json",
                beforeSend: function(xhr){
                    var token = $('meta[name="csrf_token"]').attr('content');
                    if(token) {
                        return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                success: function(data){
                    if(data.success)
                    {
                        $('input[name="topTutar"]').val(data.total);
                        $('input[name="topHvlTutar"]').val(data.hvltotal);
                        $('#indCode').val(data.code);
                        $('.total').html('₺ '+ data.total);
                        $('.hvltotal').html('₺ ' + data.hvltotal);
                        $(".DiscountCode").removeClass("hide");
                        $('.PromoCode').html('<div class="has-error margin5 mr-10 ml-10 PromoCodeResult"><div class="alert alert-success alert-dismissable margin5"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data.success+'</div></div>');

                    }
                    else if(data.error)
                    {
                        $(".DiscountCode").addClass("hide");
                        $('.PromoCodeResult').html('<div class="alert alert-danger alert-dismissable margin5"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'+data.error+'</div>');
                    }
                },
                error: function(){
                    alert('Bir hata oluştu. Daha sonra tekrar deneyiniz.');
                }
            });

        });

        $(document).on("click", "#delCart", function () {
            var delId = $(this).data('id');
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: $(this).data('url'),
                type: 'post',
                data: {rowId : delId, _token:_token},
                dataType: "html",
                beforeSend: function(xhr){
                    var token = $('meta[name="csrf_token"]').attr('content');
                    if(token) {
                        return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                success: function(data){
                    window.location.reload(true);
                },
                error: function(){
                    alert('Bir hata oluştu. Daha sonra tekrar deneyiniz.');
                }
            });

        });
    }

}());

function addToCart(go)
{
    var myForm = $("#addCart");
    $.ajax({
        url: myForm.attr("action"),
        type: 'post',
        data: myForm.serialize(),
        dataType: "json",
        beforeSend: function(xhr){
            var token = $('meta[name="csrf_token"]').attr('content');
            if(token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        success: function(data){
            if(go != null)
            {
                //location.href = go;
                window.location = go;
            }
            $('.result').html('');
            if(data.success)
            {
                $('.result').append('<div class="alert alert-success alert-dismissable margin5"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+data.success+'</div>');
            }
            if(data.nostock)
            {
                $('#addCart').html('');
             }
            if(data.warning)
            {
                $('.result').append('<div class="alert alert-warning alert-dismissable margin5"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+data.warning+'</div>');
            }
            $('.badge').html(data.count);
        },
        error: function(){
            $('.result').html('<div class="alert alert-danger margin5"><strong>Hata:</strong> Bir hata oluştu. Daha sonra tekrar deneyiniz.</div>');
        }
    });
}