<?php
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

add_action('init', 'add_theme_caps', 91);
function add_theme_caps()
{
    /* $user = wp_get_current_user(); */
    /* echo print_r($user->get_role_caps()); */

    // gets the administrator role
    $admins = get_role('administrator');

    $admins->add_cap('edit_festival');
    $admins->add_cap('read_festival');
    $admins->add_cap('delete_festival');
    $admins->add_cap('delete_festivals');
    $admins->add_cap('delete_private_festivals');
    $admins->add_cap('delete_published_festivals');
    $admins->add_cap('delete_others_festivals');
    $admins->add_cap('edit_private_festivals');
    $admins->add_cap('edit_published_festivals');

    $admins->add_cap('edit_pelicula');
    $admins->add_cap('read_pelicula');
    $admins->add_cap('delete_pelicula');
    $admins->add_cap('delete_peliculas');
    $admins->add_cap('delete_private_peliculas');
    $admins->add_cap('delete_published_peliculas');
    $admins->add_cap('delete_others_peliculas');
    $admins->add_cap('edit_private_peliculas');
    $admins->add_cap('edit_published_peliculas');

    $admins->add_cap('edit_cataleg');
    $admins->add_cap('read_cataleg');
    $admins->add_cap('delete_cataleg');
    $admins->add_cap('delete_catalegs');
    $admins->add_cap('delete_private_catalegs');
    $admins->add_cap('delete_published_catalegs');
    $admins->add_cap('delete_others_catalegs');
    $admins->add_cap('edit_private_catalegs');
    $admins->add_cap('edit_published_catalegs');
    $admins->add_cap('assign_cataleg');

    $admins->add_cap('manage_tematica', true);
    $admins->add_cap('edit_tematica', true);
    $admins->add_cap('delete_tematica', true);
    $admins->add_cap('read_tematica', true);

    $festival = get_role('festival');

    $festival->add_cap('read', true);
    $festival->add_cap('edit_posts', true);
    $festival->add_cap('publish_posts', false);
    $festival->add_cap('edit_pages', false);
    $festival->add_cap('publish_pages', false);
    $festival->add_cap('read_files', true);
    $festival->add_cap('upload_files', true);

    $festival->add_cap('edit_pelicula', true);
    $festival->add_cap('delete_pelicula', true);
    $festival->add_cap('publish_pelicula', true);
    $festival->add_cap('delete_private_peliculas', true);
    $festival->add_cap('delete_published_peliculas', true);
    $festival->add_cap('edit_private_peliculas', true);
    $festival->add_cap('edit_published_peliculas', true);
    //test
    $festival->add_cap('edit_pelicula', true);
    $festival->add_cap('read_pelicula', true);
    $festival->add_cap('delete_pelicula', true);
    $festival->add_cap('delete_peliculas', true);
    $festival->add_cap('delete_private_peliculas', true);
    $festival->add_cap('delete_published_peliculas', true);
    $festival->add_cap('delete_others_peliculas', false);
    $festival->add_cap('edit_private_peliculas', true);
    $festival->add_cap('edit_published_peliculas', false);
    $festival->add_cap('edit_others_peliculas', false);
    //
    $festival->add_cap('edit_festival', true);
    $festival->add_cap('delete_festival', true);
    $festival->add_cap('publish_festival', true);
    $festival->add_cap('delete_private_festivals', true);
    $festival->add_cap('delete_published_festivals', true);
    $festival->add_cap('edit_private_festivals', true);
    $festival->add_cap('edit_published_festivals', true);

    $festival->add_cap('manage_categories', false);
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
        remove_menu_page( 'admin.php?page=megamenu' );
        # remove_menu_page('edit.php?post_type=festival'); //change menu item here
    }
}
//Remove metaboxes from YASR and YOAST pluggins in festival user
add_action('add_meta_boxes', 'miradanativa_filter_yasr_metabox', 99);
function miradanativa_filter_yasr_metabox()
{
    if (current_user_can('festival')){
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
