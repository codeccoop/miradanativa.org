<?php

add_action('init', 'mn_festival_role', 90);
function mn_festival_role()
{
    add_role('festival', __('Festival'), []);
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
