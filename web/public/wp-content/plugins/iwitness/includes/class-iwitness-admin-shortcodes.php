<?php
/**
 * iWitness_Admin_Shortcodes class.
 *
 * @class       iWitness_Admin_Shortcodes
 * @version     1.0.0
 * @package     iWitness/Classes
 * @category    Class
 * @author      iWitness
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly
if (!class_exists('iWitness_Admin_Shortcodes')) :

    /**
     * The iWitness_Admin_Shortcodes expose some of shortcode as below
     *  [iwitness_api_admin_dashboard]
     *  [iwitness_admin_delete_user]
     *  [iwitness_admin_promo_code_list]
     *  [iwitness_admin_notifications]
     *
     */
    class iWitness_Admin_Shortcodes
    {
        /**
         * Constructor
         */
        public function __construct()
        {
            add_shortcode('iwitness_api_admin_dashboard', array($this, 'api_admin_dashboard'));
            add_shortcode('iwitness_admin_delete_user', array($this, 'admin_delete_user'));
            add_shortcode('iwitness_admin_promo_code_list', array($this, 'admin_promo_code_list'));
            add_shortcode('iwitness_admin_notifications', array($this, 'admin_notifications'));
        }

        /**
         * API Admin Dashboard page
         *
         * @return string
         */
        public function api_admin_dashboard()
        {
            return iwitness_render_view(
                'admin/dashboard',
                function () {
                    if (!iwitness_is_api_admin_user()) {
                        throw new \Exception('Only API Administrators can access to this page');
                    }
                    return true;
                },
                function () {
                    $view_model = array(
                        'name' => '',
                        'code' => '',
                        'maxRedemption' => '',
                        'redemptionStartDate' => '',
                        'redemptionEndDate' => '',
                        'price' => '',
                        'subscriptionLength' => '',
                        'single' => '',
                        'codeString' => '',
                        'numberOfCode' => ''
                    );

                    if (iwitness_validate_submit('do_promotion_code', false)) {
                        if (isset($_POST['iwitness_do_promotion_code_data'])) {
                            $view_model = $_POST['iwitness_do_promotion_code_data'];
                        }
                    }

                    $view_model['plans'] = iwitness_get_plans();
                    return $view_model;
                }
            );
        }

        /**
         * API Admin Delete User page
         * @return string
         */
        public function admin_delete_user()
        {
            return iwitness_render_view(
                'admin/delete-user',
                function () {
                    return iwitness_is_api_admin_user();
                }
            );
        }

        /**
         * API Admin Promotional Code List page
         *
         */
        public function admin_promo_code_list()
        {
            if (isset($_GET['code'])) {
                $code_string = $_GET['code']; // get code from query string
            }
            $query_url = '/coupon';
            if (!empty($code_string)) {
                $query_url = $query_url . '?codeString=' . urlencode($code_string);
            }

            return iwitness_render_view(
                'admin/promo-code-list',
                function () {
                    return iwitness_is_api_admin_user();
                },
                function () use ($query_url) {
                    $coupons = iwitness_api_get($query_url);
                    return iwitness_api_response_filter($coupons, 'coupon');
                }
            );
        }

        /**
         * API Admin Notification page
         *
         */
        public function admin_notifications()
        {
            return iwitness_render_view(
                'admin/notifications',
                function () {
                    return iwitness_is_api_admin_user();
                }
            );
        }
    }

endif;

new iWitness_Admin_Shortcodes();