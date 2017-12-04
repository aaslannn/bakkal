(function () {
    "use strict";
    var textAreaCountLimit = 300;
    $(".InputWrapper .InputTools .Counter span:last-child").text(textAreaCountLimit);
    $(".InputWrapper textarea").on("keyup", function () {
        var self = $(this),
            wrapper = self.parents(".InputWrapper"),
            countInfo = wrapper.find(".InputTools .Counter span:first-child"),
            currentCount = self.val().length;
        if (currentCount > textAreaCountLimit) {
            self.val(self.val().substring(0, textAreaCountLimit));
        } else {
            countInfo.text(currentCount + " /");
        }
    });
}());