<?php

/* taxonomies */
require_once 'includes/taxonomies/pueblo_indigena.php';
require_once 'includes/taxonomies/etiqueta.php';
require_once 'includes/taxonomies/genero.php';
require_once 'includes/taxonomies/metraje.php';
require_once 'includes/taxonomies/tematica.php';
require_once 'includes/taxonomies/zona.php';
require_once 'includes/taxonomies/produccion.php';
require_once 'includes/taxonomies/realizacion.php';
require_once 'includes/taxonomies/cataleg.php';
/* post type */
require_once 'includes/models/film.php';
require_once 'includes/models/festival.php';
/* ACF */
require_once 'includes/acf/film.php';
require_once 'includes/acf/festival.php';
/* custom shortcodes */
require_once 'includes/shortcodes/custom.php';
require_once 'includes/shortcodes/festival.php';
require_once 'includes/shortcodes/indi_separator.php';
require_once 'includes/shortcodes/carousels.php';
require_once 'includes/shortcodes/pods_config.php';
/* ajax */
require 'includes/ajax/async-grid.php';

/* Child theme style loader */
add_action('wp_enqueue_scripts', 'mn_enqueue_styles');
function mn_enqueue_styles()
{
    $parenthandle = 'twentytwenty-style';
    $theme = wp_get_theme();

    wp_enqueue_style(
        $parenthandle,
        get_template_directory_uri() . '/style.css',
        [],
        $theme->parent()->get('Version')
    );

    wp_enqueue_style(
        'mn-style',
        get_stylesheet_uri(),
        [$parenthandle],
        $theme->get('Version')
    );

    wp_enqueue_script(
        'mn-festival',
        get_stylesheet_directory_uri() . '/js/festival.js',
        [],
        $theme->get('Version'),
        true
    );

    wp_enqueue_script(
        'mn-festival-colors',
        get_stylesheet_directory_uri() . '/js/color.js',
        [],
        $theme->get('Version'),
        false
    );

    wp_enqueue_script(
        'async-grid',
        get_stylesheet_directory_uri() . '/js/async-grid.js',
        [],
        $theme->get('Version'),
        false
    );

    wp_localize_script(
        'async-grid',
        'ajax_data',
        [
            'nonce' => wp_create_nonce('async_grid'),
            'ajax_url' => admin_url('admin-ajax.php'),
        ]
    );

    wp_enqueue_script(
        'jquery-jcarrousel-js-file',
        get_template_directory_uri() . '/assets/js/jquery.jcarousel.min.js',
        $theme->get('Version'),
    );

    wp_enqueue_script(
        'jquery-jcarrousel-responsive-js-file',
        get_template_directory_uri() . '/assets/js/jcarousel.responsive.js',
        $theme->get('Version'),
    );

    wp_enqueue_style(
        'jquery-jcarrousel-responsive-css-file',
        get_template_directory_uri() . '/assets/js/jcarousel.responsive.css',
        $theme->get('Version'),
    );

    wp_enqueue_script(
        'floating_menu-file',
        get_template_directory_uri() . '/assets/js/floating_menu.js',
        ['jquery'],
        $theme->get('Version'),
        true,
    );

    wp_enqueue_script(
        'message-processing',
        get_template_directory_uri() . '/assets/js/message_processing.js',
        ['jquery'],
        $theme->get('Version'),
        true,
    );
}

/* Add pages tags supports */
add_action('init', 'mn_tags_support_all', 40);
function mn_tags_support_all()
{
    register_taxonomy_for_object_type('post_tag', 'page');
}

add_action('pre_get_posts', 'tags_support_query', 41);
function tags_support_query($wp_query)
{
    if ($wp_query->get('tag')) $wp_query->set('post_type', 'any');
}

/*
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

add_action('init', 'mn_get_films', 5);
function mn_get_films()
{
    if (!isset($_GET['mn_get_films'])) return;

    $query = new WP_Query([
        'post_type' => 'pelicula',
        'post_status' => [
            'publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash'
        ],
        'posts_per_page' => -1,

    ]);

    $data = [];
    while ($query->have_posts()) {
        global $post;
        $query->the_post();
        $postarr = wp_slash(get_object_vars($post));
        $data[] = $postarr;
    }

    if (ob_get_contents()) ob_end_clean();
    header('Content-Type: application/json');
    echo json_encode($data);
    die();
}
 */

function mn_add_custom_headers()
{
    add_filter('rest_pre_serve_request', function ($value) {
        $origin = get_http_origin();
        if ($origin == "indifest.org") {
            header('Access-Control-Allow-Origin: indifest.org');
            header('Access-Control-Allow-Methods: GET, OPTIONS');
        }
        return $value;
    });
}
add_action('rest_api_init', 'mn_add_custom_headers', 15);

add_action('admin_init', 'mn_disable_comments');
function mn_disable_comments()
{
    // Redirect any user trying to access comments page
    global $pagenow;

    if ($pagenow === 'edit-comments.php') {
        wp_safe_redirect(admin_url());
        exit;
    }

    // Remove comments metabox from dashboard
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

    // Disable support for comments and trackbacks in post types
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
};

// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);

// Remove comments page in menu
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});

// Remove comments links from admin bar
add_action('init', function () {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
});
