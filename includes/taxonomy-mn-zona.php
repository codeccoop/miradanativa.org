<?php

add_action('init', 'mn_register_zona_type_tax', 20);
function mn_register_zona_type_tax()
{
    //if (defined('WP_CLI') && WP_CLI) return;

    register_taxonomy('mn_zona_geografica', 'film', [
        'labels' => [
            'name' => __('Zona Geogràfica', 'textdomain'),
            'singular_name' => __('Zona Geogràfica', 'textdomain'),
            'search_items' =>  __('Cerca', 'textdomain'),
            'popular_items' => __('Items populars', 'textdomain'),
            'all_items' => __('Tots els items', 'textdomain'),
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => __('Edita l\'ítem', 'textdomain'),
            'update_item' => __('Actualitza l\'ítem', 'textdomain'),
            'add_new_item' => __('Crea un nou item', 'textdomain'),
            'new_item_name' => __('Nou nom de l\'ítem', 'textdomain'),
            'separate_items_with_commas' => __('Separa els items amb comes', 'textdomain'),
            'add_or_remove_items' => __('Afegeix o esborra items', 'textdomain'),
            'choose_from_most_used' => __('Escull entre els valors més populars', 'textdomain'),
            'menu_name' => __('Zones Geogràfiques', 'textdomain'),
        ],
        'hierarchical' => false,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_rest' => true,
        // 'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        // 'rewrite' => ['slug' => 'ce-social-form'],
        'has_archive' => true,
    ]);
}
