<?php

add_action('init', 'mn_register_festival_cpt', 10);
function mn_register_festival_cpt()
{
    $POST_TYPE = 'fest';
    register_post_type(
        $POST_TYPE,
        [
            'labels' => [
                'name' => __('Festivales', 'miradanativa'),
                'singular_name' => __('Festival', 'miradanativa'),
            ],

            // Frontend
            'has_archive' => false,
            'public' => true,
            'rewrite' => ['slug' => 'festival'],

            // Admin
            'capability_type' => 'post',
            'menu_icon' => 'dashicons-video-alt',
            'menu_position' => 28,
            'show_in_rest' => true,
            'supports' => ['title'],
        ]
    );
}

/* life cycle */
add_filter('wp_insert_post_data', 'mn_on_festival_insert', 99, 2);
function mn_on_festival_insert($data, $postarr)
{
    if ($postarr['post_type'] !== 'fest' || $postarr['ID'] === 0 || $data['post_status'] === 'trash') {
        return $data;
    }

    $slug = wp_unique_post_slug(
        $postarr['post_title'],
        $postarr['ID'],
        $postarr['post_status'],
        $postarr['post_type'],
        null,
    );

    $term = get_term_by('slug', $slug, 'mn_cataleg');
    if ($term !== false) return $data;

    $term = wp_insert_term(
        $postarr['post_title'],
        'mn_cataleg',
        [
            'slug' => $slug,
            'description' => 'Catàleg del festival ' . $postarr['post_title'],
        ],
    );

    $lng = isset($postarr['post_lang_choice']) ? $postarr['post_lang_choice'] : null;
    if (!$lng) $lng = pll_get_post_language($postarr['ID']);
    pll_set_term_language($term['term_id'], $lng);

    return $data;
}

add_action('wp_trash_post', 'mn_on_delete_festival', 10);
function mn_on_delete_festival($ID)
{
    if (get_post_type($ID) === 'fest') {
        $slug = get_post_field('post_name', $ID);
        $term = get_term_by('slug', $slug, 'mn_cataleg');
        if ($term == false) return;
        wp_delete_term((int) $term->term_id, 'mn_cataleg');
    }
}

add_action('untrash_post', 'mn_on_untrash_festival', 10);
function mn_on_untrash_festival($ID)
{
    if (get_post_type($ID) == 'fest') {
        $festival = get_post($ID);
        $term = get_term_by('slug', str_replace('__trashed', '', $festival->post_name), 'mn_cataleg');
        if ($term != false) return;
        wp_insert_term($festival->post_title, 'mn_cataleg', array(
            'description' => 'Catàleg del festival ' . $festival->post_title
        ));
    }
}
