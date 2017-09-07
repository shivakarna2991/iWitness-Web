<?php


/**
 * @return bool
 */
function iwitness_is_api_user()
{
    return (iwitness_get_current_api_user_from_meta() != null);
}

/**
 * @return bool
 */
function iwitness_is_api_admin_user()
{
    global $user; // if we call wp_get_current_user(), it always get empty object

    if (!$user || !$user->ID) { // some cases the user is empty
        $user = wp_get_current_user();
    }

    if ($user) {
        $user_meta_data = iwitness_get_api_user_from_meta($user->ID);
        if ($user_meta_data) {
            return $user_meta_data->isAdmin();
        }
    }

    return false;
}


/**
 * @return iWitness_User|null
 */
function iwitness_get_current_api_user_from_meta()
{
    $login_user = wp_get_current_user();

    if ($login_user) {
        return iwitness_get_api_user_from_meta($login_user->ID);
    }
    return null;
}

/**
 *
 * @param WP_User | user id
 * @return iWitness_User|null
 */
function iwitness_get_api_user_from_meta($user)
{
    /** @var iWitness $iWitness */
    $iWitness = iWitness();

    $id = ($user instanceof WP_User) ? $user->ID : $user;
    $key = IWITNESS_CURRENT_USER . '_' . $id;

    //get from cache
    if (isset($GLOBALS[$key])) {
        return $GLOBALS[$key];
    }

    //get from database
    $api_json = get_user_meta($id, $iWitness->user_meta_api_identity(), true);
    if ($api_json) {
        $api_user = iWitness_User::deserialize($api_json);
        $GLOBALS[$key] = $api_user;
        return $api_user;
    }
    return null;
}


/**
 * @param string|iWitness_Access_Token $login
 * @return iWitness_Error|iWitness_User
 */
function iwitness_update_user_info_from_api(iWitness_Access_Token &$token, $login)
{
    /** @var iWitness $iWitness */
    $iWitness = iWitness();
    $api_user = iwitness_get_api_user($token, $login);

    if ($api_user->suspended) {
        throw new \Exception('Your account was suspended');
    }


    $token->user_id = $api_user->id; //kind of hacking here, change outside this function may be easier to understand
    //get database user
    $login_user = get_user_by('login', $api_user->id);

    //not existing user
    if (false === $login_user) {
        iwitness_log_debug('No user with login name "' . $api_user->id . '" in WP database, create new one');

        //validate duplicate email in WP
        $wp_user = get_user_by('email', $api_user->email);
        if ($wp_user instanceof WP_User) {
            throw new Exception('Sorry, that email address is already used!');
        }

        $user_data = array(
            'user_pass' => wp_generate_password(),
            'user_login' => $api_user->id, //phone is name for login
            'user_email' => $api_user->email,
            'first_name' => $api_user->firstName,
            'last_name' => $api_user->lastName,
            'user_nicename' => $api_user->firstName . $api_user->lastName,
            'display_name' => $api_user->firstName . ' ' . $api_user->lastName,
            'user_registered' => gmdate("Y-m-d H:i:s", $api_user->created)
        );

        // Create a new user
        $user_id = wp_insert_user($user_data);

        if ($user_id && is_integer($user_id)) {
            update_user_meta($user_id, $iWitness->user_meta_api_identity(), $api_user->serialize());

            //update token accordingly
            if ($token) {
                update_user_meta($user_id, $iWitness->user_meta_api_token(), $token->serialize());
            }
        } else {
            //it seams that no email duplication in wordpress
            //See http://wordpress.stackexchange.com/questions/144185/allow-duplicate-email-address-for-different-users
            throw new Exception(implode('.', $user_id->get_error_messages()));
        }
    } else if ($login_user instanceof WP_User) {
        iwitness_log_error('Update WP user account ');
        //update user
        $user_data = array(
            'ID' => $login_user->ID,
            'user_email' => $api_user->email,
            'first_name' => $api_user->firstName,
            'last_name' => $api_user->lastName,
            'user_nicename' => $api_user->firstName . $api_user->lastName,
            'display_name' => $api_user->firstName . $api_user->lastName,
            'user_registered' => gmdate("Y-m-d H:i:s", $api_user->created)
        );

        wp_update_user($user_data);

        //Clean Cache
        wp_cache_delete($login_user->ID, 'users');

        //cache new meta
        update_user_meta($login_user->ID, $iWitness->user_meta_api_identity(), $api_user->serialize());

        //update token accordingly
        if ($token) {
            update_user_meta($login_user->ID, $iWitness->user_meta_api_token(), $token->serialize());
        }
    }

    return $token;
}


/**
 * update API user info from WP info
 */
function iwitness_update_current_user_info_to_api(iWitness_User $api_user = null)
{
    /** @var iWitness $iWitness */
    $iWitness = iWitness();
    $login_user = wp_get_current_user();

    if (!$api_user) {
        $token = iwitness_get_token_from_meta($login_user);
        $api_user = iwitness_get_api_user($token);
    }

    $key = IWITNESS_CURRENT_USER . '_' . $login_user->ID;

    unset($GLOBALS[$key]);
    wp_cache_delete($login_user->ID, 'users');
    update_user_meta($login_user->ID, $iWitness->user_meta_api_identity(), $api_user->serialize());
}

/**
 * Get current user form his token
 * @param bool $fresh
 * @throws Exception
 * @return array|iWitness_Error|iWitness_User|null|WP_Error
 */
function iwitness_get_current_api_user($fresh = true, $default = null)
{
    //get from cache
    static $cached_user = null;

    if (!$fresh && $cached_user) {
        return $cached_user;
    }

    $token = iwitness_get_current_user_access_token();

    if ($token) {
        $cached_user = iwitness_get_api_user($token);
        return $cached_user;
    }
    return $default;

}

/**
 * @param $token
 * @return array
 */
function iwitness_validate_reset_password_token($token)
{
    $isValidToken = false;
    $message = '';
    try {
        if (empty($token)) {
            $message = 'Token could not be null';
        } else {
            iwitness_api_get('/user/validate/token/' . $token);
            $isValidToken = true;
        }
    } catch (\Exception $ex) {
        $message = $ex->getMessage();
    }
    return array($isValidToken, $message);
}

