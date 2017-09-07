<?php

//for contact ajax
add_action('wp_ajax_iwitness_do_update_contact', 'iwitness_do_update_contact');
add_action('wp_ajax_nopriv_iwitness_do_update_contact', 'iwitness_do_update_contact');

/**
 * Save and and update a contact if the
 * form was submitted through the user contact page.
 *
 * @return void
 */
function iwitness_do_update_contact()
{
    if (!iwitness_validate_submit(array('iwitness_do_update_contact', 'iwitness_do_create_contact'), true)) {
        return;
    }

    // get value from the form
    $id = iwitness_get_post_field_value('key', true, null);
    $email = iwitness_get_post_field_value('email');
    $is_primary = iwitness_get_post_field_value('is_primary');
    $first_name = iwitness_get_post_field_value('first_name');
    $last_name = iwitness_get_post_field_value('last_name');
    $relationship = iwitness_get_post_field_value('relationship');
    $phone = iwitness_get_post_field_value('phone');
    $form_id = iwitness_get_post_field_value('form_id');

    $errors = array();
    // validate them
    /*if (empty($email)) {
        $errors['email'][] = 'Please enter the email';
	}*/

    if (empty($first_name)) {
        $errors['first_name'][] = 'Please enter the first_name';
    }

    if (empty($last_name)) {
        $errors['last_name'][] = 'Please enter the last_name';
    }

    if (empty($phone)) {
        $errors['phone'][] = 'Please enter the phone';
    }

    if (count($errors) > 0) {
        $result = array('status' => 422, 'message' => 'Validation failed', 'response' => $errors);
    } else {
        try {

            if(!iwitness_get_current_api_user()) {
                throw new Exception("You don't have sufficient permissions");
            }

            $data = array(
                'email' => $email,
                'isPrimary' => !empty($is_primary) ? $is_primary : '0',
                'firstName' => $first_name,
                'lastName' => $last_name,
                'relationType' => $relationship,
                'phone' => $phone,
                'userId' => iwitness_get_current_api_user()->id
            );

            if (!empty($id)) {
                $data['id'] = $id;
            }

            if (!empty($id)) {
                $response = iwitness_api_patch('/contact/' . $data['id'], array('body' => $data));
            } else {
                $response = iwitness_api_post('/contact', array('body' => $data));
            }

            $result = array(
                'status' => 200,
                'message' => 'Contact has been updated',
                'response' => $response,
                'request' => array('form_id' => $form_id)
            );
        } catch (\Exception $ex) {
            iwitness_log_error($ex);
            if ($ex instanceof iWitness_Api_Exception && $ex->getCode() == 422) {
                $result = array('status' => 422, 'message' => 'Validation failed', 'response' => $ex->get_validation_errors());
            } else {
                $result = array('status' => 500, 'message' => $ex->getMessage(), 'response' => '');
            }
        }
    }
    echo json_encode($result);
    exit;
}
