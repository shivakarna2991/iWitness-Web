<?php

iwitness_clear_notices();

if ($error instanceof Exception) {
    $errors = array($error->getCode() => $error->getMessage());
} elseif (!is_array($error)) {
    $errors = array('' => $error);
} else {
    $errors = $error;
}

foreach ($errors as $code => $messages) {
    ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php if (!empty($code) || intval($code) != 0) {
            echo $code . ':';
        } ?>

        <?php if (!is_array($messages)) {
            echo $messages;
        } else {
            echo(implode('<br/>', $messages));
        } ?>

    </div>
<?php
}
?>


