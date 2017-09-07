<?php
    global $post;
    get_header();
?>

<?php get_template_part('content-header'); ?>
<?php echo apply_filters('the_content', isset($post->post_content) ? $post->post_content: 'Page Not Found'); ?>
<?php get_template_part('content-footer'); ?>