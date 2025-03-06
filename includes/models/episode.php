<?php

add_action('init', 'mn_register_episode_cpt', 10);
function mn_register_episode_cpt()
{
    $POST_TYPE = "episode";
    register_post_type(
        $POST_TYPE,
        [
            'labels' => [
                'name' => __('CAPÍTULOS'),
                'singular_name' => __('CAPÍTULO'),
            ],

            // Frontend
            'has_archive' => false,
            'public' => true,

            // Admin
            'capability_type' => 'post',
            'menu_icon' => 'dashicons-format-video',
            'menu_position' => 1,
            'show_in_menu' => 'edit.php?post_type=serie',
            'show_in_rest' => true,
            'supports' => ['title', 'author'],
            'taxonomies' => ['category', 'post_tag'],
        ]
    );
}
