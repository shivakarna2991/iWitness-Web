;
if (typeof jQuery === "undefined") {
    throw new Error("JQuery iWitness requires jQuery")
}

(function ($) {
    "use strict";

    $.iWitness = {

        getMainContainer: function () {
            var $container = $('#main-container');
            if (!$container || $container == undefined) {
                alert('Should define main container element');
            }
            return $container;
        },

        getApiUrl: function () {
            var apiUrl = this.getMainContainer().data('api-url');
            if (!apiUrl || apiUrl == undefined) {
                alert('Should define API URL in the container element');
            }
            return apiUrl;
        },

        getPluginUrl: function () {
            var pluginUrl = this.getMainContainer().data('plugin-url');
            if (!pluginUrl || pluginUrl == undefined) {
                alert('Should define Wordpress Plugin URL in the container element');
            }
            return pluginUrl;
        },

        getAccessToken: function (callback) {
            return $.post($.iWitness.getWordPressAjaxUrl(), {action: 'get_access_token'});
        },

        getWordPressAjaxUrl: function () {
            return location.protocol + '//' + location.host + '/wp-admin/admin-ajax.php';
        },

        autoHidePopover: function () {
            $('html').on('click', function (e) {
                if (typeof $(e.target).data('original-title') == 'undefined' && !$(e.target).parents().is('.popover.in')) {
                    $('[data-original-title]').popover('hide');
                    $('.popover.fade').css("display", "none", "important");

                }
            }); // Auto hide all popover
        },

        autoHideMesageBox: function () {
            window.setTimeout(function () {
                $(".alert-auto-hide").fadeTo(500, 0).slideUp(500, function () {
                    $(this).remove();
                });
            }, 5000); // doing some animations on this message box
        },

        disableAutoCompleted: function () {
            var $inputs = $('[data-disable-auto-completed]', $.iWitness.getMainContainer());
            $.each($inputs, function (index, element) {
                $(element).attr('autocomplete', 'off');
            });
        },
        customizedErrorPlacement: function (error, element) {
            var $form = $(element).closest('form'),
                $element = $(element);
            if ($element.is('[name="agree"]', $form)) {
                var $parent = $element.parent();
                error.addClass('help-block').appendTo($parent);
            } else {
                error.insertAfter($element);
            }
        },

        Character: {
            count: function (totalCharacters) {
                var $container = $(this),
                    $textArea = $container.find('textarea'),
                    currentChars = $textArea.val().length,
                    remainChars = parseInt(totalCharacters) - parseInt(currentChars),
                    $messageElement = $('<p class="count-message help-block">' + remainChars + ' characters remaining</p>');

                if (remainChars < 0) {
                    // disabled if the character remaining is zero
                    $textArea.val($textArea.val().substr(0, totalCharacters));
                } else {
                    // remove if it existing
                    $container
                        .find('.count-message')
                        .remove();

                    // add new element for the message
                    $container.append($messageElement);
                }
            },
            word: function (message, numOfWord) {
                var words = message.split(/\b[\s,\.-:;]*/),
                    wordCount = words.length,
                    result;

                if (wordCount < 10) {
                    result = message;
                } else {
                    result = message.split(' ').slice(0, numOfWord).join(' ') + '...';
                }

                return result;
            }
        },

        Ajax: {
            getRemoteData: function (url) {
                if($.registry('access_token')) {
                    return $.ajax({
                        url: $.iWitness.getApiUrl() + url,
                        beforeSend: function (xhr) {
                            xhr.setRequestHeader('Authorization', 'Bearer ' + $.registry('access_token'));
                        }
                    });
                } else {
                    return $.when($.iWitness.getAccessToken()).then(function (result) {
                        return $.ajax({
                            url: $.iWitness.getApiUrl() + url,
                            beforeSend: function (xhr) {
                                var tokenResult = $.parseJSON(result);
                                if (tokenResult.token === undefined) {
                                    console.error('iwitness: undefined token');
                                } else {
                                    $.registry('access_token', tokenResult.token);
                                    xhr.setRequestHeader('Authorization', 'Bearer ' + tokenResult.token);
                                }
                            }
                        });
                    });
                }
            }
        },

        Table: {
            bindingTable: function () {
                var $table = $(this).find('table');

                $table
                    .tablesorter({
                        // debug: true,
                        theme: "bootstrap",
                        headerTemplate: '{content} {icon}',
                        widgets: ["uitheme", "resizable", "zebra", "columnSelector"],
                        widgetOptions: {
                            zebra: ["even", "odd"],
                            resizable_addLastColumn: true,

                            // target the column selector markup
                            columnSelector_container: $('#columnSelector'),
                            // column status, true = display, false = hide
                            // disable = do not display on list
                            columnSelector_columns: {
                                0: 'disable' /* set to disabled; not allowed to unselect it */
                            },
                            // remember selected columns (requires $.tablesorter.storage)
                            columnSelector_saveColumns: true,

                            // container layout
                            columnSelector_layout: '<label><input type="checkbox">{name}</label>',
                            // data attribute containing column name to use in the selector container
                            columnSelector_name: 'data-selector-name',

                            /* Responsive Media Query settings */
                            // enable/disable mediaquery breakpoints
                            columnSelector_mediaquery: true,
                            // toggle checkbox name
                            columnSelector_mediaqueryName: 'Auto: ',
                            // breakpoints checkbox initial setting
                            columnSelector_mediaqueryState: true,
                            // responsive table hides columns with priority 1-6 at these breakpoints
                            // see http://view.jquerymobile.com/1.3.2/dist/demos/widgets/table-column-toggle/#Applyingapresetbreakpoint
                            // *** set to false to disable ***
                            columnSelector_breakpoints: ['20em', '30em', '40em', '50em', '60em', '70em'],
                            // data attribute containing column priority
                            // duplicates how jQuery mobile uses priorities:
                            // http://view.jquerymobile.com/1.3.2/dist/demos/widgets/table-column-toggle/
                            columnSelector_priority: 'data-priority'
                        }
                    });

                $('#popover', $(this))
                    .popover({
                        placement: 'auto left',
                        html: true, // required if content has HTML
                        content: '<div id="popover-target"></div>'
                    })
                    // bootstrap popover event triggered when the popover opens
                    .on('shown.bs.popover', function () {
                        // call this function to copy the column selection code into the popover
                        $.tablesorter.columnSelector.attachTo($table, '#popover-target');
                    });
            }
        },

        Select2: {
            bindingControl: function ($settings, $ajaxSettings) {
                var $ajaxDefault = {
                    dataType: 'json',
                    transport: function (params) {
                        if($.registry('access_token')) {
                            params.beforeSend = function (request) {
                                request.setRequestHeader('Authorization', 'Bearer ' + $.registry('access_token'));
                            };
                            return $.ajax(params);
                        } else {
                            return $.when($.iWitness.getAccessToken()).then(function (result) {
                                var tokenResult = $.parseJSON(result);
                                if(tokenResult.token === undefined) {
                                    console.error('iwitness: undefined token');
                                    return;
                                } else {
                                    params.beforeSend = function (request) {
                                        $.registry('access_token', tokenResult.token);
                                        request.setRequestHeader('Authorization', 'Bearer ' + tokenResult.token);
                                    };
                                    return $.ajax(params);
                                }
                            });
                        }
                    },
                    dropdownCssClass: "bigdrop"
                };

                $settings = $settings || {};
                $.extend(true, $ajaxDefault, $ajaxSettings);

                return $(this).select2({
                    placeholder: typeof $settings.placeholder !== 'undefined' ? $settings.placeholder : "Type to searching ...",
                    minimumInputLength: typeof $settings.minimumInputLength !== 'undefined' ? $settings.minimumInputLength : 1,
                    multiple: typeof $settings.multiple !== 'undefined' ? $settings.multiple : true,
                    ajax: $ajaxDefault
                });
            }
        },

        DateTime: {
            mmddyyyyFormat: function () {
                var yyyy = this.getFullYear().toString();
                var mm = (this.getMonth() + 1).toString(); // getMonth() is zero-based
                var dd = this.getDate().toString();

                return (mm[1] ? mm : "0" + mm[0]) + '/' + (dd[1] ? dd : "0" + dd[0]) + '/' + yyyy;
            }
        }
    };

    // make aliases
    $.iw = $.iWitness;
    $.fn.iwCharacterCount = $.iWitness.Character.count;
    $.fn.iwGetWord = $.iWitness.Character.word;

    $.fn.iwGetRemoteData = $.iWitness.Ajax.getRemoteData;
    $.fn.iwBindingTable = $.iWitness.Table.bindingTable;
    $.fn.iwBindingSelect2 = $.iWitness.Select2.bindingControl;

    Date.prototype.mmddyyyy = $.iWitness.DateTime.mmddyyyyFormat;

})(jQuery);