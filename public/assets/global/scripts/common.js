var TSConstant = {
    AJAX_STATUS_CODE_OK : 0,
    AJAX_STATUS_ERROR_PARAM : 1,
    AJAX_STATUS_ERROR_INTERNAL : 2,
    AJAX_STATUS_ERROR_AUTH : 3,

    D_LANGUAGE: {
    }

};

/*-------------------- DEFINE STRING OPERATOR ---------------------*/
String.prototype.format = function() {
    var args = arguments;
    return this.replace(/\{\{|\}\}|\{(\d+)\}/g, function(m, n) {
        if (m == "{{") {
            return "{";
        }
        if (m == "}}") {
            return "}";
        }
        return args[n];
    });
};

String.prototype.endsWith = function(suffix) {
    return (this.substr(this.length - suffix.length) === suffix);
};

String.prototype.startsWith = function(prefix) {
    return (this.substr(0, prefix.length) === prefix);
};

/*-------------------- DEFINE AJAX OPERATOR ---------------------*/
$.ajaxSetup({
    cache : false
});

$(document).ready(function(){
    // Init Ajax with CSRF
    var csrf_token = $("meta[name='csrf-token']").attr("content");

    // Ajax setup
    $.ajaxSetup({
        beforeSend: function (xhr) {
            // Set CSRF Token.
            xhr.setRequestHeader('x-csrf-token', csrf_token);
        }
    });

});

$(document).ready(function(){
    $.uniform.update();
    // Current active menu.
    var currentUrl = window.location.pathname;
    if (currentUrl != '' && currentUrl != undefined && currentUrl != '/') {
        var currentActiveA = $('#layout_menu a[href$="{0}"]'.format(currentUrl));
        if (currentActiveA != null && currentActiveA != undefined) {
            $($(currentActiveA).parent()).addClass("active");
            $($(currentActiveA).parent().parent().parent()).addClass("active");
            $($(currentActiveA).parent().parent().parent()).addClass("open");
            $($(currentActiveA).parent().parent().parent()).find('span.arrow').addClass("open");
            $($(currentActiveA).parent().parent().parent()).find('span.select').addClass("selected");
        }
    }
});