<?php

add_action('init', 'mn_register_zona_type_tax', 20);
function mn_register_zona_type_tax()
{
    register_taxonomy('mn_zona_geografica', array('film', 'serie'), [
        'labels' => [
            'name' => __('Zonas Geográficas', 'miradanativa'),
            'singular_name' => __('Zona Geográfica', 'miradanativa'),
        ],
        'public' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'rewrite' => ['slug' => true],
    ]);
}
