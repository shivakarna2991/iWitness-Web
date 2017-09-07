<?php
add_action('wp_ajax_validate_promotion_code', 'validate_promotion_code_callback');
add_action('wp_ajax_nopriv_validate_promotion_code', 'validate_promotion_code_callback');

add_action('wp_ajax_get_promotion_code', 'get_promotion_code_callback');
add_action('wp_ajax_nopriv_get_promotion_code', 'get_promotion_code_callback');


add_action('wp_ajax_validate_phone_number', 'validate_phone_number_callback');
add_action('wp_ajax_nopriv_validate_phone_number', 'validate_phone_number_callback');

add_action('wp_ajax_validate_email_duplicate', 'validate_validate_email_duplicate_callback');
add_action('wp_ajax_nopriv_validate_email_duplicate', 'validate_validate_email_duplicate_callback');

/**
 * Validate promotion code
 */
function validate_promotion_code_callback()
{
    $promoCode = iwitness_get_submit_value('promoCode');
    if (empty($promoCode)) {
        echo '"Please enter Promo code"';
        die;
    }
    try {
        iwitness_api_get('/subscription/validate/promo/' . rawurlencode($promoCode));
        echo "true";
    } catch (Exception $ex) {
        iwitness_log_error($ex);
        echo '"' . $ex->getMessage() . '"';
    }
    die;
}


function get_promotion_code_callback()
{
    $promoCode = iwitness_get_submit_value('promoCode');
    try {
        $response = iwitness_api_get('/coupon?code=' . rawurlencode($promoCode));
        $response = iwitness_api_response_filter($response, 'coupon', true);
        header("Content-type: application/json");
        echo json_encode($response);
    } catch (Exception $ex) {
        iwitness_log_error($ex);
        echo json_encode($ex->getMessage());
    }
    die;
}


/**
 * Validate phone number exists
 */
function validate_phone_number_callback()
{
    $phone = iwitness_get_post_field_phone_number('phone');

    if (empty($phone)) {
        echo '"Please enter phone number"';
        die;
    }

    try {
        $response = iwitness_api_get('/user/validate/phone/' . $phone);
        if (isset($response['status']) && $response['status'] == 200) {
            echo "true";
        } else {
            echo "false";
        }
    } catch (Exception $ex) {
        iwitness_log_error($ex);
        echo '"' . $ex->getMessage() . '"';
    }
    die;
}

/**
 * Validate user email is in use
 */
function validate_validate_email_duplicate_callback()
{
    $email = iwitness_get_submit_value('email');
    if (empty($email)) {
        echo "false";
        die;
    }

    $login_user = get_user_by('email', $email);
    if ($login_user instanceof WP_User) {
        echo "false";
        die;
    }
    echo "true";
    die;
}


/**
 * Validate gift card email
 */
function validate_validate_gift_card_email_callback()
{
    $email = iwitness_get_submit_value('email');
    if (empty($email)) {
        echo '"Please enter email"';
        die;
    }

    try {
        iwitness_api_get('/subscription/validate/email/' . $email);
        echo "true";
    } catch (Exception $ex) {
        iwitness_log_error($ex);
        echo '"' . $ex->getMessage() . '"';
    }
    die;
}


/**
 * @param $key
 * @param string $default
 * @return string
 */
function iwitness_get_submit_value($key, $default = '')
{
    $value = $default;

    if (isset($_GET[$key])) {
        $value = $_GET[$key];
    }

    if (isset($_POST[$key])) {
        $value = $_POST[$key];
    }

    return $value;
}