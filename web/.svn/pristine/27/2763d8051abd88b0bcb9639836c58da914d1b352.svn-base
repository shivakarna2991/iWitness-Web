<?php

/**
 * Render View function: base function for render the view template for all views
 *
 * @param $view_path
 * @param callable $do_authorize_action
 * @param callable $get_view_model_action
 * @return string
 */
function iwitness_render_view($view_path, callable $do_authorize_action = null, callable $get_view_model_action = null)
{
    ob_start();

    try {
        //get path
        $path = $view_path;
        if (is_callable($view_path)) {
            $path = call_user_func($view_path);
        }

        // assert authorization action
        $is_valid = $do_authorize_action != null ? call_user_func($do_authorize_action) : true;
        if (!$is_valid) {
            throw new Exception('You do not have sufficient permissions to access this page');
        }

        // get the view model action
        $view_model = $get_view_model_action != null ? call_user_func($get_view_model_action) : array();

        // render the view with template and view model
        iwitness_get_template($path . '.php', array('view_model' => $view_model));

    } catch (\Exception $ex) {
        if ($ex instanceof iWitness_Api_Exception && $ex->is_expired_exception()) {
            iwitness_get_template('profile/renewal-guidance.php');
        } else {
            iwitness_get_template('error/error.php', array('error' => $ex));
        }
    }

    wp_reset_postdata();
    return ob_get_clean();
}

/**
 * @param $action
 * @param callable $get_form_data_action
 * @param callable $do_post_back_action
 */
function iwitness_do_form_action($action, callable $get_form_data_action = null, callable $do_post_back_action = null)
{
    // validate action
    if ('POST' !== strtoupper($_SERVER['REQUEST_METHOD'])) {
        return false;
    }

    if (empty($_POST['action']) || ($action !== $_POST['action'])) {
        return false;
    }

    // get and validate form data
    $data = $get_form_data_action != null ? call_user_func($get_form_data_action) : array();

    // processing post back data
    if (iwitness_notice_count('error') == 0) {
        try {
            if ($do_post_back_action) {
                $response = call_user_func($do_post_back_action, $data);
            }
        } catch (Exception $ex) {
            iwitness_handle_submit_exception($ex);
        }
    }
}

/**
 * Get template part
 *
 * @access public
 * @param mixed $slug
 * @param string $name (default: '')
 * @return void
 */
function iwitness_get_template_part($slug, $name = '')
{
    $template = '';

    // Look in yourtheme/slug-name.php and yourtheme/iwitness/slug-name.php
    if ($name) {
        $template = locate_template(array("{$slug}-{$name}.php", iWitness()->template_path() . "{$slug}-{$name}.php"));
    }

    // Get default slug-name.php
    if (!$template && $name && file_exists(WC()->plugin_path() . "/templates/{$slug}-{$name}.php")) {
        $template = iWitness()->plugin_path() . "/templates/{$slug}-{$name}.php";
    }

    // If template file doesn't exist, look in yourtheme/slug.php and yourtheme/iwitness/slug.php
    if (!$template) {
        $template = locate_template(array("{$slug}.php", iWitness()->template_path() . "{$slug}.php"));
    }

    // Allow 3rd party plugin filter template file from their plugin
    $template = apply_filters('iwitness_get_template_part', $template, $slug, $name);

    if ($template) {
        load_template($template, false);
    }
}

/**
 * Get other templates passing attributes and including the file.
 *
 * @access public
 * @param string $template_name
 * @param array $args (default: array())
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 * @return void
 */
function iwitness_get_template($template_name, $args = array(), $template_path = '', $default_path = '')
{
    if ($args && is_array($args)) {
        extract($args);
    }

    $located = iwitness_locate_template($template_name, $template_path, $default_path);

    if (!file_exists($located)) {
        _doing_it_wrong(__FUNCTION__, sprintf('<code>%s</code> does not exist.', $located), '1.0');
        return;
    }

    do_action('iwitness_before_template_part', $template_name, $template_path, $located, $args);
    include($located);
    do_action('iwitness_after_template_part', $template_name, $template_path, $located, $args);
}


/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 *        yourtheme        /    $template_path    /    $template_name
 *        yourtheme        /    $template_name
 *        $default_path    /    $template_name
 *
 * @access public
 * @param string $template_name
 * @param string $template_path (default: '')
 * @param string $default_path (default: '')
 * @return string
 */
