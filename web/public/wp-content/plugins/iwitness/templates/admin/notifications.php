<?php
do_action('iwitness_print_notices');
?>

<h2>Notification Manage</h2>
<p class="lead">Send notification message to user</p>
<hr>

<div id="notification-container">
    <form id="notification-form" action="" method="POST" role="form" data-validate="true" novalidate="novalidate">
        <div class="form-group">
            <label for="select2-user-id" class="control-label">Searching user by phone number:</label>
            <input type="text" id="select2-user-id" name="select2-user-id" class="form-control" data-rule-required="true">
        </div>

        <div class="form-group">
            <label for="message" class="control-label">Message:</label>
            <textarea id="message" name="message" class="form-control" rows="5" data-rule-required="true"></textarea>
        </div>

        <div class="form-group">
            <button class="btn btn-primary" type="submit" name="action" value="do_send_notification">Send</button>
        </div>
    </form>
</div>

<?php
// lazy loading style and script
wp_print_scripts('iwitness-notification-plugin');
?>