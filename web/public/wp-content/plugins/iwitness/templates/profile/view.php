<?php do_action('iwitness_print_notices'); ?>

<?php
/** @var iWitness_User $user */
$user = $view_model['api_user'];
$contact = $view_model['contact'];
$user_gender = "male";
if ($user && $user->gender==1)
	    $user_gender= "female";
?>

<div id="profile">
    <h2>Profile</h2>
    <p class="lead">Manage your personal profile</p>
    <hr>

    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
            <img data-src="holder.js/100%x180"
                 id="profile-photo" src="<?php echo $user->get_user_image(); ?>"
                 class="img-responsive center-block" alt="No Image"
                 onerror="this.src='<?php echo iWitness_User::get_anonymous_profile_image(); ?>'">

            <a class="btn btn-primary btn-sm btn-block"
               href="<?php echo iwitness_get_page_path(IWITNESS_PAGE_USER_PROFILE_EDIT_ID); ?>">EDIT
                PROFILE</a>
            <a class="btn btn-primary btn-sm btn-block"
               href="<?php echo iwitness_get_page_path(IWITNESS_PAGE_CHANGE_PASSWORD_ID); ?>">RESET
                PASSWORD</a>
            <a class="btn btn-primary btn-sm btn-block"
               href="<?php echo iwitness_get_page_path(IWITNESS_PAGE_CHANGE_NUMBER_ID); ?>">
                &nbsp;CHANGE WIRELESS NUMBER&nbsp;</a>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">

        <?php if (
            !$user->timezone ||
            !$user->address1 ||
            !$user->city ||
            !$user->state ||
            !$user->zip ||
            !($user->heightInches || $user->heightFeet) ||
            !$user->weight ||
            !$user_gender ||
            !$user->birthDate ||
            !$user->eyeColor ||
            !$user->hairColor ||
            !$user->ethnicity ||
            !$user->distFeature ||
            !$contact['total']
        ): ?>
            <div class="alert alert-warning">
                <h4>You're profile is incomplete</h4>
                <p>
                    We recommend you complete your profile information to help ensure your safety.
                    The following information is currently missing.
                </p>
                <br>
                <ul>
                    <?php
                    $missing = array();
                    if (!$user->firstName) $missing[] = 'First Name';
                    if (!$user->lastName) $missing[] = 'Last Name';
                    ?>
                    <?php if (!empty($missing)): ?>
                        <li>
                            <?= implode(', ', $missing); ?>
                        </li>
                    <?php endif; ?>
                    <?php
                    $missing = array();
                    if (!$user->address1 ||
                        !$user->city ||
                        !$user->state ||
                        !$user->zip):
                    ?>
                    <li>
                        Valid Address
                    </li>
                    <?php endif; ?>

                    <?php
                    $missing = array();
                    $hasHeight = $user->heightInches || $user->heightFeet;
                    if (!$hasHeight) $missing[] = 'Height';
                    if (!$user->weight) $missing[] = 'Weight';
                    if (!$user->birthDate) $missing[] = 'Age';
                    if (!$user->gender) $missing[] = 'Gender';
                    ?>
                    <?php if (!empty($missing)): ?>
                        <li>
                            <?= implode(', ', $missing); ?>
                        </li>
                    <?php endif; ?>

                    <?php
                    $missing = array();
                    if (!$user->eyeColor) $missing[] = 'Eye Color';
                    if (!$user->hairColor) $missing[] = 'Hair Color';
                    if (!$user->ethnicity) $missing[] = 'Ethnicity';
                    ?>
                    <?php if (!empty($missing)): ?>
                        <li>
                            <?= implode(', ', $missing); ?>
                        </li>
                    <?php endif; ?>

                    <?php if (!$user->distFeature): ?>
                        <li>
                            Distinguishing Features
                        </li>
                    <?php endif; ?>

                    <?php if (!$contact['total']): ?>
                        <li>
                            <a href="<?php echo iwitness_get_page_path(IWITNESS_PAGE_CONTACT_EDIT_ID) ?>">
                                Emergency Contacts</a>
                        </li>
                    <?php endif; ?>
                </ul>

            </div> <!-- end of alert box -->
        <?php endif; ?>

        <div class="row">

                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

                    <div class="form-horizontal">

                        <div class="form-group">
                            <label class="col-md-3 control-label">Name:</label>

                            <div class="col-md-9">
                                <?php echo $user->get_full_name(); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Address:</label>

                            <div class="col-md-9">
                                <?php echo $user->get_address(); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Wireless Number:</label>

                            <div class="col-md-9">
                                <?php echo $user->get_wireless_number(); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Email Address:</label>

                            <div class="col-md-9">
                                <?php echo $user->get_email(); ?>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="form-horizontal">

                        <div class="form-group">
                            <label class="col-md-3 control-label">Gender:</label>

                            <div class="col-md-9">
                                <?php echo $user->get_gender(); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Age:</label>

                            <div class="col-md-9">
                                <?php echo $user->get_birthday(); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Height:</label>

                            <div class="col-md-9">
                                <?php echo $user->get_height(); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Weight:</label>

                            <div class="col-md-9">
                                <?php echo $user->get_weight(); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Ethnicity:</label>

                            <div class="col-md-9">
                                <?php echo $user->get_ethnicity(); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Eye color:</label>

                            <div class="col-md-9">
                                <?php echo $user->get_eyes_color(); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Hair color:</label>

                            <div class="col-md-9">
                                <?php echo $user->get_hair_color(); ?>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="row">

                <dl class="dl-horizontal">

                    <dt>Distinguishing Features:</dt>
                    <dd>
                        <?php echo $user->get_dist_features(); ?>
                    </dd>

                    <dt>Contacts:</dt>
                    <dd>

                        <?php if ($contact['total']): ?>
                            You&rsquo;ve sent out <?= $contact['total'] ?>
                            contact <?= iwitness_view_helper_pluralize($contact['total'], 'request', 'requests') ?>.
                            <p>
                                <span class="label label-success">+</span> <?php echo $contact['accepted']; ?>
                                <?php echo iwitness_view_helper_pluralize($contact['accepted'], "has", "have"); ?> accepted
                            </p>
                            <p>
                                <span class="label label-warning">?</span> <?php echo $contact['pending']; ?>
                                <?php echo iwitness_view_helper_pluralize($contact['pending'], "hasn't", "haven't"); ?> responded
                            </p>
                            <p>
                                <span class="label label-danger">&ndash;</span> <?php echo $contact['declined']; ?>
                                <?php echo iwitness_view_helper_pluralize($contact['declined'], "has", "have"); ?> declined
                            </p>
                            <p>
                                <a class="view-contacts"
                                   href="<?php echo iwitness_get_page_path(IWITNESS_PAGE_CONTACT_LIST_ID); ?>">View</a> contacts page
                            </p>
                        <?php else: ?>
                            You haven&rsquo;t added any contacts yet, <a
                                href="<?php echo iwitness_get_page_path(IWITNESS_PAGE_CONTACT_EDIT_ID); ?>">add them now</a>.
                        <?php endif; ?>

                    </dd>
                </dl>

            </div>

        </div>

    </div>
    <!-- end of row container -->

</div> <!-- end profile container -->
