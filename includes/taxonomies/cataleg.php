<?php

add_action('init', 'mn_register_cataleg_taxonomy', 99);
function mn_register_cataleg_taxonomy()
{
    $labels = [
        'name' => __('Catálogos', 'miradanativa'),
        'singular_name' => __('Catálogo', 'miradanativa'),
    ];

    $args = [
        'labels' => $labels,
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => false,
        'show_in_nav_menus' => false,
        'has_archive' => false,
        'capabilities' => [
            'manage_terms' => 'edit_cataleg',
            'edit_terms' => 'edit_cataleg',
            'delete_terms' => 'edit_cataleg',
            'assign_terms' => 'assign_cataleg'
        ],
        'rewrite' => ['slug' => 'cataleg'],
    ];

    register_taxonomy('cataleg', 'pelicula', $args);
    register_taxonomy('mn_cataleg', 'film', $args);
}
