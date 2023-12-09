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
require_once 'includes/models/fest.php';
/* ACF */
require_once 'includes/acf/film.php';
require_once 'includes/acf/fest.php';
/* pll */
require_once 'includes/pll.php';
/* custom shortcodes */
require_once 'includes/shortcodes/news.php';
require_once 'includes/shortcodes/festival.php';
require_once 'includes/shortcodes/indi_separator.php';
require_once 'includes/shortcodes/carousels.php';

// require_once 'migration.php';

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
        get_stylesheet_directory_uri() . '/assets/js/festival.js',
        [],
        $theme->get('Version'),
        true
    );

    wp_enqueue_script(
        'mn-festival-colors',
        get_stylesheet_directory_uri() . '/assets/js/color.js',
        [],
        $theme->get('Version'),
        false
    );

    wp_enqueue_script(
        'jquery-jcarrousel-js-file',
        get_stylesheet_directory_uri() . '/assets/js/jquery.jcarousel.min.js',
        $theme->get('Version'),
    );

    wp_enqueue_script(
        'jquery-jcarrousel-responsive-js-file',
        get_stylesheet_directory_uri() . '/assets/js/jcarousel.responsive.js',
        $theme->get('Version'),
    );

    wp_enqueue_style(
        'jquery-jcarrousel-responsive-css-file',
        get_stylesheet_directory_uri() . '/assets/css/jcarousel.responsive.css',
        $theme->get('Version'),
    );

    wp_enqueue_script(
        'floating_menu-file',
        get_stylesheet_directory_uri() . '/assets/js/floating_menu.js',
        ['jquery'],
        $theme->get('Version'),
        true,
    );

    wp_enqueue_script(
        'message-processing',
        get_stylesheet_directory_uri() . '/assets/js/message_processing.js',
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

add_filter('waf_template_film', 'mn_film_template_part');
function mn_film_template_part()
{
    ob_start();
?>
    <article <?php post_class(); ?>>
        <div class="post-inner thin">
            <div class="entry-content">
                <?php get_template_part('template-parts/content', 'film'); ?>
            </div>
        </div>
    </article>
<?php
    return ob_get_clean();
}
