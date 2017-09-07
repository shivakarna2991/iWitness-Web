<?php
$contacts = $view_model;
$total_contacts = count($contacts);
?>

<?php do_action('iwitness_print_notices'); ?>

    <h2>Emergency Contacts</h2>
    <a class="btn btn-primary pull-right" href="<?php echo iwitness_get_page_path(IWITNESS_PAGE_CONTACT_EDIT_ID); ?>">
        Manage Contacts
    </a>
    <p class="lead">
        Who do you want notified in case of an emergency?
    </p>
    <hr>

    <p>
        Add up to 6 trusted contacts who you would want notified whenever you feel endangered and you
        engage an iWitness event. We recommend listing all six possible contacts as it increases the
        chances that someone will notice the alert and respond quickly. Once you add a contact, that
        person will be notified by email/text and asked to verify their contact status. The status of
        each contact will appear below and on your profile page.
    </p>
<hr>

<?php if (!isset($total_contacts) || $total_contacts <= 0) : ?>
    Start by <a href="<?php echo iwitness_get_page_path(IWITNESS_PAGE_CONTACT_EDIT_ID); ?>">adding your first
        contact</a>.
<?php else: ?>
    <div class="row">
    <?php foreach ($contacts as $i => $entry):
        $flags = isset($entry['flags']) ? intval($entry['flags']) : '&nbsp;';
        $email = isset($entry['email']) ? $entry['email'] : '&nbsp;';
        $first_name = isset($entry['firstName']) ? $entry['firstName'] : '&nbsp;';
        $last_name = isset($entry['lastName']) ? $entry['lastName'] : '&nbsp;';
        $relation_type = isset($entry['relationType']) ? $entry['relationType'] : '&nbsp;';
        $phone = isset($entry['phone']) ? $entry['phone'] : '&nbsp;';
        $alert_label = $flags == 1 ? 'label-warning' : ($flags == 2 ? 'label-success' : ($flags == 4 ? 'label-danger' : '&nbsp;'));
        $alert_text = $flags == 1 ? 'Pending' : ($flags == 2 ? 'Accepted' : ($flags == 4 ? 'Decline' : '&nbsp;'));
        ?>
        <?php if (($i) % 3 == 0): ?>
        </div>
        <div class="row">
    <?php endif; ?>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <div class="contact panel panel-default widget">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <?php echo $first_name . ' ' . $last_name ?>
                    </h3>
                    <span class="label <?php echo $alert_label; ?> pull-right"><?php echo $alert_text; ?></span>
                </div>
                <div class="panel-body">
                    <p><strong>Relation:</strong> <?php echo $relation_type ?></p>

                    <p><strong>Phone:</strong> <?php echo iwitness_view_helper_format_phone($phone) ?></p>

                    <p><strong>Email:</strong> <?php echo $email ?></p>
                </div>
                <div class="panel-footer">
                    <form action="" method="POST" role="form">
                        <input type="hidden" name="id" value="<?= $entry['id'] ?>">

                        <div class="text-center">
                            <button type="submit" class="btn btn-danger btn-sm" name="action"
                                    value="iwitness_do_delete_contact">Delete
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>

<?php endif; ?>
