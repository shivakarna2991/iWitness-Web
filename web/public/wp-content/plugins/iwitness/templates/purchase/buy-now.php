<?php

$plans = $view_model['plans'];

$plugin_path = iWitness()->plugin_path();
switch ($view_model['page']) {
    case "common":
    case "renew":
        $plan_template = $plugin_path . '/templates/partial/common-plan.php';
  			$family_plan_template = $plugin_path . '/templates/partial/family-common-plan.php';
        break;
    case "seattleu":
        $plan_template = $plugin_path . '/templates/partial/seattle-university-plan.php';
        break;
    case "safekids":
        $plan_template = $plugin_path . '/templates/partial/safe-kid-plan.php';
        break;
    case "wspta":
        $plan_template = $plugin_path . '/templates/partial/wspta-plan.php';
        break;
    case "student":
        $plan_template = $plugin_path . '/templates/partial/student-plan.php';
        break;
    case "promo":
        $plan_template = $plugin_path . '/templates/partial/promo-plan.php';
        break;
}
?>

<?php do_action('iwitness_print_notices'); ?>

<?php include_once($plugin_path . '/templates/partial/subscription-notice.php'); ?>

<?php include_once($plugin_path . '/templates/partial/other-platform-notification.php'); ?>

    <form role="form" action="" method="POST" id="order">
        <div class="purchase order-form">
            <input type="hidden" name="action" value="iwitness_do_place_your_order"/>
            <h2>Purchase</h2>

            <p class="lead">Three easy steps to register</p>
            <hr/>

            <h3>Step 1) Choose your smartphone</h3>
            <?php include_once($plugin_path . '/templates/partial/choose-smart-phone.php'); ?>
						
          	<!--<h3>Step 2) Choose Plan Type</h3> -->
          	<?php /*?><?php include_once($plugin_path . '/templates/partial/choose-plan-type.php'); ?>
          	<?php include_once($plugin_path . '/templates/partial/users-info.php'); ?><?php */ ?>
          
            <div id="step2" class="individual">
                <?php include_once($plan_template); ?>
            </div>
          	<div id="step2" class="family" style="display:none">
                <?php include_once($family_plan_template); ?>
            </div>
						
            <h3>Step 3) Payment information</h3>

            <?php include_once($plugin_path . '/templates/partial/payment-info.php'); ?>
          	

        </div>

        <!-- Review region -->
      	<div id="step2" class="individual">
                <?php include_once($plugin_path . '/templates/partial/review-purchase.php'); ?>
            </div>
          	<div id="step2" class="family" style="display:none">
                <?php include_once($plugin_path . '/templates/partial/review-family-purchase.php'); ?>
            </div>
    </form>

<?php wp_print_scripts('iwitness-purchase-plugin'); ?>
