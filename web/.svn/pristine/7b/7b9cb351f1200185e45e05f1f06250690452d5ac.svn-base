<?php
/**
 * iWitness_Report_Shortcodes class.
 *
 * @class       iWitness_Report_Shortcodes
 * @version     2.1.0
 * @package     iWitness/Classes
 * @category    Class
 * @author      iWitness
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly
if (!class_exists('iWitness_Report_Shortcodes')) :

    /**
     * The iWitness_Report_Shortcodes expose some of shortcode as below
     *  [iwitness_user_report]
     *
     */
    class iWitness_Report_Shortcodes
    {
        public function __construct()
        {
            add_shortcode('iwitness_user_report', array($this, 'user_report'));
            add_shortcode('iwitness_user_event_report', array($this, 'user_event_report'));
            add_shortcode('iwitness_revenue_report', array($this, 'revenue_report'));
            add_shortcode('iwitness_subscription_report', array($this, 'subscription_report'));

        }

        /**
         * Get user report view
         *
         * @return array|iWitness_Error|null|WP_Error
         */
        public function user_report()
        {
            return iwitness_render_view(
                'report/user-report',
                function() {
                    return iwitness_is_api_admin_user();
                },
                function() {
                    return array();
                }
            );
        }

        /**
         * Get user event report view
         *
         * @return array|iWitness_Error|null|WP_Error
         */
        public function user_event_report()
        {
            return iwitness_render_view(
                'report/user-event-report',
                function() {
                    return iwitness_is_api_admin_user();
                },
                function() {
                    return array();
                }
            );
        }

        /**
         * Get revenue report view
         *
         * @return array|iWitness_Error|null|WP_Error
         */
        public function revenue_report()
        {
            return iwitness_render_view(
                'report/revenue-report',
                function() {
                    return iwitness_is_api_admin_user();
                },
                function() {
                    return array();
                }
            );
        }

        /**
         * Get subscription report view
         *
         * @return array|iWitness_Error|null|WP_Error
         */
        public function subscription_report()
        {
            return iwitness_render_view(
                'report/subscription-report',
                function() {
                    return iwitness_is_api_admin_user();
                },
                function() {
                    return array();
                }
            );
        }
    }

endif;

new iWitness_Report_Shortcodes();