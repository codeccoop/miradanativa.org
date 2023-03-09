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
        <a data-term="all" class="archive-posts__filter async-filter">TODO</a>
        <a data-term="reseña" class="archive-posts__filter async-filter">RECOMENDACIONES</a>
        <a data-term="noticia" class="archive-posts__filter async-filter">NOTICIAS</a>
    </nav>
    <div class="archive-posts__grid async-grid">
    </div>
    <nav class="archive-posts__pagination">
        <ul class="archive-posts__pages async-pager"></ul>
    </nav>
</main><!-- #site-content -->

<?php get_template_part('template-parts/footer-menus-widgets');

get_footer();
?>