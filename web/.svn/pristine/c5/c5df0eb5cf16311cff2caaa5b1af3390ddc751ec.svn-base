<?php
/**
 * iWitness_Control_Shortcodes class.
 *
 * @class       iWitness_Control_Shortcodes
 * @version     1.0.0
 * @package     iWitness/Classes
 * @category    Class
 * @author      iWitness
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly
if (!class_exists('iWitness_Control_Shortcodes')) :

    /**
     * The iWitness_Control_Shortcodes expose some of shortcode as below
     *  [iwitness_crime_stats_carousel]
     *
     */
    class iWitness_Control_Shortcodes
    {
        public function __construct()
        {
            add_shortcode('iwitness_crime_stats_carousel', array($this, 'crime_stats_carousel'));
        }

        public function crime_stats_carousel()
        {
            return iwitness_render_view(
                'control/crime_stats_carousel'
            );
        }
    }

endif;

new iWitness_Control_Shortcodes();