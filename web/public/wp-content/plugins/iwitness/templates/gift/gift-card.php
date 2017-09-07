<?php
$view_model['is_gift'] = true;
$plans = $view_model['plans'];
$plugin_path = iWitness()->plugin_path();
$user_login  = is_user_logged_in();
if($user_login)
	$user_val = "yes";
else
	$user_val="no";
//print_r($session);
?>

<script type="application/javascript">
    // todo: don't like global variable, we will find another way
    var recipientData = JSON.parse(JSON.stringify(<?php echo(stripcslashes($view_model['recipients'])); ?>));
</script>

<?php do_action('iwitness_print_notices'); ?>

<div id="main-gift-card-container">
    <form action="" method="POST" id="place-order-form" data-validate="true">
        <input type="hidden" name="action" value="iwitness_do_place_your_order"/>

        <div id="order">
            <h2>Gift card</h2>
            <hr>
            <div class="row">
                <div class="col-md-9">
                    <h4>
                        <strong>Protect your loved ones.</strong>
                    </h4>
                    Safety is the greatest gift you can ever give to people you care about, so send them a year's subscription to iWitness electronically. Your loved one will receive an email announcing your gift, which they can redeem with ease. Sign up now in just minutes.
                </div>
                <div class="col-md-3">
                    <img src="<?php echo IWITNESS_THEME_URL; ?>/images/store/giftcard.gif">
                </div>
            </div>

            <div class="form-horizontal">
                <h4>Sender's Information</h4>

                <div class="form-group">
                    <label class="col-md-2 control-label">Sender's Name (From)</label>

                    <div class="col-md-7">
                        <input name="sender_name" id="sender-name" value="<?= sanitize_text_field($view_model['senderName']) ?>"
                               placeholder="" class="form-control" type="text" data-rule-required="true">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Sender's Email</label>

                    <div class="col-md-7">
                        <input name="sender_email" id="sender-email" placeholder=""
                               value="<?= sanitize_text_field($view_model['senderEmail']) ?>" class="form-control"
                               type="email" data-rule-required="true">
                        <input name="sender_email_hd" id="sender-email_hd"
                               value="<?= sanitize_text_field($view_model['senderEmail']) ?>" class="form-control"
                               type="hidden">
                        <input name="sender_user_hd" id="sender-user_hd"
                               value="<?= sanitize_text_field($user_val) ?>" class="form-control"
                               type="hidden">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Verify Email</label>

                    <div class="col-md-7">
                        <input name="sender_verify_email" id="sender-verify-email" placeholder=""
                               value="<?= sanitize_text_field($view_model['senderVerifyEmail']) ?>"
                               class="form-control" type="email" data-rule-required="true">
                    </div>
                </div>
            </div>

            <!-- sender info -->
            <hr>
            <!-- step 1 -->
			<h3>STEP 1) Gift Subscription</h3>
			<?php
