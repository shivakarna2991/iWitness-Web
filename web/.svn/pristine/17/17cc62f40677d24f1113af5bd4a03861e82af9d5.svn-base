;
(function ($) {
    "use strict";

    $(document).ready(function () {
        /**
         * contact form processing
         */
        $('.contact-form', $('#main-container')).each(function () {
            $(this).find('#error-block,#success-block').hide();

            $(this).validate({
                meta: "validator",
                submitHandler: function (form) {

                    $(form).find('#error-block,#success-block').hide();

                    function notify(status, message) {
                        $.unblockUI();
                        $(form).find(status != 200 ? '#error-block' : '#success-block').html(message).fadeIn();
                    }

                    if ($(form).valid()) {
                        $.blockUI({message: 'Saving contact...'});
                        $(form).ajaxSubmit({
                            url: $.iw.getWordPressAjaxUrl(),
                            dataType: 'json',

                            error: function () {
                                notify('error', 'Unexpected error');
                            },

                            success: function (r) {
                                if (r.status == 200 && r.response && r.response.id) {
                                    notify(r.status, r.message || "Contact saved");
                                    var $f = $('#' + r.request.form_id);
                                    $f.find('input[name="key"]').val(r.response.id);
                                } else if (r.status = 422) { //validation error
                                    var message = '<strong>' + r.message + ':</strong>';
                                    for (var key in r.response) {
                                        message += "<br>&nbsp;&nbsp;&nbsp; - &nbsp;" + r.response[key];
                                    }
                                    notify(r.status, message);
                                } else {
                                    notify(r.status, r.message || "Unexpected error");
                                }
                            }
                        });
                    }
                }
            })
        });
    });
})(jQuery);