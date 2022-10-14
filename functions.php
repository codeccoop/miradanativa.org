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
}

/* Add pages tags supports */
add_action('init', 'miradanativa_tags_support_all');
function miradanativa_tags_support_all()
{
    register_taxonomy_for_object_type('post_tag', 'page');
}

add_action('pre_get_posts', 'tags_support_query');
function tags_support_query($wp_query)
{
    if ($wp_query->get('tag')) $wp_query->set('post_type', 'any');
}

/* Custom roles for festivals */
add_action('init', 'miradanativa_festival_role');
function miradanativa_festival_role()
{
    add_role(
        'festival',
        __('Festival'),
        array(
            // 'read' => false,
            // 'edit_files' => true,
            // 'upload_files' => true,
            // 'edit_post' => true,
            // 'edit_posts' => true,
            // 'delete_posts' => true
            // 'read' => true,
            // 'edit_posts' => true,
            // 'edit_published_posts' => true
        )
    );
}

add_action('admin_init', 'add_theme_caps');
function add_theme_caps()
{
    /* $user = wp_get_current_user(); */
    /* echo print_r($user->get_role_caps()); */

    // gets the administrator role
    $admins = get_role('administrator');

    $admins->add_cap('edit_festival');
    $admins->add_cap('edit_festivals');
    $admins->add_cap('edit_published_festivals');
    $admins->add_cap('edit_others_festivals');
    $admins->add_cap('publish_festivals');
    $admins->add_cap('read_festival');
    $admins->add_cap('read_private_festivals');
    $admins->add_cap('delete_festival');
    $admins->add_cap('delete_festivals');
    $admins->add_cap('delete_published_festivals');
    $admins->add_cap('delete_others_festivals');

    $admins->add_cap('edit_pelicula');
    $admins->add_cap('edit_peliculas');
    $admins->add_cap('edit_published_peliculas');
    $admins->add_cap('edit_others_peliculas');
    $admins->add_cap('publish_peliculas');
    $admins->add_cap('read_pelicula');
    $admins->add_cap('read_private_peliculas');
    $admins->add_cap('delete_pelicula');
    $admins->add_cap('delete_peliculas');
    $admins->add_cap('delete_published_peliculas');
    $admins->add_cap('delete_others_peliculas');

    $festival = get_role('festival');

    $festival->add_cap('read');
    $festival->add_cap('edit_post');
    $festival->add_cap('read_files');
    $festival->add_cap('upload_files');

    $festival->add_cap('edit_festival');
    $festival->add_cap('edit_festivals');
    $festival->add_cap('edit_published_festivals');
    $festival->add_cap('publish_festivals');
    // $festival->add_cap('read_festival');
    $festival->add_cap('read_private_festivals');
    $festival->add_cap('delete_festival');
    $festival->add_cap('delete_festivals');
    $festival->add_cap('delete_published_festivals');

    $festival->add_cap('edit_pelicula');
    $festival->add_cap('edit_peliculas');
    $festival->add_cap('edit_published_peliculas');
    $festival->add_cap('publish_peliculas');
    // $festival->add_cap('read_pelicula');
    $festival->add_cap('read_private_peliculas');
    $festival->add_cap('delete_pelicula');
    $festival->add_cap('delete_peliculas');
    $festival->add_cap('delete_published_peliculas');
}

add_action('save_post', 'miradanativa_on_festival_insert');
function miradanativa_on_festival_insert($post_ID, $post = false, $update = false)
{
    # Si descomento això, em dona error al editar festivals, pero no aconsegueixo 
    # que em faci echos des d'aquí i no se si està passant l'if
    # throw new Exception();

    if ($update || !$post) return;

    if (get_post_type($post_ID) === 'festival') {
        wp_insert_term($post->title, 'cataleg', array(
            'slug' => $post->slug,
            'description' => 'Catàleg del festival ' . $post->title
        ));
    }
}

/* add_action('pods_api_post_save_pod_item', 'miradanativa_on_festival_save', 10, 3); */
/* function miradanativa_on_festival_save($pieces, $is_new_item, $id) */
/* { */
/*     if ($is_new_item) { */
/*         echo print_r($pieces); */
/*         wp_insert_term($pieces['title'], 'cataleg', array( */
/*             'slug' => $pieces['slug'], */
/*             'description' => 'Catàleg del festival ' . $pieces['title'] */
/*         )); */
/*     } */
/* } */
