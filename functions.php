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
require_once 'includes/models/blog.php';
/* acf */
require_once 'includes/acf/film.php';
require_once 'includes/acf/fest.php';
require_once 'includes/acf/blog.php';
/* pll */
require_once 'includes/pll.php';
/* custom shortcodes */
require_once 'includes/shortcodes/festival.php';
require_once 'includes/shortcodes/indi_separator.php';
require_once 'includes/shortcodes/carousels.php';
require_once 'includes/shortcodes/blog.php';
/* custom endpoints */
require_once 'includes/endpoints/catalog.php';


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
        ['jquery'],
        $theme->get('Version'),
    );

    wp_enqueue_script(
        'jquery-jcarrousel-responsive-js-file',
        get_stylesheet_directory_uri() . '/assets/js/jcarousel.responsive.js',
        ['jquery'],
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

    if (is_archive() && get_post_type() === 'blog') {
        wp_enqueue_script(
            'mn-blog-filter',
            get_stylesheet_directory_uri() . '/assets/js/blog.js',
            [],
            $theme->get('Version'),
            true
        );
    }
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
    if ($wp_query->get('tag')) {
        $wp_query->set('post_type', 'any');
    }
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

add_action('wp_head', 'mn_wp_head');
function mn_wp_head()
{
    ?>
  <!-- Google Tag Manager -->
  <script>
    (function(w, d, s, l, i) {
      w[l] = w[l] || [];
      w[l].push({
        'gtm.start': new Date().getTime(),
        event: 'gtm.js'
      });
      var f = d.getElementsByTagName(s)[0],
        j = d.createElement(s),
        dl = l != 'dataLayer' ? '&l=' + l : '';
      j.async = true;
      j.src =
        'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
      f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-M85DF3R');
  </script>
  <!-- End Google Tag Manager -->

  <script>
    function togglePlayer(vimeo_id) {
      var $target = jQuery('.player_iframe');
      if ($target.length > 0) {

        if ($target.attr('src')) {
          $target.attr('src', "");
        } else {
          $target.attr('src', $target.attr('_src'));
          $target.css('width', '100%');
        }
      }

      jQuery('.player_placeholder').toggle();
      jQuery('.player_container').toggle();
      jQuery('.player_div').toggle();

      if (window.matchMedia('(min-width: 600px)').matches) {
        if ($target.attr('src')) {
          jQuery('.player_div').focus();
          jQuery('html, body').animate({
            scrollTop: jQuery(".player_div").offset().top
          }, 2000);
        }
      }

    };

    jQuery(document).ready(function() {
      jQuery('.jcarousel').jcarousel({});
    });
  </script>

  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M85DF3R" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
<?php
}

add_action('init', 'mn_default_posts_per_page');
function mn_default_posts_per_page()
{
    update_option('posts_per_page', 12);
}

add_action('admin_menu', 'mn_hide_posts_menu');
function mn_hide_posts_menu()
{
    remove_menu_page('edit.php');
}

add_action('after_setup_theme', 'mn_load_textdomain');
function mn_load_textdomain()
{
    load_child_theme_textdomain('miradanativa', get_stylesheet_directory() . '/languages');
}

// Bookmarks
add_filter('wpct_bm_bookmark_template', function ($html, $bookmark) {
    global $post;
    $global_post = $post;

    $film = $bookmark->get_post();
    $post = $film;
    setup_postdata($film);

    ob_start(); ?>
    <article <?php post_class(); ?>>
        <div class="post-inner thin">
            <div class="entry-content">
                <?php get_template_part('template-parts/content', 'film'); ?>
            </div>
        </div>
    </article>
    <?php
    wp_reset_postdata();
    $post = $global_post;
    return ob_get_clean();
}, 50, 2);

add_filter('wpct_bm_list_template', function ($html, $list) {
    $img_src = get_stylesheet_directory_uri() . '/assets/images/bookmark.jpg';
    $bookmarks = $list->get_bookmarks();
    ob_start(); ?> 
    <article class="mn-profile-list film type-film">
        <div class="post-inner thin">
            <div class="entry-content">
                <article>
                    <a href="#list-<?= $list->id ?>">
                        <img src="<?= $img_src ?>" />
                        <div class="indi_film_details">
                            <h7><span id="indi_film_title"><?= __($list->title, 'miradanaiva') ?></span></h7>
                          <span class="indi_film_details_value"><?= count($bookmarks) . ' ' . pll__('titles', 'miradanativa') ?></span>
                        </div>
                    </a>
                </article>
            </div>
        </div>
    </article>
    <?php
    return ob_get_clean();
}, 50, 2);

add_action('template_redirect', function () {
    if (is_page('search') || is_page('cercador')) {
        wp_enqueue_script('wpct-bookmarks');
        wp_enqueue_style('wpct-bookmarks');
    }
}, 50);

// Area personal
add_action('pre_get_posts', function ($query) {
    if ($query->get('page_id') == 294 && get_query_var('lang') === 'ca') {
        $trans_id = pll_get_post(294, 'ca');
        $query->set('page_id', $trans_id);
    }
});

add_filter('rewrite_rules_array', function ($rules) {
    $newrules = [];
    foreach ($rules as $key => $rule) {
        if (preg_match('#^profile/#', $key)) {
            $newrules['ca/' . $key] = $rule . '&lang=ca';
        }
        $newrules[$key] = $rule;
    }

    return $newrules;
});

// WAF Filters
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

add_filter('waf_search_meta_fields', function ($args, $pattern, $post_type) {
    if ($post_type !== 'film') {
        return $args;
    }

    return ['description', 'long_description'];
}, 10, 3);
