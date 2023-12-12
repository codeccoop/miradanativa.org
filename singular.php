<?php

/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage MiradaNativa
 */

get_header(); ?>
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <?php
        while (have_posts()) : the_post();
            get_template_part('template-parts/content', get_post_type() . '-single');
        endwhile;
        ?>
    </main>
    <?php get_template_part('template-parts/footer-menus-widgets'); ?>
</div>
<?php get_footer(); ?>
