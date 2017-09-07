<?php do_action('iwitness_print_notices'); ?>

<?php
if(isset($view_model)):
    ?>
    <div id="profile">
        <h2>Profile</h2>
        <p class="lead">Reset your password</p>
        <hr>

        <form  method="POST" data-validate="true" role="form">

            <div class="form-horizontal">

                <div class="form-group">
                    <label for="old_password" class="col-md-3 control-label">Old Password</label>
                    <div class="col-md-5">
                        <input type="password" class="form-control" name="old_password" id="old_password"
                            data-rule-required="true">
                    </div>
                </div>

                <div class="form-group">
                    <label for="new_password" class="col-md-3 control-label">New Password</label>
                    <div class="col-md-5">
                        <input type="password" class="form-control" name="new_password" id="new_password"
                               data-rule-required="true" data-rule-minlength="8" data-rule-standard-password-format>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm_password" class="col-md-3 control-label">Confirm New Password</label>
                    <div class="col-md-5">
                        <input type="password" class="form-control" name="confirm_password" id="confirm_password"
                               data-rule-required="true" data-rule-equalTo="#new_password">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-5 col-md-offset-3">
                        <button type="submit" class="btn btn-primary" name="action" value="do_change_password">Submit</button>
                        <a class="btn btn-link" onclick="history.go(-1)">
                            Cancel
                        </a>
                    </div>
                </div>

            </div>

        </form>
    </div>

<?php
endif;
?>
