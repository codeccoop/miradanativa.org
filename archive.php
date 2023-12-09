<?php

/**
 * The archive template file
 *
 * @package WordPress
 * @subpackage MiradaNativa
 */

get_header();
$is_blog = get_post_type() === 'blog';
?>
<div id="primary" class="content-area">
    <main class="site-content archive archive-<?= get_post_type(); ?>" role="main">
        <?php $archive_title = get_the_archive_title(); ?>
        <header class="archive-header has-text-align-center header-footer-group">
            <div class="archive-header-inner section-inner medium">
                <?php if ($is_blog) : ?>
                    <h1 class="archive-title"><?= pll__('Blog'); ?></h1>
                <?php else : ?>
                    <h1 class="archive-title"><?= wp_kses_post($archive_title); ?></h1>
                <?php endif; ?>
            </div>
        </header>
        <?php if ($is_blog) {
            get_template_part('template-parts/nav-blog');
        } ?>
        <?php if (have_posts()) : ?>
            <div class="archive-content">
                <?php while (have_posts()) {
                    the_post();
                    if (has_category('no-visible-ca') || has_category('no-visible')) continue; ?>
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
                <p><?= pll__('No se ha encontrado contenido relacionado'); ?></p>
            </div>
        <?php endif;
        get_template_part('template-parts/pagination'); ?>
    </main>
    <?php get_template_part('template-parts/footer-menus-widgets'); ?>
</div>
<?php get_footer();
