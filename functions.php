<?php

/* Custom taxonomies */
require_once 'includes/taxonomy-mn-pobles.php';
require_once 'includes/taxonomy-mn-etiqueta.php';
require_once 'includes/taxonomy-mn-genere.php';
require_once 'includes/taxonomy-mn-metratge.php';
require_once 'includes/taxonomy-mn-tematica.php';
require_once 'includes/taxonomy-mn-zona.php';
require_once 'includes/taxonomy-mn-produccio.php';
require_once 'includes/taxonomy-mn-realitzacio.php';

/* Custom post type definition */
require_once 'post-types/film.php';

/* ACF */
require_once 'acf/film.php';


/* Include custom shortcodes */
require_once get_theme_file_path('/custom-shortcodes.php');


require get_theme_file_path('/ajax/async-grid.php');

/* Child theme style loader */
add_action('wp_enqueue_scripts', 'miradanativa_enqueue_styles');
function miradanativa_enqueue_styles()
{
    $parenthandle = 'twentytwenty-style';
    $theme = wp_get_theme();
    wp_enqueue_style(
        $parenthandle,
        get_template_directory_uri() . '/style.css',
        array(),
        $theme->parent()->get('Version')
    );

    wp_enqueue_style(
        'miradanativa-style',
        get_stylesheet_uri(),
        array($parenthandle),
        $theme->get('Version')
    );
    wp_enqueue_script(
        'miradanativa-festival',
        get_stylesheet_directory_uri() . '/js/festival.js',
        array(),
        $theme->get('Version'),
        true
    );
    wp_enqueue_script(
        'miradanativa-festival-colors',
        get_stylesheet_directory_uri() . '/js/color.js',
        array(),
        $theme->get('Version'),
        false
    );
    wp_enqueue_script(
        'async-grid',
        get_stylesheet_directory_uri() . '/js/async-grid.js',
        array(),
        $theme->get('Version'),
        false
    );
    wp_localize_script(
        'async-grid',
        'ajax_data',
        array(
            'nonce' => wp_create_nonce('async_grid'),
            'ajax_url' => admin_url('admin-ajax.php'),
        )
    );
}


/* Add pages tags supports */
add_action('init', 'miradanativa_tags_support_all', 40);
function miradanativa_tags_support_all()
{
    register_taxonomy_for_object_type('post_tag', 'page');
}

add_action('pre_get_posts', 'tags_support_query', 41);
function tags_support_query($wp_query)
{
    if ($wp_query->get('tag')) $wp_query->set('post_type', 'any');
}


/************* */

/** FESTIVAL */

/* Custom roles for festivals */
add_action('init', 'miradanativa_festival_role', 90);
function miradanativa_festival_role()
{
    // remove_role('festival');
    add_role(
        'festival',
        __('Festival'),
        array()
    );
}

add_action('admin_init', 'miradanativa_remove_menu_pages');
function miradanativa_remove_menu_pages()
{
    global $user_ID;
    //if the user is NOT an administrator remove the menu for downloads
    if (current_user_can('festival')) { //change role or capability here
        remove_menu_page('index.php');
        remove_menu_page('edit.php');
        remove_menu_page('edit-comments.php');
        remove_menu_page('tools.php');  //change menu item here
        remove_menu_page('admin.php?page=megamenu');
        # remove_menu_page('edit.php?post_type=festival'); //change menu item here
    }
}
//Remove metaboxes from YASR and YOAST pluggins in festival user
add_action('add_meta_boxes', 'miradanativa_filter_yasr_metabox', 99);
function miradanativa_filter_yasr_metabox()
{
    if (current_user_can('festival')) {
        remove_meta_box('yasr_metabox_overall_rating', array('festival', 'pelicula'), 'normal');
        remove_meta_box('wpseo_meta', array('festival', 'pelicula'), 'normal');
        remove_meta_box('yasr_metabox_below_editor_metabox', array('festival', 'pelicula'), 'normal');
    }
}

/* CATALEG CUSTOM TAXONOMY */
add_action('init', 'miradanativa_register_cataleg_post_type', 99);
function miradanativa_register_cataleg_post_type()
{
    $labels = array(
        'name'              => __('Catàlegs', 'textdomain'),
        'singular_name'     => __('Catàleg', 'textdomain'),
        'search_items'      => __('Buscar catàlegs', 'textdomain'),
        'all_items'         => __('Tots els catàlegs', 'textdomain'),
        'edit_item'         => __('Edita el catàleg', 'textdomain'),
        'update_item'       => __('Actualitza el catàleg', 'textdomain'),
        'add_new_item'      => __('Afegeix un catàleg', 'textdomain'),
        'new_item_name'     => __('Catàleg nou', 'textdomain'),
        'menu_name'         => __('Catàlegs', 'textdomain'),
    );
    $args = array(
        'labels'            => $labels,
        'public'            => true,
        'show_admin_column' => true,
        'show_ui'           => true,
        'hierarchical'      => false,
        'capabilities'      => array(
            'manage_terms'  => 'edit_cataleg',
            'edit_terms'    => 'edit_cataleg',
            'delete_terms'  => 'edit_cataleg',
            'assign_terms'  => 'assign_cataleg'
        )
    );
    register_taxonomy('cataleg', 'pelicula', $args);
}

