(function ($) {
    "use strict";

    $().ready(function () {
        socialMediaBinding();
        formatCommentBox();
        // bindingNotifyMessage(); // todo: not include in this release

        $.iw.autoHidePopover();
        $.iw.autoHideMesageBox();
        $.iw.disableAutoCompleted();
    });

    function bindingNotifyMessage() {
        var $messageNotification = $('#message-notification'),
            $numOfNotify = $('#num-of-notify'),
            $lazyMessages = $.when(function () {
                return $.ajax({
                    type: "get",
                    dataType: "json",
                    url: $.iw.getWordPressAjaxUrl(),
                    data: {action: "get_total_page_message"},
                    success: function (pager) {
                        return pager;
                    }
                });
            });

        $lazyMessages.done(function (pager) {
            if (pager.totalItems) {
                $numOfNotify.html(pager.totalItems);
            }

            $messageNotification.on('click', function () {
                $('.panel-body').infinitescroll({
                    navSelector: "#next:last",
                    nextSelector: "a#next:last",
                    debug: false,
                    dataType: 'json',
                    maxPage: pager.pageCount,
                    prefill: true,
                    path: function (index) {
                        return $.iw.getWordPressAjaxUrl() + '?action=get_message&page=' + index;
                    },
                    behavior: 'local',
                    appendCallback: false, // USE FOR PREPENDING
                    state: {
                        currPage: 0
                    },
                    loading: {
                        finishedMsg: ''
                    }
                }, function (newElements, result, url) {
                    var $template = $('#notification-template'),
                        $messageBox = $('#message-box');

                    $messageBox.find('div:visible').remove();
                    $.each(newElements.data, function (i, item) {
                        item.message = $(this).iwGetWord(item.message, 10);
                        var $div = $('<div/>').loadTemplate($template, item);

                        $messageBox.append($div.html());
                        $('.list-group-item', $messageBox).on('mouseover', function (e) {
                            $('.message-action', $(this)).removeClass('hide');
                        });

                        $('.list-group-item', $messageBox).on('mouseout', function (e) {
                            $('.message-action', $(this)).addClass('hide');
                        });
                    });
                });
            });
        });
    }

    function socialMediaBinding() {
        /**
         * Handles social icon clicks to open in new popup window vs in new tab
         **/
        $('.facebook-icon, .twitter-icon').click(function (e) {
            e.preventDefault();
            var left = Number(($(window).width() - 700) / 2);
            window.open($(this).attr('href'), 'social', 'width=700,height=400,location=no,left=' + left + ',top=200');
        });


        /**
         * validate forms, using data-validate attribute to define validation
         * rules
         */
        $.metadata.setType("html5");
        $('form[data-validate="true"]').validate({
            meta: "validator",
            submitHandler: function (form) {
                $.blockUI({message: 'Processing...'});
                form.submit();
            },
            errorPlacement: $.iw.customizedErrorPlacement
        });

        /**
         * Submitting form, using links:
         */
        $('form a.submit').click(function (e) {
            e.preventDefault();
            $(this).parents('form').submit();
        });
    }

    function formatCommentBox() {
        //todo: will find another way, because wordpress not allow us to modify the submit button on comment box
        var $commentForm = $('#commentform');
        $('textarea[name="comment"]', $commentForm).removeClass('form-control').addClass('form-control');
        $('input[type="submit"]', $commentForm).removeClass('btn btn-primary').addClass('btn btn-primary');
    }

})
    (jQuery);
