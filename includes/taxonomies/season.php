<?php

add_action('init', 'mn_register_season_type_tax', 20);
function mn_register_season_type_tax()
{
    register_taxonomy('mn_season', 'episode', [
        'labels' => [
            'name' => __('Temporadas', 'miradanativa'),
            'singular_name' => __('Temporada', 'miradanativa'),
        ],
        'public' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'rewrite' => ['slug' => 'temporada'],
    ]);
}
