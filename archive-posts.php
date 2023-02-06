<?php

/**
 * Template Name: Graella de posts
 *
 * @package WordPress
 * @subpackage MiradaNativa
 */

get_header();
?>
<main id="archive-posts" class="site-main archive" role="main">
    <header class="archive-header has-text-align-center header-footer-group">
        <div class="archive-header-inner section-inner medium">
            <h1 class="archive-title"><?= the_title(); ?></h1>
        </div><!-- .archive-header-inner -->
    </header><!-- .archive-header -->
    <nav class="archive-posts__filters">
        <span>Filtra per categoria:</span>
        <a data-term="all" class="archive-posts__filter async-filter">Todo</a>
        <a data-term="reseña" class="archive-posts__filter async-filter">Reseñas</a>
        <a data-term="noticia" class="archive-posts__filter async-filter">Noticias</a>
    </nav>
    <div class="archive-posts__grid async-grid">
    </div>
    <?php
    // $tag = wp_get_post_tags(get_the_ID())[0];
   
    get_template_part('template-parts/pagination'); ?>
    <nav class="workshop-archive__pagination">
        <ul class="workshop-archive__pages async-pager"></ul>
    </nav>
</main><!-- #site-content -->

<?php get_template_part('template-parts/footer-menus-widgets'); ?>

<?php
get_footer();
