<?php

$message = null;
if (isset($view_model['api_user'])) {
    $alert = 'info';
    /** @var iWitness_User $user */
    $user = $view_model['api_user'];
    if (!$user->isAdmin()) {
        if ($user->isFree()) {
            $message = "You are currently using a free subscription. Use the form below to change to a paid subscription.";
        } elseif ($user->hasExpired()) {
            $message = "Your subscription expired on "
                . iwitness_view_helper_format_date($user->subscriptionExpireAt) . ', please renew it below.';
            $alert = 'danger';
        } else {
            $message = "Your subscription is currently valid and will expire on "
                . iwitness_view_helper_format_date($user->subscriptionExpireAt) . '.';
        }
    }
}

if ($message): ?>

    <div class="alert alert-<?= $alert ?>" role="alert">
        <strong><?php echo $message ?></strong>
    </div>

<?php endif; ?>

