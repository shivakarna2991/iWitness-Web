<?php do_action('iwitness_print_notices'); ?>

<h2>Create Account</h2>
<p class="lead">Get Started Now</p>
<hr>

<div class="row">
    <div class="col-md-6 col-xs-12">
        <form id="signup-form" action="" method="post"  role="form">
            <input type="hidden" name="subscription_uuid"
                   value="<?php echo $view_model['subscriptionUuid'] ?>"/>
            <input type="hidden" name="action" value="do_sign_up"/>

            <div class="form-group">
                <label for="phone11" class="control-label">Wireless number *</label>
                <input class="form-control" type="text" id="phone11" name="phone11"
                       value="<?php echo iwitness_view_helper_format_phone($view_model['phone']) ?>"
                        data-rule-required="true" data-rule-wireless-phone>
            </div>

            <div class="form-group">
                <label for="email" class="control-label">Email</label>
                <input class="form-control" type="email" id="email" name="email" value="<?php echo $view_model['email'] ?>"
                       data-rule-required="true" data-rule-maxlength="40"/>
            </div>

            <div class="form-group">
                <label for="password" class="control-label">Password</label>
                <input class="form-control" type="password" id="password" name="password"
                       data-rule-required="true" data-rule-minlength="8" data-rule-standard-password-format />
            </div>

            <div class="form-group">
                <label for="repeat_password" class="control-label">Re-enter password</label>
                <input class="form-control" type="password" id="repeat_password" name="repeat_password"
                       data-rule-required="true" data-rule-equalTo="#password" />
            </div>

            <p>
                You will receive a text message (message rates may apply) on your device with a link to
                download the iWitness app. Tap on the link, download the app, then use your wireless number
                and the password you just created to log in.
            </p>

            <div class="form-group">
                <br>
                <button class="sign-up btn btn-primary" type="submit">&nbsp;&nbsp;GO&nbsp;&nbsp;</button>
            </div>
        </form>
    </div>
</div>

<?php
wp_print_scripts('iwitness-sign-up-plugin');
?>

<?php if (!$view_model['retry']): ?>
    <!-- Google Code for Purchase Conversion Page -->
    <script type="text/javascript">
        /* <![CDATA[ */
        var google_conversion_id = 1002717869;
        var google_conversion_language = "en";
        var google_conversion_format = "2";
        var google_conversion_color = "ffffff";
        var google_conversion_label = "aEUMCOO-7AIQrYWR3gM";
        var google_conversion_value = 0;
        /* ]]> */
    </script>
    <script type="text/javascript" src="https://www.googleadservices.com/pagead/conversion.js">
    </script>
    <noscript>
        <div style="display:inline;">
            <img height="1" width="1" style="border-style:none;" alt=""
                 src="https://www.googleadservices.com/pagead/conversion/1002717869/?label=aEUMCOO-7AIQrYWR3gM&guid=ON&script=0"/>
        </div>
    </noscript>
    <iframe
        src="https://iWitness-CPS.7eer.net/ifconv/?irchannel=3071&cid=1332&oid=<?= $view_model['subscriptionUuid'] ?>&cat1=1&sku1=<?= $view_model['plan'] ?>&qty1=1&amt1=<?= $view_model['amt'] ?>&promocode=<?= $view_model['promo_code'] ?>"
        width="1" height="1" frameborder="0" scrolling="no"></iframe>
<?php endif; ?>
