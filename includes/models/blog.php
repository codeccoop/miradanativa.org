<?php

add_action('init', 'mn_register_blog_cpt', 10);
function mn_register_blog_cpt()
{
    $POST_TYPE = 'blog';
    register_post_type(
        $POST_TYPE,
        [
            'labels' => [
                'name' => __('Blog', 'miradanativa'),
                'singular_name' => __('Entrada del blog', 'miradanativa'),
            ],

            // Frontend
            'has_archive' => true,
            'public' => true,
            // 'rewrite' => ['slug' => 'blog'],

            // Admin
            'capability_type' => 'post',
            'menu_icon' => 'dashicons-admin-post',
            'menu_position' => 20,
            'show_in_rest' => true,
            'supports' => [
                'title',
                'thumbnail',
                'excerpt',
                'editor'
            ],
            'taxonomies' => ['post_tag', 'category']
        ]
    );
}
