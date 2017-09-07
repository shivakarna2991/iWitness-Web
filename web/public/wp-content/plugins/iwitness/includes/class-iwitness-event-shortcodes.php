<?php
/**
 * iWitness_Event_Shortcodes class.
 *
 * @class       iWitness_Event_Shortcodes
 * @version     1.0.0
 * @package     iWitness/Classes
 * @category    Class
 * @author      iWitness
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly
if (!class_exists('iWitness_Event_Shortcodes')) :

    /**
     * This class expose some of shortcode as below
     */
    class iWitness_Event_Shortcodes
    {
        /**
         * Constructor
         */
        public function __construct()
        {
            add_shortcode('iwitness_event_list', array($this, 'event_list_view'));
            add_action('init', array($this, 'event_list_view')); // paging for event

            add_shortcode('iwitness_event_view', array($this, 'event_view'));
        }

        /**
         * List multiple events shortcode
         *
         * @access public
         * @return string
         */
        public function event_list_view()
        {
            $page = 1;
            $events = null;
            $page_info = null;

            if (get_query_var('page')) {
                $page = get_query_var('page');
            }

            return iwitness_render_view(
                'event/list',
                function () {
                    return iwitness_is_api_user();
                },
                function () use ($page) {
                    $api_user = iwitness_get_current_api_user(false);
                    if (!$api_user) {
                        throw new Exception("Couldn't load user info");
                    }

                    $events = null;
                    $page_info = null;
                    $query_builder = http_build_query(array('sort' => '-created', 'page' => $page, 'size' => 12));
                    $query = '/event?user_id=' . $api_user->id . '&' . $query_builder;
                    $response = iwitness_api_get($query);
                    if ($response) {
                        $events = iwitness_api_response_filter($response, 'event');
                        $page_info = iwitness_api_response_paging_filter($response);
                    }

                    $data = array(
                        'events' => $events,
                        'page_info' => $page_info,
                        'user' => $api_user
                    );

                    return $data;
                }
            );
        }

        /**
         * View event shortcode
         *
         * @access public
         * @throws Exception
         * @return string
         */
        public function event_view()
        {
            $id = isset($_GET['id']) ? $_GET['id'] : '';
            return iwitness_render_view(
                'event/view',
                function () use ($id) {
                    if (empty($id)) {
                        throw new Exception("You don't have sufficient permissions");
                    }
                    return iwitness_is_api_user();
                },
                function () use ($id) {
                    return array(
                        'event' => iwitness_api_get('/event/' . $id),
                        'user' => iwitness_get_current_api_user()
                    );
                }
            );
        }
    }

endif;

new iWitness_Event_Shortcodes();
