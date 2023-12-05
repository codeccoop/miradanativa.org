<?php

add_action('init', 'wpct_rest_ce_register_post_type', 10);
function wpct_rest_ce_register_post_type()
{
    register_post_type(
        "film",
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
}
