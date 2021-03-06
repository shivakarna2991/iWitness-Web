<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class iWitness_Friend_Form_Handler
{
    /**
     * Constructor
     */
    public function __construct()
    {
        add_action('init', array($this, 'do_contact_confirm'));
    }

    /**
     * Send token to server to confirm or decline contact member
     */
    public function do_contact_confirm()
    {
        if (!iwitness_validate_submit('iwitness_do_contact_confirm', false)) {
            return;
        }
        $token = iwitness_get_post_field_value('token', false, '');
        $decline = iwitness_get_post_field_value('decline', false, 0);

        if (empty($token)) {
            iwitness_add_notice('Invalid token', 'error');
        }

        $decline = (bool)$decline;

        $data = array(
            'token' => $token,
            'decline' => $decline,
        );

        if (iwitness_notice_count('error') == 0) {
            try {
                $response = iwitness_api_post('/contact/confirm', array('body' => $data));
                $session = iWitness()->session();
                $session['friend-connected'] = $response;
                wp_redirect(iwitness_get_page_path(IWITNESS_PAGE_FRIEND_CONNECTED_ID));
                exit;
            } catch (Exception $ex) {
                iwitness_handle_submit_exception($ex);
            }
        }
        $data['isValidToken'] = true;
        $_POST['iwitness-friend-connect-data'] = $data;
    }
}

new  iWitness_Friend_Form_Handler();


