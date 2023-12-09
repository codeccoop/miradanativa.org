<?php

add_shortcode('mn_fest_cataleg', 'mn_fest_cataleg');
function mn_fest_cataleg($atts)
{
    $post_slug = get_post_field('post_name', get_post());
    $query = new WP_Query([
        'posts_per_page' => -1,
        'post_type' => 'film',
        'tax_query' => [
            [
                'taxonomy' => 'cataleg',
                'field' => 'slug',
                'terms' => $post_slug,
            ]
        ],
    ]);

    ob_start();
    while ($query->have_posts()) {
        $query->the_post();
        get_template_part('template-parts/content', 'film');
    }

    $out = ob_get_clean();
    return $out;
};
