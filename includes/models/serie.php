<?php

add_action('init', 'mn_register_serie_cpt', 10);
function mn_register_serie_cpt()
{
    $POST_TYPE = "serie";
    register_post_type(
        $POST_TYPE,
        [
            'labels' => [
                'name' => __('Series'),
                'singular_name' => __('Serie'),
            ],

            // Frontend
            'has_archive' => false,
            'public' => true,

            // Admin
            'capability_type' => 'post',
            'menu_icon' => 'dashicons-format-video',
            'menu_position' => 28,
            'show_in_rest' => true,
            'supports' => ['title', 'author'],
            'taxonomies' => ['category', 'post_tag'],
        ]
    );
}
