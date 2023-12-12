<?php

add_action('init', 'mn_register_pobles_type_tax', 20);
function mn_register_pobles_type_tax()
{
    register_taxonomy('mn_pueblo_indigena', 'film', [
        'labels' => [
            'name' => __('Pueblos indígenas'),
            'singular_name' => __('Pueblo indígena'),
        ],
        'public' => true,
        'show_in_rest' => true,
        'has_archive' => true,
        'rewrite' => ['slug' => 'pueblo_indigena'],
    ]);
}
