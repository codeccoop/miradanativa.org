<?php

add_action('init', 'mn_register_zona_type_tax', 20);
function mn_register_zona_type_tax()
{
    register_taxonomy('mn_zona_geografica', 'film', [
        'labels' => [
            'name' => __('Zonas Geográficas'),
            'singular_name' => __('Zona Geográfica'),
        ],
        'public' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'rewrite' => ['slug' => true],
    ]);
}
