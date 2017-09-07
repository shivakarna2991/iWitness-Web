;
(function ($) {
    "use strict";

    $().ready(function () {
        var $userTable = $('#user-table');

        $userTable.bootgrid({
            ajax: true,
            post: function ()
            {
                return {
                    action: "iwitness_admin_get_users"
                };
            },
            url: $.iw.getWordPressAjaxUrl(),
            formatters: {
                "commands": function(column, row)
                {
                    var suspend = row.suspended === 1 ? 'UnSuspend' : 'Suspend';
                    return "<button type=\"button\" class=\"btn btn-xs btn-warning command-suspend\" data-row-id=\"" + row.id + "\">" + suspend + "</button> " +
                    "<button type=\"button\" class=\"btn btn-xs btn-primary command-delete\" data-row-id=\"" + row.id + "\">Delete</button>";
                }
            }
        }).on("loaded.rs.jquery.bootgrid", function()
        {
            var $self = $(this);
            $self.find(".command-suspend").on("click", function(e)
            {
                if(confirm("Are you sure to suspend this user?")) {
                    var data = {
                        'action': 'iwitness_do_admin_suspend_user',
                        'user_id': $(this).data("row-id")
                    };

                    $.post($.iw.getWordPressAjaxUrl(), data).done(function (result) {
                        $userTable.bootgrid('reload');
                    });
                }
            }).end().find(".command-delete").on("click", function(e)
            {
                if(confirm("Are you sure to delete this user?")) {
                    var data = {
                        'action': 'iwitness_do_admin_delete_user',
                        'user_id': $(this).data("row-id")
                    };

                    $.post($.iw.getWordPressAjaxUrl(), data).done(function (result) {
                        $userTable.bootgrid('reload');
                    });
                }
            });
        });
    });

})(jQuery);