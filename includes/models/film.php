<?php

add_action('init', 'mn_register_film_cpt', 10);
function mn_register_film_cpt()
{
    $POST_TYPE = "film";
    register_post_type(
        $POST_TYPE,
        [
            'labels' => [
                'name' => __('Films'),
                'singular_name' => __(
                    'Film'
                )
            ],

            // Frontend
            'has_archive' => false,
            'public' => true,
            'publicly_queryable' => true,

            // Admin
            'capability_type' => 'post',
            'menu_icon' => 'dashicons-admin-home',
            'menu_position' => 28,
            'query_var' => true,
            'show_in_menu' => true,
            'show_ui' => true,
            'show_in_rest' => true,
            'supports' => [
                'title',
                'thumbnail',
                'excerpt',
                'custom-fields',
            ],
            'taxonomies' => [
                "category"
            ]
        ]
    );

    register_post_meta(
        $POST_TYPE,
        'vimeo_id',
        [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
        ]
    );

    register_post_meta(
        $POST_TYPE,
        'cartel_en_carrousels',
        [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'int',
        ]
    );

    register_post_meta(
        $POST_TYPE,
        'cartel_en_ficha',
        [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'int',
        ]
    );

    register_post_meta(
        $POST_TYPE,
        'sinopsis',
        [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
        ]
    );

    register_post_meta(
        $POST_TYPE,
        'sinopsis_larga',
        [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
        ]
    );

    register_post_meta(
        $POST_TYPE,
        'duracion',
        [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
        ]
    );

    register_post_meta(
        $POST_TYPE,
        'ano_produccion',
        [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
        ]
    );

    register_post_meta(
        $POST_TYPE,
        'idioma',
        [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
        ]
    );

    register_post_meta(
        $POST_TYPE,
        'subtitulos',
        [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
        ]
    );

    register_post_meta(
        $POST_TYPE,
        'reparto',
        [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
        ]
    );

    register_post_meta(
        $POST_TYPE,
        'premios',
        [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
        ]
    );

    register_post_meta(
        $POST_TYPE,
        'enlaces',
        [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
        ]
    );
}
