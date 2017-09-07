;
(function ($) {
    "use strict";

    $().ready(function () {
        var $couponTable = $('#coupon-table'), hasBindCodeFromUrl = false;

        $couponTable.bootgrid({
            ajax: true,
            post: function () {
                return {
                    action: "iwitness_admin_get_coupon"
                };
            },
            url: $.iw.getWordPressAjaxUrl(),
            formatters: {
                "redemption-start-date-formatter": function (column, row) {
                    if (row.redemptionStartDate) {
                        return new Date(row.redemptionStartDate * 1000).mmddyyyy();
                    }
                },
                "redemption-end-date-formatter": function (column, row) {
                    if (row.redemptionEndDate) {
                        return new Date(row.redemptionEndDate * 1000).mmddyyyy();
                    }
                },
                "price-formatter": function (column, row) {
                    if (row.price) {
                        return row.price.toLocaleString();
                    }
                },
                "free-formatter": function (column, row) {
                    if (row.price <= 0) {
                        return '<span class="text-success glyphicon glyphicon-ok"></span>';
                    }
                },
                "active-formatter": function (column, row) {
                    if (row.isActive) {
                        return '<span class="text-success glyphicon glyphicon-ok"></span>';
                    }
                }
            }
        }).on("loaded.rs.jquery.bootgrid", function (e) {
            if (hasBindCodeFromUrl) {
                return;
            }
            var $search = $('.search-field');
            var code = getUrlVars()['code'];
            if (code && !($search.val())) {
                $search.val(decodeURIComponent(code));
                $search.trigger('keyup.rs.jquery.bootgrid', e);
            }
            hasBindCodeFromUrl = true;
        });
    });

    function getUrlVars() {
        var vars = [], hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');

        for (var i = 0; i < hashes.length; i++) {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = removeHashMark(hash[1]);
        }
        return vars;
    }

    function removeHashMark(value) {
        var ret = value;
        if (value) {
            var index = value.indexOf('#');
            if (index > 0) {
                ret = value.slice(0, index);
            }
        }
        return ret;
    }

})(jQuery);
