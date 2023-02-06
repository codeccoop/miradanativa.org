function add_theme_caps()
{
    /* $user = wp_get_current_user(); */
    /* echo print_r($user->get_role_caps()); */

    // gets the administrator role
    $admins = get_role('administrator');

    $admins->add_cap('edit_festival', true);
    $admins->add_cap('read_festival', true);
    $admins->add_cap('publish_festival', true);
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
    $festival->add_cap('read_private_posts', true);
    $festival->add_cap('edit_posts', true);
    $festival->add_cap('edit_private_posts', true);
    $festival->add_cap('edit_published_posts', true);
    $festival->add_cap('edit_others_posts', false);
    $festival->add_cap('publish_posts', true);
    $festival->add_cap('unfiltered_html', true);
    // $festival->add_cap('edit_pages', false);
    // $festival->add_cap('publish_pages', false);
    $festival->add_cap('read_files', false);
    $festival->add_cap('upload_files', true);

    // $festival->add_cap('edit_pelicula', false);
    // $festival->add_cap('delete_pelicula', false);
    // $festival->add_cap('publish_pelicula', false);
    // $festival->add_cap('delete_private_peliculas', false);
    // $festival->add_cap('delete_published_peliculas', false);
    // $festival->add_cap('edit_private_peliculas', false);
    // $festival->add_cap('edit_published_peliculas', false);
    // //test
    // $festival->add_cap('edit_pelicula', false);
    // $festival->add_cap('read_pelicula', false);
    // $festival->add_cap('delete_pelicula', false);
    // $festival->add_cap('delete_peliculas', false);
    // $festival->add_cap('delete_private_peliculas', false);
    // $festival->add_cap('delete_published_peliculas', false);
    // $festival->add_cap('delete_others_peliculas', false);
    // $festival->add_cap('edit_private_peliculas', false);
    // $festival->add_cap('edit_published_peliculas', false);
    // $festival->add_cap('edit_others_peliculas', false);
    //
    // $festival->add_cap('edit_festival', false);
    // $festival->add_cap('delete_festival', false);
    // $festival->add_cap('publish_festival', false);
    // $festival->add_cap('read_private_festivals', false);
    // $festival->add_cap('read_published_festivals', false);
    // $festival->add_cap('delete_private_festivals', false);
    // $festival->add_cap('delete_published_festivals', false);
    // $festival->add_cap('edit_private_festivals', false);
    // $festival->add_cap('edit_published_festivals', false);

    $festival->add_cap('manage_categories', false);
}