<?php

function mn_carousels($taxonomy, $post_type, $lang)
{
    $out = '';

    $terms = get_terms([
        'taxonomy' => $taxonomy,
        'hide_empty' => true
    ]);

    if (sizeof($terms) > 0) {
        foreach ($terms as $term) {
            if ($term->slug === 'destacados') continue;
            $out .= mn_taxonomy_carousel($taxonomy, $term->slug, $post_type, $lang);
        }
    }

    return $out;
}

function mn_more_like_this_carousel($post_id, $template, $lang)
{
    $terms = get_the_terms($post_id, 'mn_tematica');
    $tematicas = $terms ? array_map(function ($term) {
        return $term->slug;
    }, $terms) : [];

    $terms = get_the_terms($post_id, 'mn_pueblo_indigena');
    $pueblos = $terms ? array_map(function ($term) {
        return $term->slug;
    }, $terms) : [];

    $terms = get_the_terms($post_id, 'mn_zona_geografica');
    $zonas = $terms ? array_map(function ($term) {
        return $term->slug;
    }, $terms) : [];

    if (empty($pueblos) && empty($zonas) && empty($tematicas)) {
        return '';
    }

    $posts = get_posts([
        'post_type' => 'film',
        'posts_per_page' => 20,
        'orderby' => 'title',
        'order' => 'DESC',
        'meta_query' => [
            'relation' => 'AND',
            [
              'key' => 'vimeo_id',
              'compare' => 'EXISTS',
            ],
            [
              'key' => 'vimeo_id',
              'compare' => '!=',
              'value' => ''
            ],
            [
                'key' => 'vimeo_id',
                'compare' => '!=',
                'value' => 0,
              ]
            ],
        'tax_query' => [
            'relation' => 'OR',
            [
                'taxonomy' => 'mn_tematica',
                'terms' => $tematicas,
                'field' => 'slug',
                'include_children' => false,
                'operator' => 'IN'
            ],
            [
                'taxonomy' => 'mn_pueblo_indigena',
                'terms' => $pueblos,
                'field' => 'slug',
                'include_children' => false,
                'operator' => 'IN'
            ],
            [
                'taxonomy' => 'mn_zona_geografica',
                'terms' => $zonas,
                'field' => 'slug',
                'include_children' => false,
                'operator' => 'IN'
            ],
        ],
    ]);

    if (sizeof($posts) > 0) {
        $title = pll__("Películas relacionadas");
        return mn_render_carousel($posts, $template, $title);
    }

    return '';
}

function mn_taxonomy_carousel($taxonomy, $term, $post_type, $lang)
{
    $term = get_term_by('slug', $term, $taxonomy);
    $posts = get_posts([
        'post_type' => $post_type,
        'posts_per_page' => 40,
        'orderby' => 'date',
        'order' => 'DESC',
        'meta_query' => [
            'relation' => 'AND',
            [
              'key' => 'vimeo_id',
              'compare' => 'EXISTS',
            ],
            [
              'key' => 'vimeo_id',
              'compare' => '!=',
              'value' => ''
            ],
            [
                'key' => 'vimeo_id',
                'compare' => '!=',
                'value' => 0,
              ]
            ],
        'tax_query' => [[
            'taxonomy' => $taxonomy,
            'field' => 'slug',
            'terms' => [$term->slug],
            'operator' => 'IN'
        ]],
    ]);

    if (sizeof($posts) > 0) {
        $title = $term->name;
        return mn_render_carousel($posts, $post_type, $title);
    } else {
        echo "<h1>No posts founs</h1>";
    }

    return '';
}

function mn_render_carousel($posts, $post_type, $title)
{
    ob_start() ?>
    <div class='indi_carousel_wrapper'>
        <?php if (!empty($title)) : ?>
            <h2><?= $title; ?></h2>
        <?php endif; ?>
        <div class='jcarousel-wrapper'>
            <div class="jcarousel">
                <div>
                    <?php
                    $global_post = $GLOBALS['post'];
                    foreach ($posts as $post) :
                        setup_postdata($post);
                        $GLOBALS['post'] = $post;
                        get_template_part('template-parts/content', $post_type);
                        wp_reset_postdata();
                    endforeach;
                    $GLOBALS['post'] = $global_post; ?>
                </div>
            </div>
            <a href="#" class="jcarousel-control-prev" data-jcarouselcontrol="true">‹</a><a href="#" class="jcarousel-control-next" data-jcarouselcontrol="true">›</a>
        </div>
    </div>
<?php
    return ob_get_clean();
}

add_shortcode('carrousels_tematicas', function ($atts) {
    if (!isset($atts['lang'])) $atts['lang'] = pll_current_language();
    return mn_carousels('tematica', 'film', $atts['lang']);
});

add_shortcode('carrousels_generos', function ($atts) {
    if (!isset($atts['lang'])) $atts['lang'] = null;
    return mn_carousels('genero', 'film', $atts['lang']);
});

add_shortcode('carousel_more_like_this', function ($atts) {
    if (!isset($atts['lang'])) $atts['lang'] = pll_current_language();
    return mn_more_like_this_carousel($atts['pelicula_id'], 'film', $atts['lang']);
});

add_shortcode('carrousel_for_tematica', function ($atts) {
    if (!isset($atts['lang'])) $atts['lang'] = pll_current_language();
    return mn_taxonomy_carousel('mn_tematica', $atts['slug'], 'film', $atts['lang']);
});

add_shortcode('carrousel_for_genero', function ($atts) {
    if (!isset($atts['lang'])) $atts['lang'] = pll_current_language();
    return mn_taxonomy_carousel('mn_genero', $atts['slug'], 'film', $atts['lang']);
});
