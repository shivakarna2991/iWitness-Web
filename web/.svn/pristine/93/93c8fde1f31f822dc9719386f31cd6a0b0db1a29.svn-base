<?php
add_action('wp_enqueue_scripts', 'iwitness_bootstrap_styles');
function iwitness_bootstrap_styles()
{
    // Register the style like this for a theme:
    wp_register_style('bootstrap-styles', get_template_directory_uri() . '/css/compiled/global.css', array(), '20140610', 'all');

    //  enqueue the style:
    wp_enqueue_style('bootstrap-styles');
}