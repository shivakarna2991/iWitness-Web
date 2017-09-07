;
(function ($) {
    "use strict";

    $().ready(function () {
        RevenueReport.init();
    });

    var RevenueReport = (function () {

        var $userTableContainer = $('#revenue-table-container'),
            $userTable = $userTableContainer.find('table'),
            $totalSummary = $('#total-summary'),
            $totalRevenue = $('#total-revenue');

        function init() {

            var totalRevenue = 0,
                totalRegister = 0,
                grid = $userTable.bootgrid({
                    navigation: 0,
                    ajax: true,
                    post: function () {
                        var startDate = $('#start-date').val(),
                            endDate = $('#end-date').val();

                        return {
                            action: "iwitness_admin_get_revenue",
                            start_date: startDate && startDate !== undefined ? new Date(startDate).getTime() / 1000 : '',
                            end_date: endDate && endDate !== undefined ? new Date(endDate).getTime() / 1000 : ''
                        };
                    },
                    url: $.iw.getWordPressAjaxUrl(),
                    formatters: {
                        "registered-counter-formatter": function (column, row) {
                            if (row.total && row.total !== undefined) {
                                totalRegister += +row.total;
                                return row.total;
                            }
                        },
                        "revenue-counter-formatter": function (column, row) {

                            if (row.revenue && row.revenue !== undefined) {
                                totalRevenue += +row.revenue;
                                return row.revenue.toLocaleString();
                            }
                        }
                    }
                }).on("loaded.rs.jquery.bootgrid", function (e) {
                    $totalSummary.html(totalRegister);
                    $totalRevenue.html(totalRevenue.toLocaleString() + ' USD');

                    var $startDate = $('#start-date'),
                        $endDate = $('#end-date');

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
                            totalRegister = 0;
                            totalRevenue = 0;
                        }
                    });
                });
        }

        return {
            init: init
        };
    })();

})(jQuery);