<?php

add_action("wp_ajax_get_total_page_message", "iwitness_get_total_page_message_callback");
add_action("wp_ajax_get_message", "iwitness_get_message_callback");

/**
 * Get messages callback
 */
function iwitness_get_message_callback()
{
    try {
        $page = 1;
        if(isset($_GET['page'])) {
            $page = $_GET['page'];
        }

        $messages = iwitness_api_get('/message', array('page' => $page));
        $messages = iwitness_api_response_filter($messages, 'message');

        $temps = array(
            'total' => count($messages)
        );

        if(count($messages) > 0) {
            foreach ($messages as $index => $message) {
                $message['created'] = date('g:i A', $message['created']);
                $temps['data'][] = $message;
            }
        }

        header("Content-type: application/json");
        echo json_encode($temps);
    } catch (Exception $ex) {
        iwitness_log_error($ex);
    }
    die;
}

/**
 * Get message page callback
 */
function iwitness_get_total_page_message_callback()
{
    try {
        $messages = iwitness_api_get('/message');
        header("Content-type: application/json");
        echo json_encode(array(
            'pageCount' => $messages['page_count'],
            'pageSize' => $messages['page_size'],
            'totalItems' => $messages['total_items']
        ));
    } catch (Exception $ex) {
        iwitness_log_error($ex);
    }
    die;
}