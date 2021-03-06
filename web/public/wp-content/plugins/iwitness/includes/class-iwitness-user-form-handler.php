<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if (!class_exists('iWitness_Form_User_Handler')) :

    /**
     * Class for handle all the actions related to User when they submit a form
     */
    class iWitness_Form_User_Handler
    {
        /**
         * Constructor
         */
        public function __construct()
        {
            add_action('init', array($this, 'iwitness_do_update_user_profile'));
            add_action('init', array($this, 'iwitness_do_update_user_profile_and_add_contact'));
            add_action('init', array($this, 'do_change_number'));
            add_action('init', array($this, 'do_change_password'));
            add_action('init', array($this, 'do_reset_password'));
            add_action('init', array($this, 'do_forgot_password'));
            add_action('init', array($this, 'do_tell_a_friend'));
            add_action('init', array($this, 'do_sign_up'));
            add_action('init', array($this, 'do_help'));
        }

        /**
         * Sign up user then go directly to user profile page
         */
        public function  do_sign_up()
        {
            if (!iwitness_validate_submit('do_sign_up', false)) {
                return;
            }

            $subscription_uuid = iwitness_get_post_field_value('subscription_uuid');
            $phone = iwitness_get_post_field_value('phone11');
            $formatted_phone = iwitness_get_post_field_phone_number('phone11');
            $email = iwitness_get_post_field_value('email', false);
            $password = iwitness_get_post_field_value('password');
            $repeat_password = iwitness_get_post_field_value('repeat_password');

            //validate user input
            if (empty($subscription_uuid)) {
                iwitness_add_notice('Couldn\'t found  subscription for user, Please purchase account first ', 'error');
            }

            if (empty($phone)) {
                iwitness_add_notice('Please enter phone number', 'error');
            }

            if (empty($email)) {
                iwitness_add_notice('Please enter email', 'error');
            } else {
                if (!is_email($email)) {
                    iwitness_add_notice('Email address is not  valid', 'error');
                }
            }

            if (empty($password)) {
                iwitness_add_notice('Please enter password', 'error');
            }

            if (empty($repeat_password)) {
                iwitness_add_notice('Please enter repeat password', 'error');
            }

            if ($password != $repeat_password) {
                iwitness_add_notice('Password does not match', 'error');
            }

            $data = array(
                'phone' => $formatted_phone,
                'email' => $email,
                'password' => $password,
                'subscriptionUuid' => $subscription_uuid,


                //for googleadservices.com using only
                'retry' => true,
                'plan' => '',
                'amt' => '',
                'promo_code' => ''
            );


            //update billing info if any
            $session = iWitness()->session();
            if (isset($session['iwitness-buyer-info'])) {
                $buyer_info = $session['iwitness-buyer-info']->toArray();

                if (isset($buyer_info['subscriptionUuid'])
                    && $buyer_info['subscriptionUuid'] == $subscription_uuid
                ) {
                    $keys = array('firstName', 'lastName', 'address1', 'address2', 'city', 'state', 'zip');
                    foreach ($keys as $key) {
                        if (isset($buyer_info[$key]) && !empty($buyer_info[$key])) {
                            $data[$key] = $buyer_info[$key];
                        }
                    }
                }
            }

            if (iwitness_notice_count('error') == 0) {
                try {
                    iwitness_api_post('/user', array('body' => $data));

                    $result = wp_signon(
                        array(
                            'user_login' => $data['phone'],
                            'user_password' => $data['password']
                        ),
                        false
                    );

                    $session = iWitness()->session();
                    $session['subscriptionUuid'] = null;

                    if ($result instanceof WP_Error) {
                        iwitness_log_error('Could not login to the system ' . print_r($result, true));
                        iwitness_add_notice(implode('.', $result->get_error_messages()), 'error');
                        wp_redirect(iwitness_get_page_path(IWITNESS_PAGE_USER_LOGIN_ID));
                        exit;
                    } else {
                        wp_redirect(iwitness_get_page_path(IWITNESS_PAGE_USER_PROFILE_EDIT_ID));
                        exit;
                    }
                } catch (Exception $ex) {
                    iwitness_handle_submit_exception($ex);
                }
            }
            //map back to user object
            $_POST['iwitness_do_sign_up_data'] = $data;

        }

        /**
         * Update User Profile action
         */
        public function  iwitness_do_update_user_profile()
        {
            if (!iwitness_validate_submit('iwitness_do_update_user_profile')) {
                return;
            }

            $data = $this->do_save_user_profile(function () {
                wp_redirect(iwitness_get_page_path(IWITNESS_PAGE_USER_PROFILE_EDIT_ID));
            });

            //map back to user object
            $_POST['iwitness_do_update_user_profile_data'] = $data;
            exit;
        }

        /**
         * Do update user profile then redirect to add contact page         *
         */
        public function iwitness_do_update_user_profile_and_add_contact()
        {
            if (!iwitness_validate_submit('iwitness_do_update_user_profile_and_add_contact')) {
                return;
            }

            $this->do_save_user_profile(function () {
                wp_redirect(iwitness_get_page_path(IWITNESS_PAGE_CONTACT_EDIT_ID));
                exit;
            });
        }

        /**
         * Change user phone number action
         */
        public function do_change_number()
        {
            if (!iwitness_validate_submit('do_change_number')) {
                return;
            }

            $phone = iwitness_get_post_field_value('phone');
            $password = iwitness_get_post_field_value('password');

            if (empty($phone)) {
                iwitness_add_notice('Please enter phone number', 'error');
            }

            if (empty($password)) {
                iwitness_add_notice('Please enter password', 'error');
            }

            if (iwitness_notice_count('error') == 0) {
                try {
                    $token = iwitness_get_current_user_access_token();
                    $data = array('phone' => $phone, 'phonePassword' => $password);
                    $response = iwitness_api_patch('/user/' . $token->user_id, array('body' => $data));

                    //reload info from server
                    iwitness_add_notice('Wireless number changed successfully.', 'success');
                    wp_redirect(iwitness_get_page_path(IWITNESS_PAGE_USER_PROFILE_EDIT_ID));
                    exit;

                } catch (Exception $ex) {
                    iwitness_handle_submit_exception($ex);
                }
            }
        }


        /**
         * Change user password action
         */
        public function do_change_password()
        {
            if (!iwitness_validate_submit('do_change_password')) {
                return;
            }
            $old_password = iwitness_get_post_field_value('old_password');
            $new_password = iwitness_get_post_field_value('new_password');
            $confirm_password = iwitness_get_post_field_value('confirm_password');

            if (empty($old_password)) {
                iwitness_add_notice('Please enter old password', 'error');
            }

            if (empty($new_password)) {
                iwitness_add_notice('Please enter new password', 'error');
            }

            if (empty($confirm_password)) {
                iwitness_add_notice('Please enter confirm password', 'error');
            }

            if ($new_password != $confirm_password) {
                iwitness_add_notice('New password and confirm password doesn\'t match', 'error');
            }

            if (iwitness_notice_count('error') == 0) {
                try {
                    $token = iwitness_get_current_user_access_token();
                    $data = array('newPassword' => $new_password, 'password' => $old_password);
                    $response = iwitness_api_patch('/user/' . $token->user_id, array('body' => $data));
                    iwitness_add_notice('Password changed successfully.', 'success');
                    wp_redirect(iwitness_get_page_path(IWITNESS_PAGE_USER_PROFILE_EDIT_ID));
                    exit;
                } catch (Exception $ex) {
                    iwitness_handle_submit_exception($ex);
                }
            }
        }

        /**
         * Forgot password action
         *
         * @return bool
         */
        public function do_forgot_password()
        {
            if ('POST' !== strtoupper($_SERVER['REQUEST_METHOD'])) {
                return false;
            }

            if (empty($_POST['action']) || ('do_forgot_password' !== $_POST['action'])) {
                return false;
            }

            $email = iwitness_get_post_field_value('email');
            if (empty($email)) {
                iwitness_add_notice('Please enter email', 'error');
            }

            if (iwitness_notice_count('error') == 0) {
                try {
                    $response = iwitness_api_get('/user/forgot-password/' . $email, array());
                    $_POST['forgot-password'] = true;
                } catch (Exception $ex) {
                    iwitness_handle_submit_exception($ex);
                }
            }
        }

        /**
         * Reset password
         */
        public function do_reset_password()
        {
            if (!iwitness_validate_submit('iwitness_do_reset_password', false)) {
                return;
            }
            $token = iwitness_get_post_field_value('token', false, '');
            $password = iwitness_get_post_field_value('new_password');

            if (empty($token)) {
                iwitness_add_notice('Invalid token', 'error');
            }

            if (empty($password)) {
                iwitness_add_notice('Please enter password', 'error');
            }

            $data = array(
                'token' => $token,
                'password' => $password,
            );

            if (iwitness_notice_count('error') == 0) {
                try {
                    $response = iwitness_api_post('/user/reset-password', array('body' => $data));
                    iwitness_add_notice('Password has been changed.', 'success');
                    wp_redirect(iwitness_get_page_path(IWITNESS_PAGE_USER_LOGIN_ID));
                    exit;
                } catch (Exception $ex) {
                    iwitness_handle_submit_exception($ex);
                }
            }
            $data['isValidToken'] = true;
            $_POST['iwitness-reset-password_data'] = $data;
        }

        /**
         *
         * Tell a friend action
         *
         */
        public function do_tell_a_friend()
        {
            iwitness_do_form_action(
                'do-tell-a-friend',
                function () {
                    $validated = $this->validate_tell_a_friend();
                    return $validated['succeed'] ? $validated['data'] : null;
                },
                function ($data) {
                    $response = iwitness_api_post('/invitation', array('body' => $data));
                    iwitness_add_notice('Sent to a friend successfully', 'success');
                    wp_redirect(IWITNESS_PAGE_TELL_A_FRIEND_ID);
                    exit;
                }
            );
        }

        /**
         *
         * Do help sent email action
         *
         */
        public function do_help()
        {
            iwitness_do_form_action(
                'do-help',
                function () {
                    $first_name = iwitness_get_post_field_value('first_name');
                    if (empty($first_name)) {
                        iwitness_add_notice('Please enter first name', 'error');
                    }

                    $last_name = iwitness_get_post_field_value('last_name');
                    if (empty($last_name)) {
                        iwitness_add_notice('Please enter last name', 'error');
                    }

                    $email = sanitize_email(iwitness_get_post_field_value('email', false));
                    if (empty($email)) {
                        iwitness_add_notice('Please enter email', 'error');
                    }

                    $message = iwitness_get_post_field_value('message');
                    if (empty($message)) {
                        iwitness_add_notice('Please enter message', 'error');
                    }

                    $phone = iwitness_get_post_field_value('phone');

                    return array(
                        'firstName' => $first_name,
                        'lastName' => $last_name,
                        'email' => $email,
                        'phone' => $phone,
                        'message' => $message
                    );
                },
                function ($data) {
                    $response = iwitness_api_post('/subscription/help', array('body' => $data));

                    $feedback_message = 'Thanks for taking the time to contact us. Your question has been forwarded to an';
                    $feedback_message = $feedback_message . '<br>iWitness customer service representative.';
                    iwitness_add_notice($feedback_message, 'success');
                    wp_redirect(IWITNESS_PAGE_FEEDBACK_ID);
                    exit;
                }
            );
        }

        /**
         * Do validate and save user profile
         *
         * @param callable $redirect_to
         * @return array
         */
        private function do_save_user_profile(callable $redirect_to)
        {
            //map to user property array
            $data = array();

            //new user view model from here
            $first_name = iwitness_get_post_field_value('first_name');
            $last_name = iwitness_get_post_field_value('last_name');
            $email = sanitize_email(iwitness_get_post_field_value('email', false));
            $address1 = iwitness_get_post_field_value('address_1');
            $address2 = iwitness_get_post_field_value('address_2');

            $city = iwitness_get_post_field_value('city');
            $height_feet = iwitness_get_post_field_value('height_feet');
            $height_inches = iwitness_get_post_field_value('height_inches');
            $eye_color = iwitness_get_post_field_value('eye_color');
            $gender = iwitness_get_post_field_value('gender');
            if ($gender === '') {
                $gender = null;
            }

            $st = iwitness_get_post_field_value('st');
            $weight = iwitness_get_post_field_value('weight');
            $hair_color = iwitness_get_post_field_value('hair_color');
            $timezone = iwitness_get_post_field_value('timezone');

            $zip = iwitness_get_post_field_value('zip');

            $birth_date = iwitness_get_post_field_value('birth_date');

            $ethnicity = iwitness_get_post_field_value('ethnicity');

            $dist_feature = iwitness_get_post_field_value('dist_feature');

            //validate user input
            if (empty($first_name)) {
                iwitness_add_notice('Please enter first name', 'error');
            }

            if (empty($last_name)) {
                iwitness_add_notice('Please enter last name', 'error');
            }

            if (empty($email)) {
                iwitness_add_notice('Please enter email', 'error');
            } else {
                if (!is_email($email)) {
                    iwitness_add_notice('Email address is not  valid', 'error');
                }
            }

            if (empty($address1)) {
                iwitness_add_notice('Please enter address1', 'error');
			}


            if (!empty($birth_date)) {
                $birth_date = trim($birth_date);
				$unix_time = strtotime($birth_date);
                if ($unix_time) {
                    $data['birthDate'] = $unix_time;
                }
			    $cur_time = strtotime(date("m/d/Y"));
			    if ($unix_time > $cur_time) {
				    iwitness_add_notice('Please enter valid date of birth', 'error');
                    call_user_func($redirect_to);
			    }
            }

            $data['firstName'] = $first_name;
            $data['lastName'] = $last_name;
            $data['email'] = $email;
            $data['address1'] = $address1;
            $data['address2'] = $address2;
            $data['city'] = $city;
            $data['state'] = $st;
            $data['zip'] = $zip;
            $data['gender'] = $gender;
            //$data['birthDate'] = $birth_date;
            $data['heightFeet'] = $height_feet;
            $data['heightInches'] = $height_inches;
            $data['weight'] = $weight;
            $data['eyeColor'] = $eye_color;
            $data['hairColor'] = $hair_color;
            $data['ethnicity'] = $ethnicity;
            $data['distFeature'] = $dist_feature;
            $data['timezone'] = $timezone;

            if (iwitness_notice_count('error') == 0) {
                try {
                    $token = iwitness_get_current_user_access_token();
                    $response = iwitness_api_patch('/user/' . $token->user_id, array('body' => $data));
                    $api_user = new iWitness_User($response);
                    iwitness_update_current_user_info_to_api($api_user);
                    //reload info from server
                    iwitness_add_notice('Profile changed successfully.', 'success');

                    if (is_callable($redirect_to)) {
                        call_user_func($redirect_to);
                    }
                } catch (Exception $ex) {
                    iwitness_handle_submit_exception($ex);
                }
            }

            return $data;
        }

        /**
         * Validate the post data for tell a friend action
         *
         * @return array
         */
        private function validate_tell_a_friend()
        {
            // get value from the form
            $first_name = iwitness_get_post_field_value('first_name');
            $last_name = iwitness_get_post_field_value('last_name');
            $email = iwitness_get_post_field_value('email');
            $subject = iwitness_get_post_field_value('subject');
            $message = ($_POST['message']) ? ($_POST['message']) : '';
            $message = stripslashes_deep($message);
            $friends = $_POST['friends'];

            // validate them
            iwitness_show_empty_error_message($first_name, 'first name');
            iwitness_show_empty_error_message($last_name, 'last name');
            if (!iwitness_show_empty_error_message($email, 'email')) {
                iwitness_show_not_valid_email_error_message($email, 'email');
            }
            iwitness_show_empty_error_message($subject, 'subject');
            iwitness_show_empty_error_message($message, 'message');

            if (empty($friends) || (count($friends) < 1)) {
                iwitness_add_notice('Please enter at least one email', 'error');
            } else {
                foreach ($friends as $friend) {
                    if(!isset($friend['email']) || (empty($friend['email']))) continue;
                    iwitness_show_not_valid_email_error_message($friend['email'], 'friend email');
                }
            }

            // build the result for return
            return array(
                'succeed' => iwitness_notice_count('error') == 0,
                'data' => iwitness_notice_count('error') != 0
                        ? array()
                        : array(
                            'firstName' => $first_name,
                            'lastName' => $last_name,
                            'email' => $email,
                            'subject' => $subject,
                            'message' => $message,
                            'friends' => $friends,
                        )
            );
        }

    }

endif;

new iWitness_Form_User_Handler();
