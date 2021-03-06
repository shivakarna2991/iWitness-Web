<?php do_action('iwitness_print_notices'); ?>

<?php
/** @var $user iWitness_User */
$user = $view_model['user'];
$contact = $view_model['contact'];
$status = $contact['flags'];
$message = null;

if ($status == 2):
    $message = "You are now a emergency contact for " . iwitness_display_name($user);
else:
    $message = "You have <strong>declined</strong> to be a emergency contact for " . iwitness_display_name($user);
endif;
?>

    <h2>Contact Confirmation</h2>
<?php if ($status == 2): ?>
    <p class="lead">Protect a friend in danger</p>
<?php endif; ?>
    <hr>

<?php
iwitness_get_template("error/notice.php", array(
    'messages' => $message,
    'notice_type' => 'success'
));
?>
