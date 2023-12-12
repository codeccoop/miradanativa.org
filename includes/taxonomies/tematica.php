<?php

add_action('init', 'mn_register_tematica_type_tax', 20);
function mn_register_tematica_type_tax()
{
    register_taxonomy('mn_tematica', 'film', [
        'labels' => [
            'name' => __('Temáticas', 'miradanativa'),
            'singular_name' => __('Temática', 'miradanativa'),
        ],
        'public' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'rewrite' => ['slug' => 'tematica'],
    ]);
}
