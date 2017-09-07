<?php
$user = $view_model['user'];
$friends = $view_model['friends'];
$info = $view_model['info'];
?>

<?php do_action('iwitness_print_notices'); ?>


<h2>Tell A Friend</h2>
<p class="lead">Introduce Your Friends To iWitness</p>
<hr>

<div class="row">
    <div class="col-md-9 col-xs-12">

        <form id="tell-a-friend-form" action="" data-validate="true" method="POST" role="form">

            <div class="form-group">
                <label for="first_name" class="control-label">Your first name:</label>
                <input type="text" class="form-control" name="first_name" id="first_name"
                       value="<?php echo isset($user) ? $user->firstName : ''; ?>" data-rule-required="true">
            </div>

            <div class="form-group">
                <label for="last_name" class="control-label">Your last name:</label>
                <input type="text" class="form-control" name="last_name" id="last_name"
                       value="<?php echo isset($user) ? $user->lastName : ''; ?>" data-rule-required="true">
            </div>

            <div class="form-group">
                <label for="email" class="control-label">Your email:</label>
                <input type="email" class="form-control" name="email" id="email"
                       value="<?php echo isset($user) ? $user->email : ''; ?>" data-rule-required="true">
            </div>

            <div class="email-box">
                <h5 style="margin-top: 5px;margin-left: 0px;">List up to 5 friend's email addresses:</h5>

                <?php for ($index = 1; $index <= 5; $index++): ?>
                    <div class="row">
                    <div class="form-group">
                        <label class="label-control col-md-1">Name</label>

                        <div class="col-md-5">
                            <input type="text"
                                   value=""
                                   id="user-<?= $index ?>"
                                   name="friends[<?php echo $index; ?>][name]"
                                    <?php echo $index == 1 ? 'data-rule-required="true"' : ''; ?>
                                   class="form-control">
                        </div>

                        <label class="label-control col-md-1">Email</label>

                        <div class="col-md-5">
                            <input type="email"
                                   data-disable-auto-completed=""
                                   value="<?php echo isset($friends[$index]) ? $friends[$index] : '' ?>"
                                   name="friends[<?php echo $index; ?>][email]"
                                   <?php echo $index == 1 ? 'data-rule-required="true"' : ''; ?>
                                   data-rule-require-if-has-value = "#user-<?= $index ?>"
                                   class="form-control">
                        </div>
                    </div>
                    </div>
                <?php endfor; ?>
            </div>

            <div class="form-group">
                <label for="subject" class="control-label">Subject line:</label>
                <input type="text" name="subject" id="subject"
                       class="form-control"
                       value="<?php echo $info['subject']; ?>"
                       data-rule-maxlength="100" data-rule-required="true">
            </div>

            <div class="form-group">
                <label for="message" class="control-label">Write a short message:</label>
                <textarea name="message" id="message" class="form-control" rows="3"
                          data-rule-maxlength="2000"
                          data-rule-required="true"><?php echo $info['message']; ?></textarea>
            </div>

            <?php /* $this->captcha->render($this) */ ?>

            <div class="clearfix"></div>
            <br>
            <button type="submit" class="btn btn-primary" name="action" value="do-tell-a-friend">Submit</button>
        </form>

    </div>
</div> <!-- end of container -->

