<?php do_action('iwitness_print_notices'); ?>

<h2>Contact Confirmation</h2>
<?php if ($view_model['isValidToken']): ?>
    <p class="lead">Protect a friend in danger</p>
<?php endif; ?>
<hr>
<?php 
//$contact = $view_model['contact'];
//$status = $contact['flags'];
?>
<?php if (!$view_model['isValidToken']): ?>
    <div class="alert alert-danger alert-dismissable">
        <?= $view_model['error'] ?>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    </div>

<?php else: ?>

    <form action="" method="POST" role="form">
        <input type="hidden" name="token" value="<?php echo $view_model['token'] ?>"/>
        <input type="hidden" name="decline" value="<?php echo $view_model['decline'] ?>"/>

        <?php if (!$view_model['decline']): ?>
            <p>
                <strong>I agree</strong> to be a trusted contact for <?= iwitness_display_name($view_model['user']) ?>
                in case of emergency.
            </p>
        <?php else: ?>
            <p>
                <strong>I decline</strong> to be a trusted contact
                of <?= iwitness_display_name($view_model['contact']) ?> in case of emergency.
            </p>
        <?php endif; ?>
        <br>
        <button class="btn btn-primary" type="submit" name="action" value="iwitness_do_contact_confirm">Confirm</button>
    </form>
<?php endif; ?>
