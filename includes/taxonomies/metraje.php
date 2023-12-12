<?php

add_action('init', 'mn_register_metratge_type_tax', 20);
function mn_register_metratge_type_tax()
{
    register_taxonomy('mn_metraje', 'film', [
        'labels' => [
            'name' => __('Metrajes', 'miradanativa'),
            'singular_name' => __('Metraje', 'miradanativa'),
        ],
        'public' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'rewrite' => ['slug' => 'metraje'],
    ]);
}
