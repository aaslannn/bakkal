/*global $,MEApp*/
MEApp.helpers.checkpage = (function () {
    "use strict";
    var check = function (pagename) {
        pagename = $(pagename);
        var returnOBJ = false;
        if (pagename.length > 0) {
            returnOBJ = true;
        }
        return returnOBJ;
    };
    return {
        check: check
    };
}(MEApp.helpers.checkpage));
var checkpage = MEApp.helpers.checkpage;