<?php do_action('iwitness_print_notices'); ?>

<div id="profile">
    <h2>Profile</h2>

    <p class="lead">Change your Wireless Number</p>
    <hr>

    <form method="POST" data-validate="true" role="form">

        <div class="form-horizontal">

            <div class="form-group">
                <label for="phone" class="col-md-3 control-label">New Wireless Number</label>

                <div class="col-md-5">
                    <input type="text" name="phone" id="phone" class="form-control" maxlength="14"
                           value="<?= !empty($view_model['phone']) ? iwitness_view_helper_format_phone($view_model['phone']) : '' ?>"
                           placeholder="e.g. <?= iwitness_view_helper_format_phone('12345678900') ?>"
                           data-rule-required="true">
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="col-md-3 control-label">Verify Account Password</label>

                <div class="col-md-5">
                    <input type="password" class="form-control" name="password" id="password" data-rule-required="true">
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-5 col-md-offset-3">
                    <button type="submit" class="btn btn-primary" name="action" value="do_change_number">Submit</button>
                </div>
            </div>

        </div>
    </form>
</div>
