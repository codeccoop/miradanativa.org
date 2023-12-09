<?php

add_action('init', 'mn_register_produccio_type_tax', 20);
function mn_register_produccio_type_tax()
{
    register_taxonomy('mn_produccion', 'film', [
        'labels' => [
            'name' => __('Producciones'),
            'singular_name' => __('Producción'),
        ],
        'public' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'rewrite' => ['slug' => 'produccion'],
    ]);
}
