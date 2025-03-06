<?php

add_action('init', 'mn_register_genere_type_tax', 20);
function mn_register_genere_type_tax()
{
    register_taxonomy('mn_genero', array('film', 'serie'), [
        'labels' => [
            'name' => __('Géneros', 'miradanativa'),
            'singular_name' => __('Género', 'miradanativa'),
        ],
        'public' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'rewrite' => ['slug' => 'genero'],
    ]);
}
