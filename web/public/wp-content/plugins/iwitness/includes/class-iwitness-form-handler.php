<?php
/**
 * Handler all POST actions in the client side
 *
 * @author      iWitness
 * @category    FormHandler
 * @package     iWitness/FormHandler
 * @version     1.0
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly
if (!class_exists('iWitness_Form_Handler')) :

    class iWitness_Form_Handler
    {
        /**
         * Constructor
         */
        public function __construct()
        {
            include_once('class-iwitness-user-form-handler.php');
            include_once('class-iwitness-event-form-handler.php');
            include_once('class-iwitness-contact-form-handler.php');
            include_once('class-iwitness-purchase-form-handler.php');
            include_once('class-iwitness-admin-form-handler.php');
            include_once('class-iwitness-friend-form-handler.php');
            include_once('class-iwitness-live-google-analytics-handler.php');
        }
    }
endif;

new iWitness_Form_Handler();
