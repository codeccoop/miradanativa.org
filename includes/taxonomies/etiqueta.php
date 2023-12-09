<?php

add_action('init', 'mn_register_etiqueta_type_tax', 20);
function mn_register_etiqueta_type_tax()
{
    register_taxonomy('mn_etiqueta', 'film', [
        'labels' => [
            'name' => __('Etiquetas'),
            'singular_name' => __('Etiqueta'),
        ],
        'public' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'rewrite' => ['slug' => 'etiqueta'],
    ]);
}
