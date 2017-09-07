<?php
/**
 * Load assets.
 *
 * @author      iWitness
 * @category    Asset
 * @package     iWitness/Asset
 * @version     1.0
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly
if (!class_exists('iWitness_Assets')) :

    /**
     * iWitness_Assets Class
     */
    class iWitness_Assets
    {
        /**
         * Constructor
         */
        public function __construct()
        {
            add_action('wp_enqueue_scripts', array($this, 'add_script_libraries'));
        }

        /**
         *   Add the core scripts
         *
         */
        public function add_script_libraries()
        {
            $plugin_path = iWitness()->plugin_url() . '/assets';

            // register vendor scripts
            wp_register_script('iwitness-main-plugin', $plugin_path . '/js/main.js');

            // utilities scripts
            wp_register_script('google-map-plugin', '//maps.googleapis.com/maps/api/js?sensor=true', false);

            // register iwitness scripts
            wp_register_script('iwitness-billing-info', $plugin_path . '/js/iwitness/billing-info.js');
            wp_register_script('iwitness-purchase-plugin', $plugin_path . '/js/iwitness/purchase.js');
            wp_register_script('iwitness-buy-gift-cards', $plugin_path . '/js/iwitness/gift-card.js');
            wp_register_script('iwitness-sign-up-plugin', $plugin_path . '/js/iwitness/sign-up.js');
            wp_register_script('iwitness-profile-edit-plugin', $plugin_path . '/js/iwitness/profile-edit.js');
            wp_register_script('iwitness-event-video-player-plugin', $plugin_path . '/js/iwitness/event-view-video-player.js');
            wp_register_script('iwitness-event-google-map-plugin', $plugin_path . '/js/iwitness/event-view-map.js');
            wp_register_script('iwitness-user-manage-plugin', $plugin_path . '/js/iwitness/user-manage.js');
            wp_register_script('iwitness-coupon-manage-plugin', $plugin_path . '/js/iwitness/promotional-code-list.js');
            wp_register_script('iwitness-promotional-code-plugin', $plugin_path . '/js/iwitness/promotional-code.js');
            wp_register_script('iwitness-notification-plugin', $plugin_path . '/js/iwitness/notifications.js');
            wp_register_script('iwitness-contact-plugin', $plugin_path . '/js/iwitness/contact.js');

            // report script
            wp_register_script('iwitness-user-report-plugin', $plugin_path . '/js/iwitness/user-report.js');
            wp_register_script('iwitness-user-event-report-plugin', $plugin_path . '/js/iwitness/user-event-report.js');
            wp_register_script('iwitness-revenue-report-plugin', $plugin_path . '/js/iwitness/revenue-report.js');
            wp_register_script('iwitness-subscription-report-plugin', $plugin_path . '/js/iwitness/subscription-report.js');

            // enqueue core plugins
            wp_enqueue_script('iwitness-main-plugin');
        }
    }

endif;

new iWitness_Assets();