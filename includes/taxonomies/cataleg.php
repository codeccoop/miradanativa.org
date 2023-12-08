<?php

add_action('init', 'mn_register_cataleg_post_type', 99);
function mn_register_cataleg_post_type()
{
    $labels = [
        'name' => __('Catàlegs'),
        'singular_name' => __('Catàleg'),
    ];

    $args = [
        'labels' => $labels,
        'public' => true,
        'show_admin_column' => true,
        'show_ui' => true,
        'hierarchical' => false,
        'capabilities' => [
            'manage_terms' => 'edit_cataleg',
            'edit_terms' => 'edit_cataleg',
            'delete_terms' => 'edit_cataleg',
            'assign_terms' => 'assign_cataleg'
        ]
    ];

    register_taxonomy('cataleg', 'pelicula', $args);
}
