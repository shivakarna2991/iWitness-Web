;
(function ($) {
    "use strict";

    $().ready(function () {
        var $codeForm = $('#code-form')
            , $startDateControl = $('#datepicker_start_date')
            , $endDateControl = $('#datepicker_end_date')
            , $numberOfCodeContainer = $('#number-of-code-container')
            , $plan = $("#plan")
            , $subscriptionLength = $("#subscription_length")
            , $price = $("#price")
            , planData =  $plan.data('plans');

        $startDateControl.datepicker({
            changeMonth: true,
            changeYear: true,
            onSelect: function (selected) {
                $endDateControl.datepicker("option", "minDate", selected)
            }

        });

        $endDateControl.datepicker({
            changeMonth: true,
            changeYear: true,
            onSelect: function (selected) {
                $startDateControl.datepicker("option", "maxDate", selected)
            }
        });

        $numberOfCodeContainer.hide();
        $("input[id='single_code']", $codeForm).change(function () {
            $numberOfCodeContainer.hide();
        });

        $("input[id='auto_generated']", $codeForm).change(function () {
            $numberOfCodeContainer.show();
        });

        $plan.change(function () {
            var plan = $plan.val();
            switch (plan) {
                case "safekidyear":
                case "seattleyear":
                case "student":
                case "wspta":
                    $subscriptionLength.prop('disabled', true);
                    $price.prop('disabled', true);
                    $price.val(planData[plan]['price']);
                    $subscriptionLength.val(planData[plan]['length']);
                    break;
                case "free":
                    $subscriptionLength.prop('disabled', true);
                    $price.prop('disabled', true);
                    $price.val('');
                    $subscriptionLength.val('');
                    break;
                case "":
                default :
                    $subscriptionLength.prop('disabled', false);
                    $price.prop('disabled', false);
                    break
            }

        }).change();
    });

})(jQuery);