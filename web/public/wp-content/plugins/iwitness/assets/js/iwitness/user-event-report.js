;
(function ($) {
    "use strict";

    $().ready(function () {
        UserEventReport.init();
    });

    var UserEventReport = (function () {
        var $eventTableContainer = $('#user-event-table-container'),
            $eventTable = $eventTableContainer.find('table'),
            $searchElement = $('#search-template'),
            $searchTmpl = $('<div/>').loadTemplate($searchElement),
            userId = null;

        function init() {
            $eventTable.bootgrid({
                templates: {
                    search: $searchTmpl.html()
                },
                ajax: true,
                post: function () {
                    return {
                        action: "iwitness_admin_get_user_event",
                        user_id: userId
                    };
                },
                url: $.iw.getWordPressAjaxUrl(),
                formatters: {
                    "video-link-formatter": function (column, row) {
                        return '<a href="'+ row.videoUrl + '" alt="' + row.displayName + '" target="_blank">' +
                        '<img width="20" src="' + row.imageUrl + '" alt="' + row.displayName + '"></a>';
                    },
                    "checked-formatter": function(column, row) {
                        if(row.processed === 1) {
                            return '<span class="glyphicon glyphicon-ok text-success"></span>';
                        }
                    }
                }
            }).on("loaded.rs.jquery.bootgrid", function (e) {
                var $userSelect = $('#select2-user'),
                    settings = {
                        placeholder: "Type a user name...",
                        multiple: false,
                        width: 'resolved'
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

                userId = null;
                $userSelect.iwBindingSelect2(settings, ajaxSettings);
                $userSelect.off().on("select2-selecting", function (e) {
                    userId = e.val;
                    $eventTable.bootgrid('reload');
                });
            });
        }

        return {
            init: init
        };
    })();

})(jQuery);