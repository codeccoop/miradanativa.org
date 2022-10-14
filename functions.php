<?php
add_action('wp_enqueue_scripts', 'miradanativa_enqueue_styles');
function miradanativa_enqueue_styles()
{
    /* wp_enqueue_style( */
    /*     'miradanativa-style', */
    /*     get_stylesheet_uri(), */
    /*     array('twentytwenty-style'), */
    /*     wp_get_theme()->get('Version') // this only works if you have Version in the style header */
    /* ); */

    /* function tt_child_enqueue_parent_styles() */
    /* { */
    /*     wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css'); */
    /* } */

    $parenthandle = 'twentytwenty-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.
    $theme = wp_get_theme();
    wp_enqueue_style(
        $parenthandle,
        get_template_directory_uri() . '/style.css',
        array(),  // if the parent theme code has a dependency, copy it to here
        $theme->parent()->get('Version')
    );
    wp_enqueue_style(
        'miradanativa-style',
        get_stylesheet_uri(),
        array($parenthandle),
        $theme->get('Version') // this only works if you have Version in the style header
    );
}

function miradanativa_tags_support_all()
{
    register_taxonomy_for_object_type('post_tag', 'page');
}
function tags_support_query($wp_query)
{
    if ($wp_query->get('tag')) $wp_query->set('post_type', 'any');
}
add_action('init', 'miradanativa_tags_support_all');
add_action('pre_get_posts', 'tags_support_query');
