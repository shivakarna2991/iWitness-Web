<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage iwitness
 * @since iwitness 1.0
 */

get_header(); ?>

    <div id="main-container"
         data-api-url="<?php echo iWitness()->api_uri() ?>"
         data-plugin-url="<?php echo iWitness()->plugin_url() ?>">

        <?php get_template_part('content-header'); ?>

        <div class="content-container">
            <div class="container">

                <h5><a href="<?php echo IWITNESS_PAGE_HOME . '/content-news' ?>">Back to news</a></h5>

                <?php while (have_posts()) : the_post(); ?>

                    <?php the_content(); ?>

                <?php endwhile; // end of the loop. ?>

                <hr>

                <?php comments_template('', true); ?>

            </div>
        </div>

        <?php get_template_part('content-footer'); ?>

    </div>

<?php get_footer(); ?>