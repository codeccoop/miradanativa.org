<?php

function mn_parse_duration($duration) 
{
    if (empty($duration)) return null;
    preg_match('/(?:(\d+) *h[^\d]*)?(\d+) *m[^\d]*(?:(\d+) *s)?/', $duration, $matches);
  if (empty($matches)) return -1;
        
   $houres = (int) $matches[1];
   $minutes = (int) $matches[2];
   if (!isset($matches[3])) { 
         $seconds = 0;
   } else{
    $seconds = (int) $matches[3]; 
   } 
    

    return $houres * 3600 + $minutes * 60 + $seconds;
}

function mn_filter_rich_text($text)
{
    if (empty($text)) return $text;

    return preg_replace('/(\n|\r|&nbsp;)+/', ' ', strip_tags($text));
}

function mn_get_catalog($data)
{

    $params = $data->get_url_params();

    $args = [
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
            ],
            [
                'key' => 'export',
                'compare' => '=',
                'value' => 'yes',
            ],
        
        ],
        'tax_query' => array(
        array (
            'taxonomy' => 'mn_metraje',
            'field' => 'slug',
            'terms' => array ('serie', 'serie-ca'),
            'operator' => 'NOT IN',
        )
    ),
    ];

    if(!empty($params['lang'])) {
        $args['lang'] = $params['lang'];
    }

    $films = get_posts($args);

    if (empty($films)) {
        return null;
    };

    $data = array();
    foreach ($films as $film) {
        // $lang = pll_get_post_language($film->ID);
        $keywords = [];
        $filmmaking = [];

        $custom_fields = get_post_meta($film->ID);
        $zona_geografica = get_the_terms($film, 'mn_zona_geografica');
        $pueblo_indigena = get_the_terms($film, 'mn_pueblo_indigena');
        $tematicas = get_the_terms($film, 'mn_tematica');

        if (!empty($tematicas)) {
            foreach ($tematicas as $tematica) {
                $name_tematica = $tematica->name;
                array_push($keywords, $name_tematica);

            }
        };

        $genero = get_the_terms($film, 'mn_genero');
        $metraje = get_the_terms($film, 'mn_metraje');
        $produccion = get_the_terms($film, 'mn_produccion');
        $realizacion = get_the_terms($film, 'mn_realizacion');

        if (!empty($realizacion)) {
            foreach ($realizacion as $value) {
                $name = $value->name;
                array_push($filmmaking, $name);
            }
        };

        $data[] = [
            'id' => $film->ID,
            'url' => get_the_permalink($film),
            'title' => $film->post_title,
            'slug' => $film->post_name,
            'creation_date' => $film->post_date,
            'modified_date' => $film->post_modified,
            'vimeo_id' => $custom_fields['vimeo_id'][0],
            'excerpt' => mn_filter_rich_text($custom_fields['description'][0]),
            'featured_media' => isset($custom_fields['poster'][0]) ? wp_get_attachment_image_url($custom_fields['poster'][0]) : null,
            'featured_cover' => isset($custom_fields['cover'][0]) ? wp_get_attachment_image_url($custom_fields['cover'][0]) : null,
            'sinopsis' => mn_filter_rich_text($custom_fields['long_description'][0]),
            'language' => $custom_fields['language'][0],
            'subtitles' => $custom_fields['subtitles'][0],
            'year' => (int) $custom_fields['year'][0],
            'duration' => mn_parse_duration($custom_fields['duration'][0]),
            'age' => $custom_fields['age'][0],
            'geographic_area' => $zona_geografica[0]->name,
            'indigenous_group' => $pueblo_indigena[0]->name,
            'keywords' => $keywords,
            'genre' => $genero[0]->name,
            'film_type' => $metraje[0]->name,
            'producer' => $produccion[0]->name,
            'filmmaking' => $filmmaking,
        ];
    }

    return rest_ensure_response($data);
}


add_action('rest_api_init', function () {
    register_rest_route('miradanativa/v1/', '/catalog/(?P<lang>\w+)', array(
      'methods' => 'GET',
      'callback' => 'mn_get_catalog',
    ));

    register_rest_route('miradanativa/v1/', '/catalog', array(
      'methods' => 'GET',
      'callback' => 'mn_get_catalog',
    ));

});
