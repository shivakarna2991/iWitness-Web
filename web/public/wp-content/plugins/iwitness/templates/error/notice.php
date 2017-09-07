<?php
if (isset($notice_type)) {
    if ($notice_type == 'error') {
        $notice_type = 'danger';
    } elseif ($notice_type == 'notice') {
        $notice_type = 'info';
    } elseif ($notice_type == 'validation') {
        $notice_type = 'danger';
    }
}

if ($messages instanceof Recursive_ArrayAccess) {
    $messages = $messages->toArray();
} else {
    $messages = (array)$messages;
}

$auto_hide = isset($auto_hide) && (boolval($auto_hide) === true) ? 'alert-auto-hide' : '';

foreach ($messages as $message) :?>
    <div class="alert alert-<?php echo $notice_type; ?> alert-dismissable <?= $auto_hide?>">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $message; ?>
    </div>
<?php
endforeach;
?>