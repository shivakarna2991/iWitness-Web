    ;
(function ($) {
    "use strict";

    $().ready(function () {
        bindingCreditCard();
    });

    function bindingCreditCard() {
        $("#card_number").validateCreditCard(function (e) {
            var $cardIcon = $("#card_number_icon"), $cardType = $("#card_type");
            $cardIcon.removeClass().addClass('ccard-icon');
            $cardType.val('');
            if (null != e.card_type) {
                $cardIcon.addClass(e.card_type.name);
                $cardType.val(e.card_type.name);
            } else {
                $cardIcon.addClass('card');
            }
        }, {
            accept: ["visa", "mastercard", "amex", "discover", "jcb", "visa_electron"]
        });
    }

})(jQuery);

