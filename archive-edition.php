<?php

/**
 * Template Name: Graella de pel·licules
 *
 * @package WordPress
 * @subpackage MiradaNativa
 */

get_header();
?>
<main id="site-content" class="archive-edition" role="main">
    <header class="archive-header has-text-align-center header-footer-group">
        <div class="archive-header-inner section-inner medium">
            <h1 class="archive-title"><?= the_title(); ?></h1>
        </div><!-- .archive-header-inner -->
    </header><!-- .archive-header -->
    <?php
    $tag = wp_get_post_tags(get_the_ID())[0];
    $args = array(
        'post_type' => 'pelicula',
        'post_status' => 'publish',
        'posts_per_page' => -1,
    );
    $posts = get_posts($args);
    if (sizeof($posts) > 0) : ?>
        <div class="archive-content">
            <?php foreach ($posts as $post) {
                $is_tagged = false;
                foreach (wp_get_post_terms($post->ID, 'etiqueta') as $term) {
                    $is_tagged = $is_tagged || $term->slug == $tag->slug;
                }
                if (!$is_tagged) continue;
                extract($post);
                get_template_part('template-parts/content', 'pelicula-list');
            } ?>
        </div><!-- .archive-content -->
    <?php else : ?>
        <h1>Not found</h1>
    <?php endif; ?>
</main><!-- #site-content -->

<?php get_template_part('template-parts/footer-menus-widgets'); ?>

<?php
get_footer();
