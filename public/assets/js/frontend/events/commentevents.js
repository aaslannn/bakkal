/*global $*/
(function () {
    "use strict";
    var rationOnClickFN = function (rate) {
        $('#ratings-hidden').val(rate);
    };

    $(document).on("click", ".BtnAddComment", function () {
        var self = $(this),
            parentContainer = self.parents(".AddCommentHeading");
        parentContainer.next(".form-group").slideToggle(150);
    });

    if (checkpage.check(".ProductDetail")) {
        $(document).on("click", "#ReadAddComment", function () {
            $("#ReadAddCommentTab").trigger("click");
        });
        raiting.rate(".RateProduct", rationOnClickFN);
    }

	$(".DelReview").on("click", function(){
		var pId = $(this).data("prd-id");
		var rId = $(this).data("id");
		var pSefurl = $(this).data("psefurl");
		var _token = $('input[name="_token"]').val();
		
		$.ajax({
			url: '/islem',
            type: 'post',
            data: {pId : pId, rId: rId, pSefurl: pSefurl, _token:_token, islem:'delReview'},
            dataType: "json",
            beforeSend: function(xhr){
                var token = $('meta[name="csrf_token"]').attr('content');
                if(token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            success: function(data){
				if(!data.success) {
					alert(data.message);
					return false;
				}
				alert(data.message);
				window.location.reload();
            },
            error: function(){
                alert('Bir hata oluştu. Daha sonra tekrar deneyiniz.');
            }
		});
	});

    $(".EditReview").on("click", function(){
        var id = $(this).data("id");
        $("#Comment"+id).removeClass("hide");
    });

    $(".ChangeReview").on("click", function(){
        var rId = $(this).data("id");
        var pId = $(this).data("prd-id");
        var comment = $("#comment"+rId).val();
        var _token = $('input[name="_token"]').val();

        if(comment.length < 10)
        {
            alert('Yorumunuz en az 10 karakter olmalıdır.');
            return false;
        }

        $.ajax({
            url: '/islem',
            type: 'post',
            data: {pId : pId, rId: rId, comment: comment, _token:_token, islem:'changeReview'},
            dataType: "json",
            beforeSend: function(xhr){
                var token = $('meta[name="csrf_token"]').attr('content');
                if(token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            success: function(data){
                if(!data.success) {
                    alert(data.message);
                    return false;
                }
                alert(data.message);
                window.location.reload();
            },
            error: function(){
                alert('Bir hata oluştu. Daha sonra tekrar deneyiniz.');
            }
        });

    });
}());