$egiftcard_emails  = array('johndoe@gmail.com','dremer@remerinc.com', 'ajones@remerinc.com','terih@remerinc.com',' joe@jokonek.com','charwood@remerinc.com','bsiemen@remerinc.com');
			//echo "Email: ".$view_model['senderEmail'];
			if ($user_login){
				$plans['year']['price'] = 19.99;
			}
			if (in_array($view_model['senderEmail'], $egiftcard_emails)) {

			?>
            
            <div class="row">
                <div class="col-sm-2">
                    <label class="control-label">
					<input type="radio" id="free-gift-plan" name="plan" 
                               value="freegiftcard" data-rule-required="true">
                        <span class="text-danger">Sample gift card</span>
                    </label>
                </div>
                <span class="col-sm-3">One month subscription</span>
                <div class="col-sm-2 label label-default">Delivered Digitally</div>
			</div>
            <div class="row">
                <div class="col-sm-2">
                    <label class="control-label">
					<input type="radio" id="gift-plan" name="plan" checked="checked" 
                               value="giftplanyear" data-rule-required="true">
                        <span class="text-danger">$<?= sanitize_text_field($plans['year']['price']) ?></span>
                    </label>
                </div>
                <span class="col-sm-3">One year subscription</span>
                <div class="col-sm-2 label label-default">Delivered Digitally</div>
            </div>
            <?php } else{ ?>
            <div class="row">
                <div class="col-sm-2">
                    <label class="control-label">
					<input type="radio" id="gift-plan" name="plan" 
                               value="giftplanyear" data-rule-required="true">
                        <span class="text-danger">$<?= sanitize_text_field($plans['year']['price']) ?></span>
                    </label>
                </div>
                <span class="col-sm-3">One year subscription</span>
                <div class="col-sm-2 label label-default">Delivered Digitally</div>
			</div>
             <?php } ?>

            <br>

            <div class="form-horizontal">

                <div class="table-responsive">
                    <table id="recipient-table" class="table">
                        <thead>
                        <tr class="bg-grey">
                            <th width="10%" class="text-center">No</th>
                            <th>Recipient</th>
                            <th>Email</th>
                            <th>Delivery Date</th>
                            <th width="15%"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="no-data">
                            <td colspan="5" class="text-center">
                                No Recipients
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <div class="pull-right">Total:</div>
                            </td>
                            <td class="text-right"><span id="total-price-t">$0.00</span></td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="5">
                                <a class="btn btn-primary pull-right" id="add_another">Add Recipient</a>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>

            </div>

            <h3>Step 2) Payment information</h3>
            <?php include_once($plugin_path . '/templates/partial/payment-info.php'); ?>
            <!-- step 2 -->
        </div>

        <input type="hidden" id="recipients" name="recipients" value='[]'>
    </form>

    <!-- Modal -->
    <form class="modal form-horizontal fade" id="gift-card-detail" tabindex="-1" role="dialog"
          aria-labelledby="myModalLabel"
          aria-hidden="true">

        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel"><strong>Personalize your gift certificate</strong></h4>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="recipient-name">Recipient's Name (To)</label>

                        <div class="col-md-9">
                            <input type="text" id="recipient-name" name="recipient-name" class="form-control required"
                                   value="" data-rule-required="true">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="recipient-email">Recipient's Email</label>

                        <div class="col-md-9">
                            <input type="email" id="recipient-email" name="recipient-email" class="form-control"
                                   value="" data-rule-required="true">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="verify-email">Verify Email</label>

                        <div class="col-md-9">
                            <input type="email" class="form-control" id="verify-email" name="verify-email"
                                   value="" data-rule-equalTo="#recipient-email" data-rule-required="true">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="recipient-delivery-date">Delivery Date</label>

                        <div class="col-md-9">
                            <input value=""
                                   type="text"
                                   class="form-control"
                                   id="recipient-delivery-date"
                                   name="recipient-delivery-date"
                                   data-rule-required="true"
                                   data-rule-valid-date>

                            <p class="help-block">Please allow up to 24 hours for delivery</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="recipient-message">Personal Message</label>

                        <div class="col-md-9 personal-message" data-total-characters="500">
                            <textarea
                                id="recipient-message"
                                placeholder=""
                                class="form-control"
                                rows="5"
                                cols=""
                                data-rule-required = "true"
                                data-rule-maxlength="500"
                                name="recipient-message"></textarea>
                        </div>
                    </div>


                    <!-- start sample container -->
                    <div class="table-responsive" id="accordion">
                        <div class="sample">
                            <h5><a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Sample Gift Email</a>
                            </h5>

                            <div class="form-group collapse in" id="collapseOne">
                                <div class="mailerContainer">
                                    <div class="mailerlog">
                                        <div class="col-sm-4 col-sx-4">
                                            <img alt="iWitness" src="<?php echo IWITNESS_THEME_URL; ?>/images/logo.gif"
                                                 width="100%" class="img-responsive">
                                        </div>
                                        <div class="col-sm-8 col-sx-8">
                                            DON'T DELETE THIS MESSAGE!
                                            You've received an iWitness E-Gift!<br>
                                            You'll need the <a href="#">claim code</a> to activate your account
                                        </div>
                                    </div>
                                    <div class="mailerimg">
                                        <div class="col-sm-8 col-xs-7">
                                            <p class="title">SOMEONE WANTS TO KEEP YOU SAFE</p>

                                            <p class="text-muted">You have received an iWitness E-Gift.</p>

                                            <div class="mailerTo col-sm-12 col-xs-12">
                                                To: <strong><span id="mailer-to"></span></strong><br>
                                                From: <strong><span id="mailer-from"></span></strong><br>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-xs-5">
                                            <img src="<?php echo IWITNESS_THEME_URL; ?>/images/phones/medium_phone.png"
                                                 style="height: 90%; margin-top: 10px;" class="img-responsive pull-right"
                                                 alt="iWitness">
                                        </div>
                                    </div>
                                    <div class="mailer-gift">
                                        <div class="col-sm-7" id="mailer-text">Example: Please use this app to stay safe
                                            wherever you go, especially when you're alone.
                                        </div>
                                        <div class="col-sm-5" style="background-color: #eee; height: 100%;">
                                            <div
                                                style="text-align: center; font-size: 20px; font-weight: bold; color: #cb2e1e; margin: 16px 0;">
                                                ONE YEAR <br>GIFT SUBSCRIPTION
                                            </div>
                                            <a class="btn btn-primary btn-lg btn-block" href="#">REDEEM NOW</a>

                                            <div class="mailerClaim">Claim Code:
                                                <span>XXXXXXXXXX</span>
                                            </div>
                                            <div class="mailerlink">If you're unable to click through using the Redeem
                                                Now button above, go to <span><?php echo IWITNESS_PAGE_HOME; ?>
                                                    /claim-code?code=XXXXXXXXXX</span>
                                                to enter your claim code.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <p class="alert alert-warning">You will have the chance to add or subtract recipients and make
                            edits before making your purchase.</p>
                    </div>
                    <!-- end sample container -->


                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal" tabindex="-1">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>

            </div>
            <!-- end of modal content -->
        </div>
        <!-- end of modal dialog -->

    </form>
    <!-- end of modal -->
</div>

<?php
wp_print_scripts('iwitness-buy-gift-cards');
?>




