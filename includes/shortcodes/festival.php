<?php

add_shortcode('mn_fest_cataleg', 'mn_fest_cataleg');
function mn_fest_cataleg($atts)
{
    echo '<h1 style="color: white">' . $post_slug . '</h1>';
    $post_slug = get_post_field('post_name', get_post());
    $query = new WP_Query([
        'posts_per_page' => -1,
        'post_type' => 'film',
        'tax_query' => [
            [
                'taxonomy' => 'mn_cataleg',
                'field' => 'slug',
                'terms' => $post_slug,
            ]
        ],
    ]);

    global $post;
    $global_post = $post;
    ob_start();
    while ($query->have_posts()) {
        $query->the_post();
?>
        <article <?php post_class(); ?>>
            <div class="post-inner thin">
                <div class="entry-content">
                    <?php get_template_part('template-parts/content', 'film'); ?>
                </div>
            </div>
        </article>
<?php
    }

    $out = ob_get_clean();

    $query->reset_postdata();
    $post = $global_post;

    return $out;
};
