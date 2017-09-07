;
(function ($) {
    "use strict";

    $().ready(function () {

        $('#signup-form').validate({
            meta: "validator",
            rules: {
                phone11: {
                    onfocusout: false,
                    onkeyup: false,
                    onclick: false,
                    required: true,
                    remote: {
                        url: $.iw.getWordPressAjaxUrl(),
                        type: "post",
                        data: {
                            phone: function () {
                                return $('#phone11').val();
                            },
                            action: "validate_phone_number"
                        },
                        async: true
                    }
                },
                email: {
                    onfocusout: false,
                    onkeyup: false,
                    onclick: false,
                    required: true,
                    remote: {
                        url: $.iw.getWordPressAjaxUrl(),
                        type: "post",
                        data: {
                            email: function () {
                                return $('#email').val();
                            },
                            action: "validate_email_duplicate"
                        },
                        async: true
                    }
                }
            },
            messages: {
                phone11: {
                    remote: "Phone number already exists."
                },
                email: {
                    remote: "Sorry, that email address is already used!"
                }
            }
        });

    });
})(jQuery);

