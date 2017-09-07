<?php

require_once(iWitness()->plugin_path() . '/includes/api/iwitness-api-client-functions.php');


/**
 * Authenticate user
 * @param $user
 * @param $username
 * @param $password
 * @return bool|WP_Error|WP_User
 */
function iwitness_authenticate_username_password($user, $username, $password)
{
    // If a previous hook has successfully logged the user in, do not process further
    if (is_a($user, 'WP_User')) return $user;

    //all others users must login via Oauth 2 provider server
    // Ensure details have been entered
    if (empty($username) || empty($password)) {
        $error = new WP_Error();
        if (empty($username))
            $error->add('empty_username', __('<strong>ERROR</strong>: The username field is empty.'));
        if (empty($password))
            $error->add('empty_password', __('<strong>ERROR</strong>: The password field is empty.'));
        return $error;
    }

    iwitness_log_debug('Begin to login to the system ');

    /** @var iWitness $iWitness */
    $iWitness = iWitness();

    //let admin login by himself
    $login_user = get_user_by('login', $username);

    if ($login_user) {
        iwitness_log_debug('User is existing in database');
        $api_json = get_user_meta($login_user->ID, $iWitness->user_meta_api_identity(), true);
        if (false === $api_json) {
            iwitness_log_debug('Not associate with API server. Login by normal WP account');
            return;
        }
    }
    iwitness_log_debug('This is new user. Login by API account ' . $username);

    // Attempt to authenticate user
    try {
        iwitness_log_debug('Begin to authenticate API user by user name, password ');
        $token = iwitness_authenticate_user($username, $password);

        iwitness_log_debug('Begin to update new user info into WP DB');
        $token = iwitness_update_user_info_from_api($token, $username);

        iwitness_log_debug('Recheck user in an WP DB');

        // Return valid user object
        $user = get_user_by('login', $token->user_id);
        if ($user === false) {
            iwitness_log_debug('User does not exist');
        }
        return $user;

    } catch (\Exception $ex) {
        iwitness_log_error('Exception  = ' . $ex->getMessage());
        return new WP_Error(
            'api-error',
            'api-error', $ex
        );
    }
}


/**
 *
 */
function iwitness_logout()
{
    //Process logout here
    if (session_id()) {
        session_destroy();
    }
}

//add_action('wp_logout', 'iwitness_logout');


/**
 * WP register user
 * @param $id
 */
function iwitness_register($id)
{
    //$user_data = get_user_by('id', $id);
    //$username = $user_data['user_login'];
    //$password = $_POST['password'];
    //Ensure your system applies appropriate sanitization to the password
    //create_new_user($username, $password);
}

//add_action('user_register', 'iwitness_register', 20, 1);


function iwitness_reset($user, $new_pass)
{
    reset_user_password($user['user_login'], $new_pass);
}

//add_action('password_reset', 'iwitness_reset', 20, 2);


/**
 * Use avatars in priority order
 * @author Aaron Oneal
 * @link http://aarononeal.info
 *
 */
function iwitness_filter_avatar($avatar, $id_or_email, $size, $default, $alt)
{
    $custom_avatar = '';
    $user_id = (!is_integer($id_or_email) && !is_string($id_or_email) && get_class($id_or_email)) ? $id_or_email->user_id : $id_or_email;

    if (!empty($user_id)) {

        $api_user = iwitness_get_api_user_from_meta($user_id);
        if ($api_user) {
            $custom_avatar = $api_user->photoUrl;
        }
    }

    if (!empty($custom_avatar)) {
        // return the custom avatar from the social network
        $return = '<img class="avatar" src="' . $custom_avatar . '" style="width:' . $size . 'px" alt="' . $alt . '" />';
    } else if ($avatar) {
        $return = $avatar;
    } else {
        // default
        $return = '<img class="avatar" src="' . $default . '" style="width:' . $size . 'px" alt="' . $alt . '" />';
    }

    return $return;
}

add_filter('get_avatar', 'iwitness_filter_avatar', 10, 5);


/**
 * @param WP_Error $error
 */
function iwitness_login_error(WP_Error $error)
{
    $exception = $error->get_error_data('api-error');
    if ($exception && $exception instanceof \Exception) {
        iwitness_add_api_exception_to_notice($exception);
    } else {
        iwitness_add_api_wp_error_to_notice($error);
    }
}
add_action('iwitness_login_error', 'iwitness_login_error'); // hook failed login


//replace wordpress build-in  function
if (!function_exists('wp_authenticate')) :
    /**
     * Checks a user's login information and logs them in if it checks out.
     *
     * @since 2.5.0
     *
     * @param string $username User's username
     * @param string $password User's password
     * @return WP_User|WP_Error WP_User object if login successful, otherwise WP_Error object.
     */
    function wp_authenticate($username, $password)
    {
        $username = sanitize_user($username);
        $password = trim($password);

        /**
         * Filter the user to authenticate.
         *
         * If a non-null value is passed, the filter will effectively short-circuit
         * authentication, returning an error instead.
         *
         * @since 2.8.0
         *
         * @param null|WP_User $user User to authenticate.
         * @param string $username User login.
         * @param string $password User password
         */
        $user = apply_filters('authenticate', null, $username, $password);

        if ($user == null) {
            // TODO what should the error message be? (Or would these even happen?)
            // Only needed if all authentication handlers fail to return anything.
            $user = new WP_Error('authentication_failed', __('<strong>ERROR</strong>: Invalid username or incorrect password.'));
        }

        $ignore_codes = array('empty_username', 'empty_password');

        if (is_wp_error($user) && !in_array($user->get_error_code(), $ignore_codes)) {
            /**
             * Fires after a user login has failed.
             *
             * @since 2.5.0
             *
             * @param string $username User login.
             */
            do_action('iwitness_login_error', $user);
            do_action('wp_login_failed', $username);
        }

        return $user;
    }
endif;