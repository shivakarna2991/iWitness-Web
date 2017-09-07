;
(function ($) {
    "use strict";

    $().ready(function () {
        UserReport.init();
    });

    var UserReport = (function () {

        var $userTableContainer = $('#user-table-container'),
            $userTable = $userTableContainer.find('table'),
            $searchElement = $('#search-template'),
            $searchTmpl = $('<div/>').loadTemplate($searchElement);

        function init() {

            $userTable.bootgrid({
                templates: {
                    search: $searchTmpl.html()
                },
                ajax: true,
                post: function () {
                    var startDate = $('#start-date').val(),
                        endDate = $('#end-date').val();

                    return {
                        action: "iwitness_admin_get_users",
                        start_date: startDate && startDate !== undefined ? new Date(startDate).getTime() / 1000 : '',
                        end_date: endDate && endDate !== undefined ? new Date(endDate).getTime() / 1000 : ''
                    };
                },
                url: $.iw.getWordPressAjaxUrl(),
                formatters: {
                    "datetime-formatter": function(column, row)
                    {
                        return new Date(row.birthDate * 1000).mmddyyyy();
                    },

                    "created-datetime-formatter": function(column, row)
                    {
                        return new Date(row.created * 1000).mmddyyyy();
                    }
                }
            }).on("loaded.rs.jquery.bootgrid", function () {
                var $parent = $(this).parent(),
                    $startDate = $('#start-date', $parent),
                    $endDate = $('#end-date', $parent);

                $startDate.datepicker({
                    changeMonth: true,
                    changeYear: true,
                    onSelect: function (selected) {
                        $endDate.datepicker("option", "minDate", selected);
                    }
                });

                $endDate.datepicker({
                    changeMonth: true,
                    changeYear: true,
                    onSelect: function (selected) {
                        $startDate.datepicker("option", "maxDate", selected);
                        $userTable.bootgrid('reload');
                    }
                });
            });
        }

        return {
            init: init
        };

    })();

})(jQuery);