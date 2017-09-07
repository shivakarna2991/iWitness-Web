<?php
/**
 * iWitness_Contact_Shortcodes class.
 *
 * @class       iWitness_Contact_Shortcodes
 * @version     1.0.0
 * @package     iWitness/Classes
 * @category    Class
 * @author      iWitness
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly
if (!class_exists('iWitness_Contact_Shortcodes')) :

    /**
     * The iWitness_Contact_Shortcodes expose some of shortcode as below
     *  [iwitness_contact_list]
     *  [iwitness_contact_view]
     *
     */
    class iWitness_Contact_Shortcodes
    {
        public function __construct()
        {
            add_shortcode('iwitness_contact_list', array($this, 'contact_list_view'));
            add_shortcode('iwitness_contact_edit', array($this, 'contact_edit_view'));
        }

        /**
         * List multiple contacts shortcode
         *
         * @access public
         * @return string
         */
        public function contact_list_view()
        {
            return $this->get_contacts_view('list');
        }

        /**
         * Edit multiple contacts shortcode
         *
         * @access public
         * @return string
         */
        public function contact_edit_view()
        {
            return $this->get_contacts_view('edit');
        }

        /**
         * Get contacts from the api server and binding with the template name
         *
         * @param $view_name
         * @return array|iWitness_Error|null|WP_Error
         */
        private function get_contacts_view($view_name)
        {
            return iwitness_render_view(
                'contact/' . $view_name,
                function() {
                    return iwitness_is_api_user();
                },
                function() {
                    $token = iwitness_get_current_user_access_token();
                    $contacts = iwitness_api_get('/user/'.$token->user_id.'/contact');
                    return iwitness_api_response_filter($contacts, 'contact');
                }
            );
        }
    }

endif;

new iWitness_Contact_Shortcodes();