<?php

/**
 * The archive template file
 *
 * @package WordPress
 * @subpackage MiradaNativa
 */

get_header(); ?>
<div id="primary" class="content-area">
    <main class="site-content archive" role="main">
        <?php $archive_title = get_the_archive_title(); ?>
        <header class="archive-header has-text-align-center header-footer-group">
            <div class="archive-header-inner section-inner medium">
                <h1 class="archive-title"><?php echo wp_kses_post($archive_title); ?></h1>
            </div>
        </header>
        <?php if (have_posts()) : ?>
            <div class="archive-content">
                <?php while (have_posts()) {
                    the_post(); ?>
                    <article <?php post_class(); ?>>
                        <div class="post-inner thin">
                            <div class="entry-content">
                                <?php get_template_part('template-parts/content', get_post_type()); ?>
                            </div>
                        </div>
                    </article>
                <?php } ?>
            </div>
        <?php else : ?>
            <div class="no-results-form section-inner thin">
                <p><?= pll__('No s\'ha trobat contingut relacionat'); ?></p>
            </div>
        <?php endif;
        get_template_part('template-parts/pagination'); ?>
    </main>
    <?php get_template_part('template-parts/footer-menus-widgets'); ?>
</div>
<?php get_footer();