function iwitness_locate_template($template_name, $template_path = '', $default_path = '')
{
    if (!$template_path) {
        $template_path = iWitness()->template_path();
    }

    if (!$default_path) {
        $default_path = iWitness()->plugin_path() . '/templates/';
    }

    // Look within passed path within the theme - this is priority
    $template = locate_template(
        array(
            trailingslashit($template_path) . $template_name,
            $template_name
        )
    );

    // Get default template
    if (!$template) {
        $template = $default_path . $template_name;
    }

    // Return what we found
    return apply_filters('iwitness_locate_template', $template, $template_name, $template_path);
}



//string function
/**
 * @param $haystack
 * @param $needle
 * @return bool
 */
function iwitness_string_start_with($haystack, $needle)
{
    return $needle === "" || strpos($haystack, $needle) === 0;
}

/**
 * @param $haystack
 * @param $needle
 * @return bool
 */
function iwitness_string_end_with($haystack, $needle)
{
    return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
}


/**
 * Get the actually path to specific key
 *
 * @param $page_key
 * @return string: actually path to the page with key is defined
 */
function iwitness_get_page_path($page_key)
{
    return IWITNESS_PAGE_HOME . '/' . $page_key;
}

/**
 * @param $action
 * @return bool
 */
function iwitness_validate_submit($actions, $validate_login = true)
{
    if ('POST' !== strtoupper($_SERVER['REQUEST_METHOD'])) {
        return false;
    }

    $actions = (array)$actions;
    if (empty($_POST['action']) || (!in_array($_POST['action'], $actions))) {
        return false;
    }

    if ($validate_login) {
        $user_id = get_current_user_id();
        if ($user_id <= 0) {
            //todo: do nothing in silent, strange. It would better throw exception
            return false;
        }
    }

    return true;
}

/**
 * @param $field_name
 * @param bool $sanitize
 * @param string $default
 * @return string
 */
function iwitness_get_post_field_value($field_name, $sanitize = true, $default = '')
{
    $value = isset($_POST[$field_name]) ? $_POST[$field_name] : $default;
    if ($sanitize) {
        return sanitize_text_field($value);
    }
    return $value;
}

/**
 * @param string $field
 * @return null|string
 */
function iwitness_get_post_sort_field_value($field = 'sort')
{
    $sorts = array();
    $params = isset($_POST[$field]) ? $_POST[$field] : null;
    if ($params && is_array($params) && count($params)) {
        foreach ($params as $field => $direct) {
            $sorts[] = ($direct == 'desc') ? '-' . $field : '+' . $field;
        }
    }

    if (count($sorts)) {
        return implode(',', $sorts);
    }
    return null;
}


/**
 * Get phone number
 * @param $field_name
 * @param string $default
 * @return mixed
 */
function iwitness_get_post_field_phone_number($field_name, $default = '')
{
    $phone = !empty($_POST[$field_name]) ? $_POST[$field_name] : $default;
    return preg_replace('~[^0-9]~', '', $phone);
}


/**
 * Show empty error message for validate the input field
 *
 * @param $field_name
 * @param $display_field_name
 * @return bool
 */
function iwitness_show_empty_error_message($field_name, $display_field_name)
{
    if (empty($field_name)) {
        iwitness_add_notice('Please enter the ' . $display_field_name, 'error');
    }

    return empty($field_name);
}

/**
 * Show not a valid email error message for validate the input field
 *
 * @param $field_name
 * @param $display_field_name
 * @return bool
 */
function iwitness_show_not_valid_email_error_message($field_name, $display_field_name)
{
    if (!is_email($field_name)) {
        iwitness_add_notice('Email address is not valid for ' . $display_field_name, 'error');
    }

    return !is_email($field_name);
}

/**
 * @return string
 */
function iwitness_get_the_user_ip()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        //check ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        //to check ip is pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return apply_filters('wpb_get_ip', $ip);
}

/**
 * @return string
 */
function iwitness_get_the_user_agent()
{
    $user_agent = '';
    if (!empty($_SERVER['USER_AGENT'])) {
        //check ip from share internet
        $user_agent = $_SERVER['USER_AGENT'];
    }

    return $user_agent;
}

/**
 * @param  $date
 * @return int
 */
