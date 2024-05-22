<?php
/**
 * Grab latest post title by an author!
 *
 * @param array $data Options for the function.
 * @return string|null Post title for the latest, * or null if none.
 */
function get_catalog( $data ) {

    $params = $data->get_url_params();
    
    $args = array(
        'post_type' => 'film',
        'posts_per_page' => -1,
        
        'meta_query' => [
            'relation' => 'AND',
            [
              'key' => 'vimeo_id',
              'compare' => 'EXISTS',
            ],
            [
              'key' => 'vimeo_id',
              'compare' => '!=',
              'value' => ''
            ],
            [
                'key' => 'vimeo_id',
                'compare' => '!=',
                'value' => 0,
              ]
        ]
    );
  if(!empty($params['lang'])){
    $args['lang'] = $params['lang'];
  }
  $films = get_posts($args);

  if ( empty( $films ) ) {
    return null;
  };

  $data = array();
  foreach ($films as $film) {
    $lang=pll_get_post_language($film->ID);
    $keywords = array();
    $filmmaking = array();
    $custom_fields= get_post_meta($film->ID);
    $zona_geografica= get_the_terms($film, 'mn_zona_geografica');
    $pueblo_indigena= get_the_terms($film, 'mn_pueblo_indigena');
    $etiquetas= get_the_terms($film, 'mn_etiqueta');
    if(empty($etiquetas)){
        $keywords=null;
    } else {
        foreach ($etiquetas as $etiqueta){
            $name_etiqueta = $etiqueta->name;
            array_push($keywords,$name_etiqueta);
            
    }
    $keywords = implode(', ',$keywords);
   
    };
    $genero= get_the_terms($film, 'mn_genero');
    $metraje= get_the_terms($film, 'mn_metraje');
    $produccion= get_the_terms($film, 'mn_produccion');
    $realizacion= get_the_terms($film, 'mn_realizacion');
    if(empty($realizacion)){
      $filmmaking=null;
  } else {
      foreach ($realizacion as $value){
          $name = $value->name;
          array_push($filmmaking,$name);
          
  }
  $filmmaking = implode(', ',$filmmaking);
 
  };
    $data[] = array(
        'id' => $film->ID,
        'url' => get_the_permalink($film),
        'title' => $film->post_title,
        'slug' => $film->post_name,
        'vimeo_id'=> $custom_fields['vimeo_id'][0],
        'excerpt'=> $custom_fields['description'][0],
        'sinopsis' => $custom_fields['long_description'][0],
        'language' => $custom_fields['language'][0],
        'subtitles' => $custom_fields['subtitles'][0],
        'year' => $custom_fields['year'][0],
        'duration' => $custom_fields['duration'][0],
        'geographic_area' => $zona_geografica[0]->name,
        'indigenous_group' => $pueblo_indigena[0]->name,
        'keywords' => $keywords,
        'genre' => $genero[0]->name,
        'film_type' => $metraje[0]->name,
        'producer' => $produccion[0]->name,
        'filmmaking' => $filmmaking

    );
  }

  
  return rest_ensure_response($data);
  
}


add_action( 'rest_api_init', function () {
    register_rest_route( 'miradanativa/v1/', '/catalog/(?P<lang>\w+)', array(
      'methods' => 'GET',
      'callback' => 'get_catalog',
    ) );
    register_rest_route( 'miradanativa/v1/', '/catalog', array(
      'methods' => 'GET',
      'callback' => 'get_catalog',
    ) );
   
  } );