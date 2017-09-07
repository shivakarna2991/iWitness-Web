<?php
/**
 * Template Name: Dynamic Full Width Template
 *
 * @package iwitness
 * @version iWitness 1.0
 */
?>

<?php global $post;
get_header();
?>

<div id="main-container"
     data-api-url="<?php echo iWitness()->api_uri() ?>"
     data-plugin-url="<?php echo iWitness()->plugin_url() ?>" >

    <?php get_template_part('content-header'); ?>

    <div class="content-container">
        <div class="container">
            <?php echo apply_filters('the_content', $post->post_content); ?>
        </div>
    </div>
    <?php get_template_part('content-footer'); ?>

</div> <!-- end of main container -->

<?php get_footer(); ?>