function iwitness_get_unix_time_stamp($date)
{
    if (!empty($date)) {
        $date = trim($date);
        $new_date = DateTime::createFromFormat("m/d/Y", $date);
        $unix_time = $new_date->getTimestamp();
        return $unix_time;
    }
    return 0;
}

/**
 * check if users access un-authorize page
 */
function iwitness_redirect_to_login_if_not_logged_in()
{
    if ($_SERVER['PHP_SELF'] == '/wp-admin/admin-ajax.php') {
        return;
    }

    if (!iwitness_is_page()) {
        return;
    }

    $pages = iwitness_get_unauthorize_pages();
    if (is_page($pages)) {
        return;
    }

    if (!is_user_logged_in()) {
        auth_redirect();
        exit;
    }
}


/**
 *  check if users access un-authorize page
 */
function iwitness_restrict_pages_if_subscription_expired()
{
    if ($_SERVER['PHP_SELF'] == '/wp-admin/admin-ajax.php') {
        return;
    }

    if (!iwitness_is_page()) {
        return;
    }

    //wordpress super admin
    $user = wp_get_current_user();
    if ($user && $user instanceof WP_User && is_super_admin($user->ID)) {
        return;
    }

    //check allow pages
    $pages = iwitness_get_list_of_allow_expired_subscription_pages();
    if (is_page($pages)) {
        return;
    }

    //check  expired
    $user = iwitness_get_current_api_user(false);
    if (!$user || $user->isAdmin() || $user->isFree() || !$user->hasExpired()) {
        return;
    }

    wp_redirect(iwitness_get_page_path(IWITNESS_PAGE_RENEWAL_GUIDANCE_ID));
    exit;
}

/**
 * There is some reason the api server is not available like account was delete, cannot refresh token
 */
function iwitness_redirect_to_error_if_api_not_available()
{
    if ($_SERVER['PHP_SELF'] == '/wp-admin/admin-ajax.php') {
        return;
    }

    //prevent loop redirect
    if (is_page(array(IWITNESS_PAGE_ERROR))) {
        $session = iWitness()->session();
        $exception = isset($session['iwitness_error']) ? $session['iwitness_error'] : null;
        if (!$exception) {
            wp_redirect(iwitness_get_page_path(''));
            exit;
        }
        return;
    } elseif (iwitness_is_page()) {
        $session = iWitness()->session();
        $session['iwitness_error'] = null;
    }

    if (!is_user_logged_in()) {
        return;
    }

    //try to contact server
    $wp_user = wp_get_current_user();
    if (($wp_user instanceof WP_User) && !is_super_admin($wp_user->ID)) {
        /** @var \Exception $exception */
        $exception = null;
        $api_user = iwitness_try_to_get_current_api_user(2, $exception);

        //redirect to error page
        if (!$api_user) {
            wp_clear_auth_cookie();
            //store data into session
            $session = iWitness()->session();
            $session['iwitness_error'] = $exception;
            $session->write_data();
            wp_redirect(iwitness_get_page_path(IWITNESS_PAGE_ERROR));
            exit;
        }
    }
}

/**
 * @param $try
 * @param $exception
 * @return iWitness_User|false
 */
function iwitness_try_to_get_current_api_user($try, &$exception)
{
    for ($i = 1; $i <= $try; $i++) {
        try {
            $user = iwitness_get_current_api_user(false);
            if ($user) {
                $exception = null;
                return $user;
            }
            sleep(2);
        } catch (\Exception $ex) {
            iwitness_log_error($ex);
            $exception = $ex;
        }
    }
    return false;
}


/**
 * @return bool
 */
function iwitness_is_page()
{
    global $wp_query;
    /** @var WP_Post $page_obj */
    $page_obj = $wp_query->get_queried_object();
    return ($page_obj && strtolower($page_obj->post_type) == 'page');
}


/**
 * @param Exception $ex
 */
function iwitness_handle_submit_exception(\Exception $ex)
{
    //log exception first
    iwitness_log_error($ex);

    //server return expired user, redirect to renew page
    if ($ex instanceof iWitness_Api_Exception && $ex->is_expired_exception()) {
        wp_redirect(iwitness_get_page_path(IWITNESS_PAGE_RENEWAL_GUIDANCE_ID));
        exit;
    }

    //add error to error region
    iwitness_add_api_exception_to_notice($ex);

}



