<?php
add_action('wp_ajax_get_grid_posts', 'mn_get_grid_posts');
add_action('wp_ajax_nopriv_get_grid_posts', 'mn_get_grid_posts');

if (!function_exists('mn_get_grid_posts')) {
    function mn_get_grid_posts()
    {
        // throw new Exception (print_r('error'));
        check_ajax_referer('async_grid');
        $term = $_POST['term'];
        $page = $_POST['page'];
        $type = $_POST['type'];

        $args = array(
            'post_type' => $type,
            'post_status' => 'publish',
            'posts_per_page' => 3,
            'offset' => ($page - 1) * 3,
            // 'meta_key' => 'date',
            // 'orderby' => 'meta_value',
            'order' => 'DESC',
        );

        if ($term != 'all') {
            $args['category_name'] = $term;
        }

        $query = new WP_Query($args);

        $data = array(
            'posts' => array(),
            'pages' => 0
        );
        while ($query->have_posts()) {
            $query->the_post();
            $ID = get_the_ID();
            $thumbnail = get_the_post_thumbnail_url($ID, 'medium');
            $author = get_the_author();
            $date = get_the_date();
            $tag = get_the_tags();

            // try {
            //     $date = DateTime::createFromFormat('d/m/Y', get_field('date', $ID));
            //     $date = $date->getTimestamp();
            // } catch (Exception $e) {
            //     $date = null;
            // }
            // $hour = get_field('hour', $ID);

            if (!$thumbnail) {
                $thumbnail = get_template_directory_uri() . '/assets/images/event--default.png';
            }

            array_push($data['posts'], array(
                'id' => $ID,
                'title' => get_the_title($ID),
                'category' => get_the_category($ID),
                'excerpt' => get_the_excerpt($ID),
                'url' => get_post_permalink($ID),
                'thumbnail' => $thumbnail,
                'author' => get_the_author($ID),
                'date' => get_the_date('j \d\e F \d\e Y', $ID),
                'tag' => get_the_tags($ID)
            ));
        }
        if ($term != 'all') {
            $cat = get_term_by('slug', $term, 'category');
            $count = $cat->count;
        } else {
            $count = wp_count_posts($type);
            if ($count) {
                $count = $count->publish;
            } else {
                $count = 0;
            }
        }

        $pages = ceil($count / 3);
        $data['pages'] = $pages;

        wp_send_json($data, 200);
    }
}

add_action('wp_ajax_get_grid_pages', 'mn_get_grid_pages');
add_action('wp_ajax_nopriv_get_grid_pages', 'mn_get_grid_pages');

if (!function_exists('mn_get_grid_pages')) {
    function mn_get_grid_pages()
    {

        check_ajax_referer('async_grid');

        $term = $_POST['term'];


        $data = array();

        for ($i = 0; $i < $pages; $i++) {
            array_push($data, $i);
        }

        wp_send_json($data);
    }
}
