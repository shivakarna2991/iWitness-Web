<?php do_action('iwitness_print_notices'); ?>

<div class="form-group">
    <h2>Congratulations!</h2>
    <hr>
    You've successfully sent an iWitness Gift Subscription to:
    <ul>
    <?php
    foreach ($view_model as $recipient):
        echo '<li>' . '<a href="mailto:' . $recipient['email'] . '">' . $recipient['name'] . " - " . $recipient['email'] . '</a></li>' ;
    endforeach;
    ?>
    </ul>
</div>

<div class="form-group">
    <a href="<?php echo iwitness_get_page_path(IWITNESS_PAGE_GIFT_CARD_ID) ?>">Give Another Subscription</a>
</div>

<div class="form-group">
    <p>
        The information contained in this message may be privileged, confidential, and protected from
        disclosure. If
        you are not the intended recipient, or person responsible for delivering this message to the intended
        recipient, you are hereby notified that any dissemination, distribution, or copying of this
        communication is
        strictly prohibited. If you have received this communication in error, please notify us immediately by
        replying to the message and deleting from your computer.<br>
        <br>
        To ensure you receive our emails in your inbox, add info@iwitness.com to your address book.<br>
        <br>
        &copy; <?= date('Y') ?> iWitness, Inc. All rights reserved. We respect your right to privacy -
        <a href="/content-terms-of-service" style="text-decoration:underline;">View Our Privacy Policy</a>.
    </p>
</div>
