<?php

add_action('init', 'mn_register_film_cpt', 10);
function mn_register_film_cpt()
{
    $POST_TYPE = "film";
    register_post_type(
        $POST_TYPE,
        [
            'labels' => [
                'name' => __('Películas'),
                'singular_name' => __('Película'),
            ],

            // Frontend
            'has_archive' => false,
            'public' => true,
            'rewrite' => ['slug' => 'pelicula'],

            // Admin
            'capability_type' => 'post',
            'menu_icon' => 'dashicons-format-video',
            'menu_position' => 27,
            'show_in_rest' => true,
            'supports' => ['title'],
            'taxonomies' => ['post_tag'],
        ]
    );
}
