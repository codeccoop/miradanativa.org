<?php

add_action('init', 'mn_register_realitzacio_type_tax', 20);
function mn_register_realitzacio_type_tax()
{
    register_taxonomy('mn_realizacion', 'film', [
        'labels' => [
            'name' => __('Realitzaciones', 'miradanativa'),
            'singular_name' => __('Realitzación', 'miradanativa'),
        ],
        'public' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'rewrite' => ['slug' => 'realizacion'],
    ]);
}
