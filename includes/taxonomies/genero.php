<?php

add_action('init', 'mn_register_genere_type_tax', 20);
function mn_register_genere_type_tax()
{
    register_taxonomy('mn_genero', 'film', [
        'labels' => [
            'name' => __('Géneros'),
            'singular_name' => __('Género'),
        ],
        'public' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'rewrite' => ['slug' => 'genero'],
    ]);
}
