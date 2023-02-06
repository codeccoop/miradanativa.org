<?php
 
 function miradanativa_getposts_function() {
    function get_noticies_posts( $args = null ) {
        $posts = get_posts( array(
            'post_type'    => 'post',
            'numberposts'  => -1,
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
        
        $html .= '<div class="' . $key->$post->ID . '">' . '<h5>' . $key->$post->post_title . '</h5>';
        if(has_post_thumbnail( $key->$post->ID) ){ 
            $html .= get_the_post_thumbnail( $key->$post->ID);

        }
        $html .= '<p class="news_excerpt">' . $key->$post->post_excerpt . '</p>';
        $html .= '<a href="' . get_permalink( $key->$post->ID) . '" target="_blank"> <p>Continua leyendo</p>  </a>';
        $html .= '</div>';
        // $html .= '<select class="ajax_mn_filter" id="' . $taxonomy. '" multiple="multiple"">';
        
    }
    $html .= '</div>';
    $html .= '<a href="#" target="_blank"> <p>Ver más entradas</p>  </a>';
    return $html;
}

add_shortcode('miradanativa_getposts', 'miradanativa_getposts_function');