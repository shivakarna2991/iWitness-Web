;
(function ($) {
    "use strict";

    $().ready(function () {
        SubscriptionReport.init();
    });

    var SubscriptionReport = (function () {

        var $subscriptionTableContainer = $('#subscription-table-container'),
            $subscriptionTable = $subscriptionTableContainer.find('table'),
            $searchElement = $('#search-template'),
            $searchTmpl = $('<div/>').loadTemplate($searchElement);

        function init() {

            $subscriptionTable.bootgrid({
                templates: {
                    search: $searchTmpl.html()
                },
                ajax: true,
                post: function () {
                    var startDate = $('#start-date').val(),
                        endDate = $('#end-date').val();

                    return {
                        action: "iwitness_admin_get_subscription",
                        start_date: startDate && startDate !== undefined ? new Date(startDate).getTime() / 1000 : '',
                        end_date: endDate && endDate !== undefined ? new Date(endDate).getTime() / 1000 : ''
                    };
                },
                url: $.iw.getWordPressAjaxUrl(),
                formatters: {
                    "start-at-formatter": function(column, row)
                    {
                        return new Date(row.subscriptionStartAt * 1000).mmddyyyy();
                    },
                    "expired-at-formatter": function(column, row)
                    {
                        if(row.subscriptionExpireAt > 0) {
                            return new Date(row.subscriptionExpireAt * 1000).mmddyyyy();
                        }
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
                        $subscriptionTable.bootgrid('reload');
                    }
                });
            });
        }

        return {
            init: init
        };
    })();

})(jQuery);