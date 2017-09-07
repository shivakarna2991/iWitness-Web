<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly
if (!class_exists('iWitness_Error_Shortcodes')) :

    /**
     * This class expose some of shortcode as below
     */
    class iWitness_Error_Shortcodes
    {
        /**
         * Constructor
         */
        public function __construct()
        {
            add_shortcode('iwitness_error', array($this, 'error_view'));
        }

        public function error_view()
        {
            $session = iWitness()->session();
            $exception = isset($session['iwitness_error']) ?
                $session['iwitness_error'] :
                new Exception('An error occurred during execution; please try again later.');

            $session['iwitness_error'] = null;

            ob_start();
            iwitness_get_template('error/error.php', array('error' => $exception));
            wp_reset_postdata();
            return ob_get_clean();
        }
    }

endif;

new iWitness_Error_Shortcodes();