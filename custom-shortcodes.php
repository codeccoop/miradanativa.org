<?php

function miradanativa_get_noticies_posts()
{
    $posts = get_posts(array(
        'post_type'    => 'post',
        'numberposts'  => 3,
        'post_status'  => 'publish'
    ));

    // throw new Exception (print_r($posts));
    return array($posts);
}

function miradanativa_getposts_function()
{
    $posts = miradanativa_get_noticies_posts();
    $posts = $posts[0];
    $html = '<h5 class="frontpage_news_section_title">' . pll__("Noticias") . '</h5>';


    $html .= '<div class="frontpage_news">';

    foreach ($posts as $key => $post) {
        $html .= '<div class="' . $post->ID . '">';

        if (has_post_thumbnail($post->ID)) {
            $html .= '<a class="thumbnail-img" href="' . get_permalink($post->ID) . '" target="_blank">' . get_the_post_thumbnail($post->ID) . '</a>';
        }
        $html .= '<a class="frontpage_title" href="' . get_permalink($post->ID) . '" target="_blank"><h5>' . $post->post_title . '</h5></a>';
        $category = get_the_category($post->ID);
        $category = $category[0];
        $date = get_the_date('j \d\e F \d\e Y', $post->ID);
        $html .= '<p class="news_meta">' . $date . ' | ' . $category->name . '</p>';
        $html .= '<p class="news_excerpt has-small-font-size">' . $post->post_excerpt . '</p>';
        $html .= '</div>';
        // $html .= '<select class="ajax_mn_filter" id="' . $taxonomy. '" multiple="multiple"">';

    }
    $html .= '</div>';
    if (pll_current_language() === 'es') {
        $html .= '<div class="wp-block-buttons is-content-justification-center"> <div class="wp-block-button inverted is-style-outline"> <a class="news_archive_button wp-block-button__link" href="' . site_url() . '/noticias" target="_blank">' . pll__("Ver más publicaciones") . '</a></div></div>';
    } else {
        $html .= '<div class="wp-block-buttons is-content-justification-center"> <div class="wp-block-button inverted is-style-outline"> <a class="news_archive_button wp-block-button__link" href="' . site_url() . '/noticies" target="_blank">' . pll__("Ver más publicaciones") . '</a></div></div>';
    }


    return $html;
}
?>
<?php
add_shortcode('miradanativa_getposts', 'miradanativa_getposts_function');
?>
