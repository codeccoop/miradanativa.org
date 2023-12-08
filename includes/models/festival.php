<?php

add_action('init', 'mn_register_festival_cpt', 10);
function mn_register_festival_cpt()
{
    $POST_TYPE = 'festival';
    register_post_type(
        $POST_TYPE,
        [
            'labels' => [
                'name' => __('Festivals'),
                'singular_name' => __(
                    'Festival'
                )
            ],

            // Frontend
            'has_archive' => false,
            'public' => true,
            'publicly_queryable' => true,

            // Admin
            'capability_type' => 'post',
            'menu_icon' => 'dashicons-admin-home',
            'menu_position' => 28,
            'query_var' => true,
            'show_in_menu' => true,
            'show_ui' => true,
            'show_in_rest' => true,
            'supports' => [
                'title',
                'thumbnail',
                'excerpt',
                'custom-fields',
            ],
            'taxonomies' => [
                "category"
            ]
        ]
    );

    register_post_meta(
        $POST_TYPE,
        'vimeo_id',
        [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
        ]
    );

    register_post_meta(
        $POST_TYPE,
        'cartel_en_carrousels',
        [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'int',
        ]
    );

    register_post_meta(
        $POST_TYPE,
        'cartel_en_ficha',
        [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'int',
        ]
    );

    register_post_meta(
        $POST_TYPE,
        'sinopsis',
        [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
        ]
    );

    register_post_meta(
        $POST_TYPE,
        'sinopsis_larga',
        [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
        ]
    );

    register_post_meta(
        $POST_TYPE,
        'duracion',
        [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
        ]
    );

    register_post_meta(
        $POST_TYPE,
        'ano_produccion',
        [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
        ]
    );

    register_post_meta(
        $POST_TYPE,
        'idioma',
        [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
        ]
    );

    register_post_meta(
        $POST_TYPE,
        'subtitulos',
        [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
        ]
    );

    register_post_meta(
        $POST_TYPE,
        'reparto',
        [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
        ]
    );

    register_post_meta(
        $POST_TYPE,
        'premios',
        [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
        ]
    );

    register_post_meta(
        $POST_TYPE,
        'enlaces',
        [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
        ]
    );
}

/* Custom roles for festivals */
add_action('init', 'mn_festival_role', 90);
function mn_festival_role()
{
    add_role(
        'festival',
        __('Festival'),
        array()
    );
}

add_action('admin_init', 'mn_remove_menu_pages');
function mn_remove_menu_pages()
{
    if (current_user_can('festival')) {
        remove_menu_page('index.php');
        remove_menu_page('edit.php');
        remove_menu_page('edit-comments.php');
        remove_menu_page('tools.php');
        remove_menu_page('admin.php?page=megamenu');
    }
}

add_action('add_meta_boxes', 'mn_filter_yasr_metabox', 99);
function mn_filter_yasr_metabox()
{
    if (current_user_can('festival')) {
        remove_meta_box('yasr_metabox_overall_rating', ['festival', 'pelicula'], 'normal');
        remove_meta_box('wpseo_meta', ['festival', 'pelicula'], 'normal');
        remove_meta_box('yasr_metabox_below_editor_metabox', ['festival', 'pelicula'], 'normal');
    }
}

/* Life cycle */
add_filter('wp_insert_post_data', 'mn_on_festival_insert', 99, 2);
function mn_on_festival_insert($data, $postarr)
{
    if ($postarr['post_type'] === 'festival' && $postarr['ID'] != 0 && $data['post_status'] != 'trash') {
        $slug = wp_unique_post_slug(
            $postarr['post_title'],
            $postarr['ID'],
            $postarr['post_status'],
            $postarr['post_type'],
            null,
        );

        $term = mn_find_cataleg_by_slug($slug);
        if ($term != false) return;

        wp_insert_term(
            $postarr['post_title'],
            'cataleg',
            ['description' => 'Catàleg del festival ' . $postarr['post_title']],
        );
    }

    return $data;
}

add_action('wp_trash_post', 'mn_on_delete_festival', 10);
function mn_on_delete_festival($ID)
{
    if (get_post_type($ID) === 'festival') {
        $slug = get_post_field('post_name', $ID);
        $term = mn_find_cataleg_by_slug($slug);
        if ($term == false) return;
        wp_delete_term((int) $term->term_id, 'cataleg');
    }
}

add_action('untrash_post', 'mn_on_untrash_festival', 10);
function mn_on_untrash_festival($ID)
{
    if (get_post_type($ID) == 'festival') {
        $festival = get_post($ID);
        $term = mn_find_cataleg_by_slug(str_replace('__trashed', '', $festival->post_name));
        if ($term != false) return;
        wp_insert_term($festival->post_title, 'cataleg', array(
            'description' => 'Catàleg del festival ' . $festival->post_title
        ));
    }
}

function mn_find_cataleg_by_slug($slug)
{
    $target = false;
    $terms = get_terms([
        'taxonomy' => 'cataleg',
        'hide_empty' => false
    ]);

    foreach ($terms as $term) {
        if ($target !== false) continue;
        if ($term->slug === $slug) $target = $term;
    }

    return $target;
}
