<?php
/**
 * Template Name: Blog roll full width template
 *
 * @package iwitness
 * @version iWitness 1.0
 */

get_header(); ?>

    <div id="main-container"
         data-api-url="<?php echo iWitness()->api_uri() ?>"
         data-plugin-url="<?php echo iWitness()->plugin_url() ?>">

        <?php get_template_part('content-header'); ?>

        <div class="content-container">
            <div class="container">

                <h2>News</h2>

                <p>
                    The latest news releases and media coverage of iWitness. <a href="#logo">Corporate logo is also available for
                    download below.</a> If you are a member of the media or blogger community and would like additional
                    information or assets for a story, please contact Andrea Gordon at remerinc, 
                    <a href="mailto:agordon@remerinc.com">agordon@remerinc.com</a>
                    or 206.624.1010.
                </p>

                <hr>

                <?php

                $args = array(
					'post_type' => 'post',
					'nopaging' => true
                );
                $post_query = new WP_Query($args);
                if ($post_query->have_posts()) {
                    while ($post_query->have_posts()) {
                        $post_query->the_post();
                        ?>
                        <div class="widget panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>
                            </div>
                            <div class="panel-body">
                                <p>
                                    <?php the_content() ?>
                                    <!--
                                    <a href="<?php the_permalink(); ?>">
                                        Read more...
                                    </a>
                                    -->
                                </p>
                            </div>
                            <div class="panel-footer">
                                <div class="comment-date">
                                    Posted on <strong><?= get_the_date() ?></strong>
                                </div>
                                <div class="num-comment">
                                    <?php echo wp_count_comments(get_the_ID())->total_comments; ?>
                                    <?php echo iwitness_view_helper_pluralize(wp_count_comments(get_the_ID())->total_comments, "Comment", "Comments") ?>
                                </div>
                            </div>
                        </div>

                    <?php
                    }
                }
                ?>

                <?php posts_nav_link(' — ', __('&laquo; Newer Posts'), __('Older Posts &raquo;')); ?>

            </div>
        </div>

        <?php get_template_part('content-footer'); ?>

    </div>

<?php get_footer(); ?>