/* FESTIVAL POST TYPE LIFE CYCLE */
add_filter('wp_insert_post_data', 'miradanativa_on_festival_insert', 99, 2);
function miradanativa_on_festival_insert($data, $postarr)  // , $unsanitized_postarr = null, $update = false)
{
    if ($postarr['post_type'] === 'festival' && $postarr['ID'] != 0 && $data['post_status'] != 'trash') {
        $slug = wp_unique_post_slug($postarr['post_title'], $postarr['ID'], $postarr['post_status'], $postarr['post_type'], null);
        $term = miradanativa_find_cataleg_by_slug($slug);
        if ($term != false) return;
        wp_insert_term($postarr['post_title'], 'cataleg', array(
            'description' => 'Catàleg del festival ' . $postarr['post_title']
        ));
    }

    return $data;
}

add_action('wp_trash_post', 'miradanativa_on_delete_festival', 10);
function miradanativa_on_delete_festival($ID)
{
    if (get_post_type($ID) === 'festival') {
        $slug = get_post_field('post_name', $ID);
        $term = miradanativa_find_cataleg_by_slug($slug);
        if ($term == false) return;
        wp_delete_term((int) $term->term_id, 'cataleg');
    }
}

add_action('untrash_post', 'miradanativa_on_untrash_festival', 10);
function miradanativa_on_untrash_festival($ID)
{
    if (get_post_type($ID) == 'festival') {
        $festival = get_post($ID);
        $term = miradanativa_find_cataleg_by_slug(str_replace('__trashed', '', $festival->post_name));
        if ($term != false) return;
        wp_insert_term($festival->post_title, 'cataleg', array(
            'description' => 'Catàleg del festival ' . $festival->post_title
        ));
    }
}

function miradanativa_find_cataleg_by_slug($slug)
{
    $target = false;
    $terms = get_terms(array(
        'taxonomy' => 'cataleg',
        'hide_empty' => false
    ));
    foreach ($terms as $term) {
        if ($target != false) continue;
        if ($term->slug === $slug) {
            $target = $term;
        }
    }

    return $target;
}


/**MIRADANATIVA BLOG */

/*get_the_date filter to modify date format for a post*/

add_action('get_the_date', 'mn_filter_publish_dates', 10, 3);

function mn_filter_publish_dates($the_date, $d, $post)
{
    $post_id = $post->ID;
    return $the_date;
    return date('Y-d-m - h:j:s', strtotime($the_date));
}

/*POLYLANG*/
/*Allow polylang to include custom strings to the string-translation database*/

add_action('init', function () {
    pll_register_string('elmercatcultural-maspublicaciones', "Ver más publicaciones");
    pll_register_string('elmercatcultural-archivo-todo', "TODO");
    pll_register_string('elmercatcultural-archivo-recomendaciones', "RECOMENDACIONES");
    pll_register_string('elmercatcultural-archivo-Noticias', "NOTICIAS");
    pll_register_string('elmercatcultural-archivo-slug', "noticias");
    pll_register_string('elmercatcultural-archivo-slug', "No se han encontrado publicaciones");
    pll_register_string('elmercatcultural-films-relacionados', "Ver película");
    pll_register_string('elmercatcultural-posts-relacionados', "Te puede interesar");
});


// add_filter('pll_get_post_types', 'my_i18n_post_types', 10, 2);
// function my_i18n_post_types($post_types, $is_settings)
// {
//     if ($is_settings) {

//         // Add this post type to possible i18n enabled post-types (polylang settings)
//         $post_types['ficha_pelicula'] = 'ficha_pelicula';
//         $post_types['custom-test'] = 'custom-test';
//     } else {

//         // Force enable this post type
//         $post_types['ficha_pelicula'] = 'ficha_pelicula';
//         $post_types['custom-test'] = 'custom-test';
//     }
//     return $post_types;
// }

add_action('init', 'mn_translate_terms', 5);
function mn_translate_terms()
{

    if (!isset($_GET['mn_translate_term'])) return;
    if (ob_get_contents()) ob_end_clean();
    $es_ID = (int) $_GET['es_ID'];
    $ca_ID = (int) $_GET['ca_ID'];
    pll_save_term_translations(array(
        'es' => $es_ID,
        'ca' => $ca_ID
    ));


    header('Contest-Type: application/json');
    echo '{"success": true}';
    die();
}
