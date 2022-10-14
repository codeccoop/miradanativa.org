<?php

/**
 * The archive template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 *
 * @package WordPress
 * @subpackage MiradaNativa
 */

get_header();
?>
<main id="site-content" class="archive-pelicula" role="main">
    <?php
    $archive_title = get_the_archive_title();
    ?>
    <header class="archive-header has-text-align-center header-footer-group">
        <div class="archive-header-inner section-inner medium">
            <h1 class="archive-title"><?php echo wp_kses_post($archive_title); ?></h1>
        </div><!-- .archive-header-inner -->
    </header><!-- .archive-header -->

    <?php if (have_posts()) : ?>
        <div class="archive-content">
            <?php while (have_posts()) {
                the_post();
                get_template_part('template-parts/content', get_post_type());
            } ?>
        </div><!-- .archive-content -->
    <?php else : ?>
    <?php endif;
    get_template_part('template-parts/pagination'); ?>
</main><!-- #site-content -->

<?php get_template_part('template-parts/footer-menus-widgets'); ?>

<?php
get_footer();
