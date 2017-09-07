<?php
/**
 * Handler all POST actions for Event client page
 *
 * @author      iWitness
 * @category    FormHandler
 * @package     iWitness/FormHandler
 * @version     1.0
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly
if (!class_exists('iWitness_Event_Form_Handler')) :

    class iWitness_Event_Form_Handler
    {

        /**
         * Constructor
         */
        public function __construct()
        {
            add_action('init', array($this, 'iwitness_do_update_event'));
            add_action('init', array($this, 'iwitness_do_delete_event'));
        }

        /**
         * Save and and update an event if the
         * form was submitted through the user event page.
         *
         * @return void
         */
        public function iwitness_do_update_event()
        {
            iwitness_do_form_action(
                'iwitness_do_update_event',
                function () {
                    $id = iwitness_get_post_field_value('id');
                    $title = iwitness_get_post_field_value('title');

                    if (empty($id)) {
                        iwitness_add_notice('You don\'t have sufficient permissions', 'error');
                    }

                    return array(
                        'id' => $id,
                        'title' => $title
                    );
                },
                function ($data) {
                    if(isset($data['title'])) {
                        $response = iwitness_api_patch('/event/' . $data['id'], array('body' => array('name' => $data['title'])));
                        iwitness_add_notice('Event has been updated', 'success');
                    }

                    wp_redirect(iwitness_get_page_path(IWITNESS_PAGE_EVENT_VIEW_ID) . '/?id=' . $data['id']);
                    exit;
                }
            );
        }

        /**
         * Delete an event
         *
         * @return void
         */
        public function iwitness_do_delete_event()
        {
            iwitness_do_form_action(
                'iwitness_do_delete_event',
                function () {
                    $id = iwitness_get_post_field_value('id');

                    if (empty($id)) {
                        iwitness_add_notice('You don\'t have sufficient permissions', 'error');
                    }

                    return array(
                        'id' => $id
                    );
                },
                function ($data) {
                    $response = iwitness_api_delete('/event/' . $data['id']);
                    iwitness_add_notice('Event has been deleted', 'success');

                    wp_redirect(iwitness_get_page_path(IWITNESS_PAGE_EVENT_LIST_ID));
                    exit;
                }
            );
        }

    }
endif;

new iWitness_Event_Form_Handler();