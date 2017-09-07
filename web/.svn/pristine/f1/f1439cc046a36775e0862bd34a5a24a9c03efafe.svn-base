(function($) {

$.fn.validation = function() {		

    var error = 0;
		
	$('.required-field', this).each(function() {
		var input = $(':input', this).attr("value");
                 var phone = jQuery("#phone").val();
             //   alert(phone);
		if (phone == "") {
                    
                        jQuery("#phoneerror").html('* This field is requied.');
//			$('span.error-message', this).remove();
//			$(this).append('<span class="error-message"><span class="error"></span></span>');
//			$('span.error', this).html('* This field is requied.');
                         jQuery(".usertable").html('');
                         jQuery(".detete_msg").html('');
//			$(':input', this).addClass("error-highlight");
			error++;
		} else  if (phone != '') {
                    var value = phone.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
                    var intRegex = /^\d+$/;
                    if (!intRegex.test(value)) {
//                        $('span.error-message', this).remove();
//			$(this).append('<span class="error-message"><span class="error"></span></span>');
//			$('span.error', this).html('* Phone field must be numeric.');
                         jQuery("#phoneerror").html('* Phone field must be numeric.');
                         jQuery(".usertable").html('');
                         jQuery(".detete_msg").html(' ');
//			$(':input', this).addClass("error-highlight");
			error++;
                    }
                }else {
			$('span.error-message', this).remove();
			$(':input', this).removeClass("error-highlight");
		}
	});
	
	if (error == 0) {
		return true;
	} else {
		return false;
	}
};

})(jQuery);

$(document).ready(function() {
	$("#myform").submit(function () {
		return $(this).validation();
	});
});