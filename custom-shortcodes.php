<?php
 
 function miradanativa_getposts_function() {
    function get_noticies_posts( $args = null ) {
        $posts = get_posts( array(
            'post_type'    => 'post',
            'numberposts'  => 3,
            'post_status'  => 'publish'
        ) );

        // throw new Exception (print_r($posts));
        return array($posts);
        
    }

    
    
    $posts = get_noticies_posts();
    $posts=$posts[0];
    $html = '<h2 class="frontpage_news_section_title"> Noticias </h2>';
    $html .= '<div class="frontpage_news">';
    foreach ($posts as $key -> $post) {
        $html .= '<div class="' . $key->$post->ID . '">';
        
        if(has_post_thumbnail( $key->$post->ID) ){ 
            $html .= get_the_post_thumbnail( $key->$post->ID);

        }
        $html .= '<h5>' . $key->$post->post_title . '</h5>';
        $category = get_the_category($key->$post->ID);
        $category=$category[0];
        $date = get_the_date('j \d\e F \d\e Y', $key->$post->ID);
        $html .= '<p class="news_meta">' . $date . ' | ' . $category->name . '</p>';
        $html .= '<p class="news_excerpt has-small-font-size">' . $key->$post->post_excerpt . '</p>';
        $html .= '<a class="news_keep_reading has-small-font-size" href="' . get_permalink( $key->$post->ID) . '" target="_blank"> <p>Continua leyendo</p>  </a>';
        $html .= '</div>';
        // $html .= '<select class="ajax_mn_filter" id="' . $taxonomy. '" multiple="multiple"">';
        
    }
    $html .= '</div>';
    $html .= '<a class="news_archive_button" href="#" target="_blank"> <p>Ver más entradas</p>  </a>';
    return $html;
}

add_shortcode('miradanativa_getposts', 'miradanativa_getposts_function');