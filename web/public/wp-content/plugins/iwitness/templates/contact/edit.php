<?php do_action('iwitness_print_notices'); ?>

<?php
$contacts = $view_model;
?>

<h2>Emergency Contacts</h2>
<p class="lead">Who do you want notified in case of an emergency?</p>
<a href="<?php echo iwitness_get_page_path(IWITNESS_PAGE_CONTACT_LIST_ID); ?>">My contacts</a>
<hr>

<div class="row">
    <?php for ($i = 0; $i < iWitness()->get_num_of_contact_config(); $i++):
        $contact = isset($contacts[$i]) ? $contacts[$i] : null;
        $id = isset($contact['id']) ? $contact['id'] : '';
        $email = isset($contact['email']) ? $contact['email'] : '';
        $action = 'iwitness_do_update_contact';
        $first_name = isset($contact['firstName']) ? $contact['firstName'] : '';
        $last_name = isset($contact['lastName']) ? $contact['lastName'] : '';
        $relation_type = isset($contact['relationType']) ? $contact['relationType'] : '';
        $phone = isset($contact['phone']) ? $contact['phone'] : '';
    ?>

    <?php if (($i) % 3 == 0): ?>
</div>
<div class="row">
    <?php endif; ?>

    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
        <form id="contact-<?php echo $i; ?>" action="" method="POST" data-validate="false" class="contact-form">

            <div id="error-block" class="alert alert-danger alert-dismissable"></div>
            <div id="success-block" class=" alert alert-success alert-dismissable"></div>

            <div class="hide">
                <!-- thanks ie7 -->
                <input type="hidden" name="form_id" value="contact-<?php echo $i ?>"/>
                <input type="hidden" name="key" value="<?php echo $id ?>"/>
                <input type="hidden" name="is_primary" value="<?php echo(0 == $i ? '1' : '0') ?>"/>
                <input type="hidden" name="action" value="<?php echo $action; ?>">
            </div>

            <div class="panel panel-default widget">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <div><?php echo($i + 1) ?>.</div>
                    </h3>
                    <?php if (0 == $i): ?>
                        <span class="label label-success pull-right"
                              style="margin-top: -20px;">Primary Contact</span>
                    <?php endif; ?>
                </div>

                <div class="panel-body">

                    <div class="form-group">
                        <label for="first_name_<?php echo $i ?>" class="control-label">First Name</label>
                        <input type="text"
                               class="form-control"
                               id="first_name_<?php echo $i ?>"
                               name="first_name"
                               value="<?php echo $first_name ?>"
                               data-rule-required = "true"
                               data-rule-maxlength="40"
                               placeholder="First Name">
                    </div>

                    <div class="form-group">
                        <label for="last_name_<?php echo $i ?>" class="control-label">Last Name</label>
                        <input type="text"
                               class="form-control"
                               id="last_name_<?php echo $i ?>"
                               name="last_name"
                               value="<?php echo $last_name ?>"
                               data-rule-required = "true"
                               data-rule-maxlength="40"
                               placeholder="Last Name">
                    </div>

                    <div class="form-group">
                        <label for="relationship_<?php echo $i ?>" class="control-label">Relationship</label>
                        <input type="text"
                               class="form-control"
                               id="relationship_<?php echo $i ?>"
                               name="relationship"
                               value="<?php echo $relation_type ?>"
                               data-rule-required = "true"
                               data-rule-maxlength="40"
                               placeholder="Relationship">
                    </div>

                    <div class="form-group">
                        <label for="phone_<?php echo $i ?>" class="control-label">Wireless Number</label>
                        <input type="text"
                               class="form-control"
                               id="phone_<?php echo $i ?>"
                               name="phone"
                               value="<?php echo iwitness_view_helper_format_phone($phone) ?>"
                               data-rule-required = "true"
                               data-rule-maxlength="15"
                               data-rule-wireless-phone
                               placeholder="Phone">
                    </div>

                    <div class="form-group">
                        <label for="contact_email_<?php echo $i ?>" class="control-label">Email Address</label>
                        <input type="email"
                               class="form-control"
                               id="contact_email_<?php echo $i ?>"
                               name="email"
                               value="<?php echo $email ?>"
                               data-rule-required = "false"
                               data-rule-maxlength="120"
                               placeholder="Email">
                    </div>

                </div>

                <div class="panel-footer">
                    <button type="submit" class="btn btn-primary btn-block">Save</button>
                </div>
            </div>

        </form>
    </div>

    <?php endfor; ?>

</div>

<?php
wp_print_scripts('iwitness-contact-plugin');
?>
