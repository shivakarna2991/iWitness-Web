;
(function ($) {
    "use strict";

    $().ready(function () {
        Purchase.init();
    });

    var Purchase = (function () {
        var $androidForm = $('#frmAndroid')
            , $windowsForm = $('#frmWindows')
            , $warningOverlay = $('#iphone3-warning-overlay')
            , $orderForm = $('#order')
            , $nextBtn = $('#next')
            , $backBtn = $('#back')
            , $backBtn1 = $('#back1')
            , $android = $('#android', $orderForm)
            , $windows7 = $('#windows7', $orderForm)
            , iphone3 = $('#iphone3', $orderForm);

        function init() {
            bindEvents();
            bindValidation();
            bindFeedbackForm();
            fill();
            pickStateField();
        }

        function bindEvents() {

            /* processing for Windows form */
            $windowsForm.submit(function (e) {
                e.preventDefault();
                var $self = $(this), params = $self.find('form').serialize();

                $.post($self.find('form').attr('action'), params, function () {
                    $self.fadeOut('fast');
                });
            });

            // Overlay warning for iPhone 3Gs on signup form
            $('input[type="radio"][name="phone_model"]', $orderForm).change(function (e) {
                $(this).val() == 'iphone3' && $(this).attr('checked')
                    ? $warningOverlay.fadeIn('fast')
                    : $warningOverlay.fadeOut('fast');
            });

            /* processing for the rest of screen */
            $nextBtn.on('click', function() {
                preSubmit();
            });

            $backBtn.on('click', function () {
                fill();
            });
          	$backBtn1.on('click', function () {
                fill();
            });

            $('select[name="country"]', $orderForm).change(pickStateField);

            $android.on('click', function () {
                $windowsForm.modal('hide');
            });

            $windows7.on('click', function () {
                $windowsForm.modal('show');
                $androidForm.fadeOut('fast');
                $(':input[name="email"]', $windowsForm).focus();
            });

            iphone3.on('click', function () {
                $windowsForm.modal('hide');
                $androidForm.hide();
            });
        }

        function bindValidation() {

            $orderForm.validate({
                meta: "validator",
                submitHandler: function (form) {
                    if ($(form).valid()) {
                        form.submit();
                    }
                },

                rules: {
                    promoCode: {
                        onfocusout: false,
                        onkeyup: false,
                        onclick: false,
                        required: true,
                        remote: {
                            url: $.iw.getWordPressAjaxUrl(),
                            type: "post",
                            data: {
                                promoCode: function () {
                                    return $('#promoCode').val();
                                },
                                action: "validate_promotion_code"
                            },
                            async: false
                        }
                    }
                },
                messages: {
                    promoCode: {
                        remote: "Promo code is invalid."
                    }
                },
                errorPlacement: $.iw.customizedErrorPlacement
            });
        }

        function bindFeedbackForm() {
            $('#other-platform').each(function () {
                $(this).validate({
                    meta: "validator",
                    submitHandler: function (form) {
                        if ($(form).valid()) {
                            $(form).ajaxSubmit({
                                url: $.iw.getWordPressAjaxUrl(),
                                dataType: 'json',
                                success: function (r) {
                                    $('#frmWindows').modal('hide');
                                }
                            });
                        }
                    }
                })
            });
        }

        function pickStateField() {
            var $orderContainer = $('.order-form', $orderForm)
                , us = $('select[name="country"]', $orderContainer).val() == 'US';

            $('#usStates').toggle(us).find('select').attr('disabled', !us);
            $('#otherStates').toggle(!us).find('select').attr('disabled', us);

            $('label[for="otherStates"]', $orderContainer).hide();
            $('label[for="usStates"]', $orderContainer).hide();
        }

        function preSubmit() {
            if (!$orderForm.valid()) {
                fill();
            } else {
                var $plan = $('#plan', $orderForm);

                if($plan.val()=='promo'){
                    $.ajax({
                        type: "POST",
                        url: $.iw.getWordPressAjaxUrl(),
                        data: {
                            promoCode: $('#promoCode', $orderForm).val(),
                            action: "get_promotion_code"
                        },
                        success: function(data){
                            $('#plan_promo', $orderForm).show();
                            $('#plan_promo_item').html(data.subscriptionLength + " Month(s) Subscription");
                            $('#plan_promo_price').html("$"+data.price);
                            $('#plan_promo_cost').html("$"+data.price);

                            refreshRewiewPanel();
                        }
                    });
                }else{
                    refreshRewiewPanel();
                }
            }
        }

        function refreshRewiewPanel(){
            // apply form values to review screen
            $.each($orderForm.serializeArray(), function () {
                var name = this.name, value = this.name == 'card_num'
                    ? this.value.substr(this.value.length - 4)
                    : this.value;

                $('[data-name="' + name + '"]', $orderForm).html(value);
                $('[data-for="' + name + '"]', $orderForm)
                    .hide()
                    .filter('[data-value="' + value + '"]')
                    .show();
            });
            review();
        }

        function review() {
            $('.order-form', $orderForm).hide();
            $('.review', $orderForm).show();

            _gaq.push(['_setAccount', 'UA-30469246-1']);
            _gaq.push(['_trackPageview']);
        }
				
        function fill() {
            $('.order-form', $orderForm).show();
            $('.review', $orderForm).hide();
        }

        return {init: init};

    })();

})(jQuery);

function setStep3() {
  var planType = $('input[name=plan-type]:checked').val();
  if(planType == 'individual') {
    $('.selectusers').hide();
    $('.individual').show();
    $('.family').hide();
  } else if (planType == 'family') {
    $('.selectusers').show();
    $('.individual').hide();
    $('.family').show();
  } else {
    
  }
  
}
$('input[name=plan]').on('change',function() {
  var qty =2;
  if ($('#add_users').length)
	{
 
		qty   = $('#add_users').val();
  	var plan   = $('input[name=plan]:checked').val();
  	var price = $('#price_'+plan).val();
  	var mprice = $('#mprice_'+plan).val();
  	$('#tUnitPrice').val("$"+parseFloat(mprice) * parseFloat(qty));
  	$('#tPrice').val("$"+(parseFloat(price) + parseFloat(parseFloat(mprice) * parseFloat(qty))));
	}

});