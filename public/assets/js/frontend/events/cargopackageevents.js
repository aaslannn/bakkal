/*global $*/
(function () {
    "use strict";
    if (checkpage.check(".CargoPackageDetail"))
    {
        $("#teslimatForm").validate();
        $("#odemeForm").validate();

        var maskedInputOptions = {
            autoclear: false
        };
        /*$(".KimlikNo").mask("99999999999", maskedInputOptions);*/
        $(".TelefonNo").mask("(999) 999 99 99", maskedInputOptions);
        $(".KartNo").mask("9999-9999-9999-9999", maskedInputOptions);
        $(".GuvenlikKodu").mask("999", maskedInputOptions);

        $(document).on("click",".nav-tabs li a",function(){
            var self=$(this),
                thisDataID=self.attr("data-id");
            $("input[name='odemeTuru']").val(thisDataID);
        });

        $(document).on("click", ".BillinAddressInput", function () {
            var self = $(this),
                checkbox = self.find("input"),
                checkboxStatus = checkbox.prop("checked");
            $(".BillingAddress .Cover").hide();
            if(checkboxStatus){
                $(".BillingAddress .Cover").show();
            }
        });

        $(".SelectBillinType").on("change", function () {
            var self = $(this),
                billingTypeValue = self.val();
            if (billingTypeValue === "1") {
                $(".fbireysel").removeClass("hide");
                $(".fkurumsal").addClass("hide");
            } else if (billingTypeValue === "2") {
                $(".fbireysel").addClass("hide");
                $(".fkurumsal").removeClass("hide");
            }
        });

        $(document).on("change", "#adres", function () {
            var adres = $('#adres').val();
            if(adres === "-1") 
                $("#addressContainer").removeClass("hide");
            else
                $("#addressContainer").addClass("hide");
            if(adres > 0)
            {              
                var _token = $('input[name="_token"]').val();
                var uId = $('#uId').val();

                $.ajax({
                    url: '/islem',
                    type: 'post',
                    data: {adres : adres, uid: uId, _token:_token, islem:'getAdres'},
                    dataType: "json",
                    beforeSend: function(xhr){
                        var token = $('meta[name="csrf_token"]').attr('content');
                        if(token) {
                            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    success: function(data){
                        $('#alici_adi').val(data.name);
                        $('#country').val(data.country_id);
                        $('#state').val(data.state);
                        $('#city').val(data.city_id);
                        $('#town').val(data.town);
                        $('#address').val(data.adres);
                        $('#tel').val(data.tel);
                        $('#tckimlik').val(data.tckimlik);
                    },
                    error: function(){
                        alert('Bir hata oluştu. Daha sonra tekrar deneyiniz.');
                    }
                });
            }
        });

        $(document).on("change", "#fadres", function () {
            var adres = $('#fadres').val();
            if(adres === "-1") 
                $("#faddressContainer").removeClass("hide");
            else
                $("#faddressContainer").addClass("hide");
            
            if(adres > 0) {
                var _token = $('input[name="_token"]').val();
                var uId = $('#uId').val();

                $.ajax({
                    url: '/islem',
                    type: 'post',
                    data: {adres: adres, uid: uId, _token: _token, islem: 'getAdres'},
                    dataType: "json",
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');
                        if (token) {
                            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    success: function (data) {
                        $('#fisim').val(data.name);
                        $('#fcountry').val(data.country_id);
                        $('#fstate').val(data.state);
                        $('#fcity').val(data.city_id);
                        $('#ftown').val(data.town);
                        $('#faddress').val(data.adres);
                        $('#ftel').val(data.tel);
                        $('#ftckimlik').val(data.tckimlik);
                        $('#vergid').val(data.vergid);
                        $('#vergino').val(data.vergino);
                        //$('#ftype').val(data.type);
                        $(".SelectBillinType").val(data.type).trigger('change');

                    },
                    error: function () {
                        alert('Bir hata oluştu. Daha sonra tekrar deneyiniz.');
                    }
                });
            }
        });

        $(document).on("click", "#addNewAddress", function () {
            if($('#adres').val() === "-1")
            {
                var data = {};
                data['title'] = $('input[name="adres_adi"]').val();
                data['name'] = $('input[name="alici_adi"]').val();
                data['country_id'] = $('#country').val();
                data['state'] = $('input[name="state"]').val();
                data['city_id'] = $('input[name="city"]').val();
                data['town'] = $('input[name="town"]').val();
                data['adres'] = $('#address').val();
                data['tel'] = $('input[name="tel"]').val();
                data['tckimlik'] = $('input[name="tckimlik"]').val();
                data['type'] = 1;
                data['_token'] = $('input[name="_token"]').val();
                data['islem'] = 'addNewAddress';

                $.ajax({
                    url: '/islem',
                    type: 'post',
                    data: data,
                    dataType: "json",
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');
                        if (token) {
                            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    success: function (data) {
                        if(data.success)
                        {
                            $('.addressResult').html('<div class="alert alert-success alert-dismissable margin5"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+data.success+'</div>');
                            addressFill(1,data.id);
                            $("#addressContainer").addClass("hide");
                        }
                        else if(data.error)
                            $('.addressResult').html('<div class="alert alert-warning alert-dismissable margin5"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+data.error+'</div>');
                    }
                });
            }
        });

        $(document).on("click", "#addNewAddressf", function () {
            if($('#fadres').val() === "-1")
            {
                var data = {};
                data['title'] = $('input[name="fadres_adi"]').val();
                data['name'] = $('input[name="fisim"]').val();
                data['country_id'] = $('#fcountry').val();
                data['state'] = $('input[name="fstate"]').val();
                data['city_id'] = $('input[name="fcity"]').val();
                data['town'] = $('input[name="ftown"]').val();
                data['adres'] = $('#faddress').val();
                data['tel'] = $('input[name="ftel"]').val();
                data['tckimlik'] = $('input[name="ftckimlik"]').val();
                data['vergid'] = $('input[name="vergid"]').val();
                data['vergino'] = $('input[name="vergino"]').val();
                data['type'] = 2;
                data['_token'] = $('input[name="_token"]').val();
                data['islem'] = 'addNewAddress';

                $.ajax({
                    url: '/islem',
                    type: 'post',
                    data: data,
                    dataType: "json",
                    beforeSend: function (xhr) {
                        var token = $('meta[name="csrf_token"]').attr('content');
                        if (token) {
                            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    success: function (data) {
                        if(data.success)
                        {
                            $('.faddressResult').html('<div class="alert alert-success alert-dismissable margin5"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+data.success+'</div>');
                            addressFill(2,data.id);
                            $("#faddressContainer").addClass("hide");
                        }
                        else if(data.error)
                            $('.faddressResult').html('<div class="alert alert-warning alert-dismissable margin5"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>'+data.error+'</div>');
                    }
                });
            }
        });


        //if the bank makes inst., get instalment informations
        $(document).on("change", "#posId", function () {
            var posId = $('#posId').val();
            if(posId > 0)
            {
                var topTutar = $('#topTutar').val();
                var _token = $('input[name="_token"]').val();

                $.ajax({
                    url: '/islem',
                    type: 'post',
                    data: {posId : posId, topTutar : topTutar, _token:_token, islem:'getInstalments'},
                    dataType: "json",
                    beforeSend: function(xhr){
                        var token = $('meta[name="csrf_token"]').attr('content');
                        if(token) {
                            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    success: function(data){
                        $('#Instalments').html('');
                        $('#Instalments').append($("<option></option>").attr("value",1).text("Tek Ödeme"));
                        $.each(data, function(key,value){
                            if (value != '-') $('#Instalments').append($("<option></option>").attr("value",key).text(key+' Taksit'));
                        });
                    },
                    error: function(){
                        alert('Bir hata oluştu. Daha sonra tekrar deneyiniz.');
                    }
                });
            }
            else
            {
                $('#Instalments').html('');
                $('#Instalments').append($("<option></option>").attr("value",1).text("Tek Ödeme"));
            }
        });
    }


}());

function addressFill(type,id)
{
    var _token = $('input[name="_token"]').val();

    $.ajax({
        url: '/islem',
        type: 'post',
        data: {type : type, id : id,  _token:_token, islem:'addressFill'},
        dataType: "json",
        beforeSend: function(xhr){
            var token = $('meta[name="csrf_token"]').attr('content');
            if(token) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', token);
            }
        },
        success: function(data){
            if(data.type == 1)
            {
                $('#adres').html('');
                $('#adres').append($("<option></option>").attr("value",0).text("Seçiniz.."));
                $('#adres').append($("<option></option>").attr("value",-1).text("Yeni Oluştur"));
                $.each(data.addresses, function(key,value){
                    if(data.id == key)
                        $('#adres').append($("<option></option>").attr("value",key).attr("selected","selected").text(value));
                    else
                        $('#adres').append($("<option></option>").attr("value",key).text(value));
                });
            }
            else if(data.type == 2)
            {
                $('#fadres').html('');
                $('#fadres').append($("<option></option>").attr("value",0).text("Seçiniz.."));
                $('#fadres').append($("<option></option>").attr("value",-1).text("Yeni Oluştur"));
                $.each(data.addresses, function(key,value){
                    if(data.id == key)
                        $('#fadres').append($("<option></option>").attr("value",key).attr("selected","selected").text(value));
                    else
                    $('#fadres').append($("<option></option>").attr("value",key).text(value));
                });
            }

        },
        error: function(){
            alert('Bir hata oluştu. Daha sonra tekrar deneyiniz.');
        }
    });
}
