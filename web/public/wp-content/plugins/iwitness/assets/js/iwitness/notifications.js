;
(function ($) {
    "use strict";

    $().ready(function () {
        Notification.init();
    });

    var Notification = (function () {

        function init() {
            var settings = {
                    placeholder: "Type a phone number (like 12063992524)",
                    multiple: true
                },
                ajaxSettings = {
                    url: $.iw.getApiUrl() + '/search/user',
                    data: function (term, page) {
                        return {
                            'term': term
                        };
                    },
                    results: function (data, page) {
                        if (!data.user) {
                            error('Cannot find out data source for user');
                        }
                        var results = $.map(data.user, function (user, index) {
                            var fullName = user.firstName != null ? user.firstName : '';
                            fullName += ' ' + (user.lastName != null ? user.lastName : '');
                            fullName += ' ' + (user.phone != '' ? user.phone : '');

                            return {
                                id: user.id,
                                text: fullName
                            }
                        });
                        return {results: results};
                    }
                };

            $('#select2-user-id').iwBindingSelect2(settings, ajaxSettings);
        }

        return {
            init: init
        };
    })();

})(jQuery);